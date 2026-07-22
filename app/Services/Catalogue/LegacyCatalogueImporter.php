<?php

namespace App\Services\Catalogue;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Phone;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LegacyCatalogueImporter
{
    public function __construct(private readonly LegacyPhoneMapper $mapper) {}

    /**
     * @return array<string, mixed>
     */
    public function run(bool $dryRun = true): array
    {
        $mappedPhones = Phone::query()->orderBy('id')->get()->map(
            fn (Phone $phone) => $this->mapper->map($phone)
        );

        $report = [
            'dry_run' => $dryRun,
            'legacy_phones' => $mappedPhones->count(),
            'products' => $mappedPhones->unique(fn (array $item) => $item['brand'].'|'.$item['product_name'])->count(),
            'variants' => $mappedPhones->count(),
            'quote_required' => $mappedPhones->where('quote_required', true)->count(),
            'missing_images' => $mappedPhones->filter(
                fn (array $item) => in_array('Image file is missing', $item['warnings'], true)
            )->count(),
            'warnings' => $mappedPhones->filter(fn (array $item) => $item['warnings'] !== [])
                ->map(fn (array $item) => [
                    'legacy_phone_id' => $item['legacy_phone_id'],
                    'name' => $item['label'],
                    'messages' => $item['warnings'],
                ])->values()->all(),
        ];

        if ($dryRun) {
            return $report;
        }

        DB::transaction(function () use ($mappedPhones): void {
            foreach ($mappedPhones as $item) {
                $brand = Brand::updateOrCreate(
                    ['slug' => $item['brand_slug']],
                    ['name' => $item['brand'], 'is_active' => true]
                );

                $category = Category::updateOrCreate(
                    ['slug' => Str::slug($item['category'])],
                    ['name' => $item['category'], 'is_active' => true]
                );

                $product = Product::updateOrCreate(
                    ['brand_id' => $brand->id, 'name' => $item['product_name']],
                    [
                        'category_id' => $category->id,
                        'slug' => $item['product_slug'],
                        'status' => 'active',
                        'published_at' => now(),
                    ]
                );

                $variant = ProductVariant::updateOrCreate(
                    ['source' => $item['source'], 'source_key' => $item['source_key']],
                    [
                        'product_id' => $product->id,
                        'legacy_phone_id' => $item['legacy_phone_id'],
                        'sku' => $item['sku'],
                        'label' => $item['label'],
                        'storage_gb' => $item['storage_gb'],
                        'ram_gb' => $item['ram_gb'],
                        'colour' => $item['colour'],
                        'connectivity' => $item['connectivity'],
                        'condition' => $item['condition'],
                        'price_minor' => $item['price_minor'],
                        'currency' => $item['currency'],
                        'quote_required' => $item['quote_required'],
                        'payment_plan_eligible' => $item['payment_plan_eligible'],
                        'is_active' => true,
                    ]
                );

                if (filled($item['image_path'])) {
                    ProductMedia::updateOrCreate(
                        ['product_variant_id' => $variant->id, 'sort_order' => 0],
                        [
                            'product_id' => $product->id,
                            'disk' => 'public_root',
                            'path' => $item['image_path'],
                            'alt_text' => $item['label'],
                            'is_primary' => true,
                        ]
                    );
                }
            }
        });

        $report['persisted'] = [
            'brands' => Brand::count(),
            'categories' => Category::count(),
            'products' => Product::count(),
            'variants' => ProductVariant::where('source', 'legacy_phone')->count(),
        ];

        return $report;
    }
}
