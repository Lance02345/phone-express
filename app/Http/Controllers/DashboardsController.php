<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\Catalogue\PaymentPlanCalculator;
use Illuminate\Support\Facades\Cache;

class DashboardsController extends Controller
{
    public function index(PaymentPlanCalculator $paymentPlans)
    {
        $fullPhones = ProductVariant::query()
            ->published()
            ->with(['product.brand', 'media'])
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

        $categories = Cache::remember('catalogue_category_counts_v2', now()->addHour(), fn () => [
            'all' => Product::query()->where('status', 'active')->count(),
            'iphone' => Product::query()->where('status', 'active')
                ->whereHas('brand', fn ($query) => $query->where('name', 'Apple'))->count(),
            'samsung' => Product::query()->where('status', 'active')
                ->whereHas('brand', fn ($query) => $query->where('name', 'Samsung'))->count(),
        ]);

        $statistics = [
            'phones_sold' => 10000,
            'happy_customers' => 25000,
            'years_experience' => 8,
            'branches' => 2,
        ];

        return view('pages.landing', compact('fullPhones', 'lipaPhones', 'categories', 'statistics'));
    }
}
