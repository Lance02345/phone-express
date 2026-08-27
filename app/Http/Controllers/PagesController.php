<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\ProductVariant;
use App\Services\Catalogue\PaymentPlanCalculator;
use App\Services\Inventory\AvailabilityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{
    private const PRICE_RANGES = [
        '0-50000' => ['min' => 1, 'max' => 50000],
        '50000-80000' => ['min' => 50000, 'max' => 80000],
        '80000+' => ['min' => 80000, 'max' => null],
    ];

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
        $query = $this->catalogueQuery();
        $sort = $request->string('sort')->toString() ?: 'random';
        $paymentMethod = $request->string('payment_method')->toString() ?: 'full';

        $this->applyFilters($query, $request);

        if ($paymentMethod === 'lipa') {
            $query->where('payment_plan_eligible', true)->whereNotNull('price_minor');
        }

        $this->applySorting($query, $sort);

        $phones = $query->paginate($this->getPerPage($request))->appends($request->except('page'));

        $phones->getCollection()->each(function (ProductVariant $phone) use ($availabilityService): void {
            $phone->availability = $availabilityService->forVariant($phone);
        });

        if ($paymentMethod === 'lipa') {
            $phones->getCollection()->each(function (ProductVariant $phone) use ($paymentPlans): void {
                $estimate = $paymentPlans->estimate($phone->price);
                $phone->lipa_upfront = $estimate['upfront'] ?? null;
                $phone->lipa_installment = $estimate['weekly'] ?? null;
                $phone->lipa_weeks = $estimate['weeks'] ?? null;
            });
        }

        $filters = [
            'search' => $request->string('search')->toString(),
            'brand' => $request->string('brand')->toString(),
            'category' => $request->string('category')->toString(),
            'price_range' => $request->string('price_range')->toString(),
            'storage' => $request->string('storage')->toString(),
            'sort' => $sort,
            'payment_method' => $paymentMethod,
            'result_count' => $phones->total(),
        ];

        return view('pages.pricing', [
            'phones' => $phones,
            'filters' => $filters,
            'brands' => Brand::query()->where('is_active', true)->orderBy('name')->get(['name']),
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
        $this->applyFilters($query, $request);
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

    private function applyFilters(Builder $query, Request $request): void
    {
        $search = trim($request->string('search')->limit(100)->toString());
        if ($search !== '') {
            $query->search($search);
        }

        $brand = trim($request->string('brand')->limit(80)->toString());
        if ($brand !== '') {
            $query->whereHas('product.brand', fn (Builder $brandQuery) => $brandQuery->where('name', $brand));
        }

        $category = trim($request->string('category')->limit(80)->toString());
        if (in_array($category, ['Smartphones', 'Laptops', 'Tablets'], true)) {
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
        $perPage = $request->integer('per_page', 12);

        return in_array($perPage, [12, 24, 48, 96], true) ? $perPage : 12;
    }
}
