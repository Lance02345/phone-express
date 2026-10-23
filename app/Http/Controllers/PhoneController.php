<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\Analytics\ProductViewTracker;
use App\Services\Catalogue\PaymentPlanCalculator;
use App\Services\Inventory\AvailabilityService;
use Illuminate\View\View;

class PhoneController extends Controller
{
    public function show(
        ProductVariant $phone,
        PaymentPlanCalculator $paymentPlans,
        AvailabilityService $availabilityService,
        ProductViewTracker $viewTracker
    ): View {
        abort_unless($phone->is_active, 404);
        $viewTracker->record($phone);

        $phone->load(['product.brand', 'product.category', 'media', 'inventoryLevels.location']);
        $estimate = $phone->payment_plan_eligible ? $paymentPlans->estimate($phone->price) : null;
        $availability = $availabilityService->forVariant($phone);

        $options = $phone->product->variants()
            ->published()
            ->orderByRaw('price_minor is null')
            ->orderBy('price_minor')
            ->orderBy('id')
            ->get();

        $relatedPhones = ProductVariant::query()
            ->published()
            ->with(['product.brand', 'media'])
            ->where('product_id', '!=', $phone->product_id)
            ->whereHas('product', fn ($query) => $query->where('brand_id', $phone->product->brand_id))
            ->whereNotNull('price_minor')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Devices get an accessories upsell that fits them, same brand first (AirPods with an iPhone, Buds with a Galaxy).
        $fits = match ($phone->product->category->name) {
            'Smartphones' => fn (ProductVariant $v) => in_array($v->product->category->name, ['Audio', 'Watches'], true) || str_contains($v->product->name, 'Adapter'),
            'Tablets' => fn (ProductVariant $v) => $v->product->category->name === 'Audio' || preg_match('/Pencil|Keyboard/', $v->product->name) === 1,
            'Laptops', 'Desktops' => fn (ProductVariant $v) => $v->product->category->name === 'Audio' || preg_match('/Mouse|Adapter/', $v->product->name) === 1,
            default => null,
        };

        $pairings = $fits
            ? ProductVariant::query()
                ->published()
                ->with(['product.brand', 'product.category', 'media'])
                ->whereHas('product.category', fn ($query) => $query->whereIn('name', ['Audio', 'Watches', 'Accessories']))
                ->whereNotNull('price_minor')
                ->orderBy('price_minor')
                ->get()
                ->unique('product_id')
                ->filter($fits)
                ->sortBy(fn (ProductVariant $variant) => [
                    $variant->product->brand_id === $phone->product->brand_id ? 0 : 1,
                    md5($variant->product_id.$phone->getKey()),
                ])
                ->take(4)
                ->values()
            : collect();

        return view('pages.phone-show', [
            'phone' => $phone,
            'brand' => $phone->product->brand->name,
            'storage' => $phone->storage_gb ? $phone->storage_gb.'GB' : null,
            'imageAvailable' => filled($phone->image_path) && is_file(public_path($phone->image_path)),
            'options' => $options,
            'pairings' => $pairings,
            'relatedPhones' => $relatedPhones,
            'upfront' => $estimate['upfront'] ?? null,
            'weekly' => $estimate['weekly'] ?? null,
            'weeks' => $estimate['weeks'] ?? null,
            'whatsappUrl' => 'https://wa.me/254721920545?text='.urlencode("Hello, I am interested in {$phone->name}"),
            'availability' => $availability,
        ]);
    }
}
