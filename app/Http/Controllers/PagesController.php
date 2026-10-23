<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\Catalogue\PaymentPlanCalculator;
use App\Services\Inventory\AvailabilityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PagesController extends Controller
{
    private const PRICE_RANGES = [
        '0-20000' => ['min' => 1, 'max' => 20000],
        '0-50000' => ['min' => 1, 'max' => 50000],
        '20000-50000' => ['min' => 20000, 'max' => 50000],
        '50000-80000' => ['min' => 50000, 'max' => 80000],
        '50000-100000' => ['min' => 50000, 'max' => 100000],
        '80000+' => ['min' => 80000, 'max' => null],
        '100000-200000' => ['min' => 100000, 'max' => 200000],
        '200000+' => ['min' => 200000, 'max' => null],
    ];

    public const CATEGORIES = ['Smartphones', 'Tablets', 'Laptops', 'Desktops', 'Watches', 'Audio', 'Accessories'];

    private const STORAGE_CATEGORIES = ['Smartphones', 'Tablets', 'Laptops', 'Desktops'];

    private const AVAILABILITY_RANK = ['available' => 0, 'limited' => 1, 'unknown' => 2, 'out_of_stock' => 3];

    private const SORT_OPTIONS = [
        'newest' => ['field' => 'created_at', 'direction' => 'desc'],
        'price_asc' => ['field' => 'price_minor', 'direction' => 'asc'],
        'price_desc' => ['field' => 'price_minor', 'direction' => 'desc'],
        'name_asc' => ['field' => 'label', 'direction' => 'asc'],
        'name_desc' => ['field' => 'label', 'direction' => 'desc'],
    ];

    public function pricing(
        Request $request,
        PaymentPlanCalculator $paymentPlans,
        AvailabilityService $availabilityService
    ): View {
        $sort = $request->string('sort')->toString() ?: 'featured';
        $paymentMethod = $request->string('payment_method')->toString() ?: 'full';
        $isLipa = $paymentMethod === 'lipa';

        // One card per product; the filters decide which of its variants (storage, colour…) are shown.
        $variantFilter = fn (Builder $variants, array $ignore = []) => $this->filterVariants($variants, $request, $isLipa, $ignore);

        $query = $this->publishedProducts()
            ->whereHas('variants', $variantFilter)
            ->with([
                'brand',
                'category',
                'variants' => fn ($variants) => $variantFilter($variants->getQuery())
                    ->with(['media', 'inventoryLevels.location'])
                    ->orderByRaw('price_minor is null')
                    ->orderBy('price_minor')
                    ->orderBy('id'),
            ])
            ->withMin(['variants as min_price_minor' => $variantFilter], 'price_minor');

        $this->sortProducts($query, $sort);

        $products = $query->paginate($this->getPerPage($request))->appends($request->except('page'));

        $products->getCollection()->each(function (Product $product) use ($availabilityService, $paymentPlans, $isLipa): void {
            $this->decorateProduct($product, $availabilityService, $paymentPlans, $isLipa);
        });

        $category = in_array($request->string('category')->toString(), self::CATEGORIES, true)
            ? $request->string('category')->toString()
            : '';

        $filters = [
            'search' => $request->string('search')->toString(),
            'brand' => $request->string('brand')->toString(),
            'category' => $category,
            'price_range' => $request->string('price_range')->toString(),
            'storage' => $request->string('storage')->toString(),
            'sort' => $sort,
            'payment_method' => $paymentMethod,
            'result_count' => $products->total(),
        ];

        return view('pages.pricing', [
            'products' => $products,
            'filters' => $filters,
            'categoryCounts' => $this->facetCounts('categories', $variantFilter),
            'brandCounts' => $this->facetCounts('brands', $variantFilter),
            'showStorage' => $category === '' || in_array($category, self::STORAGE_CATEGORIES, true),
        ]);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $search = trim($request->string('q')->limit(80)->toString());

        if (mb_strlen($search) < 2) {
            return response()->json(['success' => false, 'suggestions' => []]);
        }

        $suggestions = ProductVariant::query()
            ->published()
            ->search($search)
            ->inRandomOrder()
            ->limit(5)
            ->pluck('label')
            ->all();

        return response()->json(['success' => true, 'suggestions' => $suggestions]);
    }

    public function apiPricing(Request $request, AvailabilityService $availabilityService): JsonResponse|RedirectResponse
    {
        if (! $request->expectsJson() && ! $request->ajax()) {
            return redirect()->route('pricing');
        }

        $query = $this->catalogueQuery();
        $this->filterVariants($query, $request);
        $this->applySorting($query, $request->string('sort')->toString() ?: 'random');

        $phones = $query->paginate($this->getPerPage($request));

        return response()->json([
            'success' => true,
            'data' => $phones->getCollection()->map(fn (ProductVariant $phone) => [
                'id' => $phone->legacy_phone_id,
                'sku' => $phone->sku,
                'name' => $phone->name,
                'brand' => $phone->product->brand->name,
                'storage_gb' => $phone->storage_gb,
                'price' => $phone->price,
                'currency' => $phone->currency,
                'quote_required' => $phone->quote_required,
                'image_path' => $phone->image_path,
                'url' => route('phones.show', $phone),
                'availability' => $availabilityService->forVariant($phone),
            ])->values(),
            'meta' => [
                'current_page' => $phones->currentPage(),
                'last_page' => $phones->lastPage(),
                'total' => $phones->total(),
            ],
            'filters' => $request->only(['search', 'brand', 'category', 'price_range', 'storage', 'sort']),
        ]);
    }

    private function catalogueQuery(): Builder
    {
        return ProductVariant::query()->published()->with(['product.brand', 'media', 'inventoryLevels.location']);
    }

    private function publishedProducts(): Builder
    {
        return Product::query()
            ->where('status', 'active')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  array<int, string>  $ignore  filters to leave out, so facet counts show what each choice would return
     */
    private function filterVariants(Builder $query, Request $request, bool $lipaOnly = false, array $ignore = []): Builder
    {
        $query->published();

        $search = trim($request->string('search')->limit(100)->toString());
        if ($search !== '') {
            $query->search($search);
        }

        $brand = trim($request->string('brand')->limit(80)->toString());
        if ($brand !== '' && ! in_array('brand', $ignore, true)) {
            $query->whereHas('product.brand', fn (Builder $brandQuery) => $brandQuery->where('name', $brand));
        }

        $category = trim($request->string('category')->limit(80)->toString());
        if (in_array($category, self::CATEGORIES, true) && ! in_array('category', $ignore, true)) {
            $query->whereHas('product.category', fn (Builder $categoryQuery) => $categoryQuery->where('name', $category));
        }

        $priceRange = $request->string('price_range')->toString();
        if (isset(self::PRICE_RANGES[$priceRange])) {
            $range = self::PRICE_RANGES[$priceRange];
            $minimum = $range['min'] * 100;
            $range['max'] === null
                ? $query->where('price_minor', '>=', $minimum)
                : $query->whereBetween('price_minor', [$minimum, $range['max'] * 100]);
        }

        $storage = $request->integer('storage');
        if (in_array($storage, [64, 128, 256, 512, 1024, 2048], true)) {
            $query->where('storage_gb', $storage);
        }

        if ($lipaOnly) {
            $query->where('payment_plan_eligible', true)->whereNotNull('price_minor');
        }

        return $query;
    }

    /**
     * Product counts per category or brand, honouring every other active filter.
     *
     * @return Collection<string, int>
     */
    private function facetCounts(string $table, \Closure $variantFilter): Collection
    {
        $column = $table === 'categories' ? 'category_id' : 'brand_id';
        $ignore = $table === 'categories' ? ['category'] : ['brand'];

        return $this->publishedProducts()
            ->whereHas('variants', fn (Builder $variants) => $variantFilter($variants, $ignore))
            ->join($table, "{$table}.id", '=', "products.{$column}")
            ->selectRaw("{$table}.name as facet, count(*) as aggregate")
            ->groupBy("{$table}.name")
            ->orderBy("{$table}.name")
            ->pluck('aggregate', 'facet')
            ->map(fn ($count) => (int) $count);
    }

    private function sortProducts(Builder $query, string $sort): void
    {
        $nullsLast = config('database.default') === 'pgsql'
            ? fn (string $direction) => "min_price_minor {$direction} nulls last"
            : fn (string $direction) => "min_price_minor is null, min_price_minor {$direction}";

        match ($sort) {
            'price_asc' => $query->orderByRaw($nullsLast('asc')),
            'price_desc' => $query->orderByRaw($nullsLast('desc')),
            'name_asc' => $query->orderBy('products.name'),
            'newest' => $query->orderByDesc('products.created_at'),
            // Shuffled once a day, so paging through "Featured" never repeats or skips a product.
            default => $query->orderByRaw("md5(concat(products.id, '".now()->toDateString()."'))"),
        };

        $query->orderBy('products.id');
    }

    private function decorateProduct(Product $product, AvailabilityService $availability, PaymentPlanCalculator $paymentPlans, bool $isLipa): void
    {
        $variants = $product->variants;
        $lead = $variants->first(fn (ProductVariant $variant) => $variant->price_minor !== null) ?? $variants->first();

        $product->lead_variant = $lead;
        $product->image = $variants
            ->map(fn (ProductVariant $variant) => $variant->image_path)
            ->first(fn (?string $path) => filled($path) && is_file(public_path($path)));
        $product->from_price = $lead?->price ?: null;
        $product->has_price_spread = $variants->pluck('price_minor')->filter()->unique()->count() > 1;
        $product->option_labels = $variants
            ->flatMap(fn (ProductVariant $variant) => [
                $variant->storage_gb ? ($variant->storage_gb >= 1024 ? ($variant->storage_gb / 1024).'TB' : $variant->storage_gb.'GB') : null,
                $variant->colour,
            ])
            ->filter()
            ->unique()
            ->values();
        $product->availability = $variants
            ->map(fn (ProductVariant $variant) => $availability->forVariant($variant))
            ->sortBy(fn (array $status) => self::AVAILABILITY_RANK[$status['status']] ?? 9)
            ->first();

        if ($isLipa && $lead?->payment_plan_eligible) {
            $product->lipa = $paymentPlans->estimate($lead->price);
        }
    }

    private function applySorting(Builder $query, string $sort): void
    {
        if (! isset(self::SORT_OPTIONS[$sort])) {
            $query->inRandomOrder();

            return;
        }

        $sortOption = self::SORT_OPTIONS[$sort];
        $query->orderBy($sortOption['field'], $sortOption['direction'])->orderBy('id');
    }

    private function getPerPage(Request $request): int
    {
        $perPage = $request->integer('per_page', 24);

        return in_array($perPage, [12, 24, 48, 96], true) ? $perPage : 24;
    }
}
