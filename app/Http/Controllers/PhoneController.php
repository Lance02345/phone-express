<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Services\Catalogue\PaymentPlanCalculator;
use Illuminate\View\View;

class PhoneController extends Controller
{
    public function show(ProductVariant $phone, PaymentPlanCalculator $paymentPlans): View
    {
        abort_unless($phone->is_active, 404);

        $phone->load(['product.brand', 'product.category', 'media']);
        $estimate = $phone->payment_plan_eligible ? $paymentPlans->estimate($phone->price) : null;

        $relatedPhones = ProductVariant::query()
            ->published()
            ->with(['product.brand', 'media'])
            ->whereKeyNot($phone->getKey())
            ->whereHas('product', fn ($query) => $query->where('brand_id', $phone->product->brand_id))
            ->whereNotNull('price_minor')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('pages.phone-show', [
            'phone' => $phone,
            'brand' => $phone->product->brand->name,
            'storage' => $phone->storage_gb ? $phone->storage_gb.'GB' : null,
            'imageAvailable' => filled($phone->image_path) && is_file(public_path($phone->image_path)),
            'relatedPhones' => $relatedPhones,
            'upfront' => $estimate['upfront'] ?? null,
            'weekly' => $estimate['weekly'] ?? null,
            'weeks' => $estimate['weeks'] ?? null,
            'whatsappUrl' => 'https://wa.me/254721920545?text='.urlencode("Hello, I am interested in {$phone->name}"),
        ]);
    }
}
