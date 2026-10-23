<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\Catalogue\PaymentPlanCalculator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardsController extends Controller
{
    private const ACCESSORY_CATEGORIES = ['Audio', 'Watches', 'Accessories'];

    public function index(PaymentPlanCalculator $paymentPlans)
    {
        $fullPhones = ProductVariant::query()
            ->published()
            ->with(['product.brand', 'media'])
            ->whereHas('product.category', fn ($query) => $query->where('name', 'Smartphones'))
            ->whereNotNull('price_minor')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $lipaPhones = ProductVariant::query()
            ->published()
            ->with(['product.brand', 'media'])
            ->whereNotNull('price_minor')
            ->where('payment_plan_eligible', true)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $lipaPhones->each(function (ProductVariant $phone) use ($paymentPlans): void {
            $estimate = $paymentPlans->estimate($phone->price);
            $phone->lipa_upfront = $estimate['upfront'] ?? null;
            $phone->lipa_installment = $estimate['weekly'] ?? null;
            $phone->lipa_weeks = $estimate['weeks'] ?? null;
        });

        $categories = Cache::remember('catalogue_category_counts_v4', now()->addHour(), fn () => [
            'audio' => $this->countInCategory('Audio'),
            'watches' => $this->countInCategory('Watches'),
            'accessories' => $this->countInCategory('Accessories'),
            'all' => Product::query()->where('status', 'active')->count(),
            'iphone' => Product::query()->where('status', 'active')
                ->whereHas('brand', fn ($query) => $query->where('name', 'Apple'))
                ->whereHas('category', fn ($query) => $query->where('name', 'Smartphones'))->count(),
            'macbook' => Product::query()->where('status', 'active')
                ->whereHas('brand', fn ($query) => $query->where('name', 'Apple'))
                ->whereHas('category', fn ($query) => $query->where('name', 'Laptops'))->count(),
            'samsung' => Product::query()->where('status', 'active')
                ->whereHas('brand', fn ($query) => $query->where('name', 'Samsung'))->count(),
        ]);

        $statistics = [
            'phones_sold' => 10000,
            'happy_customers' => 25000,
            'years_experience' => 8,
            'branches' => 2,
        ];

        $accessories = $this->featuredAccessories();

        return view('pages.landing', compact('fullPhones', 'lipaPhones', 'categories', 'statistics', 'accessories'));
    }

    private function countInCategory(string $category): int
    {
        return Product::query()->where('status', 'active')
            ->whereHas('category', fn ($query) => $query->where('name', $category))
            ->count();
    }

    /**
     * One card per accessory product (its cheapest priced option), pictured ones first.
     *
     * @return Collection<int, ProductVariant>
     */
    private function featuredAccessories(): Collection
    {
        return ProductVariant::query()
            ->published()
            ->with(['product.brand', 'product.category', 'media'])
            ->whereHas('product.category', fn ($query) => $query->whereIn('name', self::ACCESSORY_CATEGORIES))
            ->whereNotNull('price_minor')
            ->orderBy('price_minor')
            ->get()
            ->groupBy('product_id')
            ->map(function (Collection $options) {
                $cheapest = $options->first();
                $cheapest->has_price_spread = $options->pluck('price_minor')->unique()->count() > 1;

                return $cheapest;
            })
            ->sortBy(fn (ProductVariant $variant) => [
                filled($variant->image_path) && is_file(public_path($variant->image_path)) ? 0 : 1,
                md5($variant->product_id.now()->toDateString()),
            ])
            ->take(10)
            ->values();
    }
}
