<?php

namespace App\Http\Controllers;

use App\Models\InventoryLevel;
use App\Models\ProductVariant;
use App\Models\ProductViewMetric;
use App\Models\StaffInvitation;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        $activeVariants = ProductVariant::query()->where('is_active', true);
        $missingImages = ProductVariant::query()->with('media')->where('is_active', true)->get()
            ->filter(fn (ProductVariant $variant) => blank($variant->image_path) || ! is_file(public_path($variant->image_path)))
            ->count();

        return view('staff.dashboard', [
            'counts' => [
                'variants' => (clone $activeVariants)->count(),
                'views' => ProductViewMetric::sum('view_count'),
                'views_7d' => ProductViewMetric::where('metric_date', '>=', today()->subDays(6))->sum('view_count'),
                'missing_stock' => (clone $activeVariants)->whereDoesntHave('inventoryLevels')->count(),
                'missing_images' => $missingImages,
                'quote_required' => (clone $activeVariants)->where('quote_required', true)->count(),
            ],
            'topViewed' => ProductVariant::query()
                ->with(['product.brand', 'media'])
                ->withSum('viewMetrics', 'view_count')
                ->orderByDesc('view_metrics_sum_view_count')
                ->limit(6)
                ->get(),
            'brandInsights' => DB::table('brands')
                ->join('products', 'products.brand_id', '=', 'brands.id')
                ->join('product_variants', 'product_variants.product_id', '=', 'products.id')
                ->where('product_variants.is_active', true)
                ->groupBy('brands.id', 'brands.name')
                ->orderByDesc(DB::raw('count(product_variants.id)'))
                ->get(['brands.name', DB::raw('count(product_variants.id) as variant_count')]),
            'recentStock' => InventoryLevel::query()->with(['variant.product.brand', 'location'])->latest('observed_at')->limit(6)->get(),
            'recentInvitations' => StaffInvitation::query()->latest()->limit(6)->get(),
        ]);
    }
}
