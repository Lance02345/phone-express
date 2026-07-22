<?php

namespace App\Http\Controllers;

use App\Models\ProductMedia;
use App\Models\ProductVariant;
use App\Models\StaffActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StaffCatalogueController extends Controller
{
    public function index(Request $request): View
    {
        $query = ProductVariant::query()->with(['product.brand', 'media'])->orderBy('label');
        if ($request->filled('search')) {
            $query->search(trim($request->string('search')->limit(100)->toString()));
        }

        return view('staff.catalogue.index', ['variants' => $query->paginate(30)->withQueryString()]);
    }

    public function edit(ProductVariant $variant): View
    {
        return view('staff.catalogue.edit', ['variant' => $variant->load(['product.brand', 'media'])]);
    }

    public function update(Request $request, ProductVariant $variant): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'storage_gb' => ['nullable', 'integer', 'min:1', 'max:4096'],
            'ram_gb' => ['nullable', 'integer', 'min:1', 'max:256'],
            'colour' => ['nullable', 'string', 'max:80'],
            'connectivity' => ['nullable', 'string', 'max:40'],
            'condition' => ['required', Rule::in(['new', 'refurbished', 'used'])],
            'quote_required' => ['nullable', 'boolean'],
            'payment_plan_eligible' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $before = $variant->only(['label', 'price_minor', 'storage_gb', 'ram_gb', 'colour', 'connectivity', 'condition', 'quote_required', 'payment_plan_eligible', 'is_active']);
        $quoteRequired = $request->boolean('quote_required') || ! filled($validated['price'] ?? null);
        $variant->update([
            'label' => $validated['label'],
            'price_minor' => $quoteRequired ? null : ((int) $validated['price'] * 100),
            'storage_gb' => $validated['storage_gb'] ?? null,
            'ram_gb' => $validated['ram_gb'] ?? null,
            'colour' => $validated['colour'] ?? null,
            'connectivity' => $validated['connectivity'] ?? null,
            'condition' => $validated['condition'],
            'quote_required' => $quoteRequired,
            'payment_plan_eligible' => $request->boolean('payment_plan_eligible'),
            'is_active' => $request->boolean('is_active'),
            'is_manually_managed' => true,
        ]);

        if ($request->hasFile('image')) {
            File::ensureDirectoryExists(public_path('Images/catalogue'));
            $file = $request->file('image');
            $filename = Str::uuid().'.'.$file->extension();
            $file->move(public_path('Images/catalogue'), $filename);
            ProductMedia::updateOrCreate(
                ['product_variant_id' => $variant->id, 'sort_order' => 0],
                ['product_id' => $variant->product_id, 'disk' => 'public_root', 'path' => 'Images/catalogue/'.$filename, 'alt_text' => $variant->label, 'is_primary' => true]
            );
        }

        StaffActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'catalogue.variant_updated',
            'subject_type' => ProductVariant::class,
            'subject_id' => $variant->id,
            'changes' => ['before' => $before, 'after' => $variant->fresh()->only(array_keys($before))],
        ]);

        Cache::forget('landing_catalogue_full_v2');
        Cache::forget('landing_catalogue_lipa_v2');
        Cache::forget('catalogue_category_counts_v2');

        return redirect()->route('staff.catalogue.edit', $variant)->with('status', 'Catalogue item updated.');
    }
}
