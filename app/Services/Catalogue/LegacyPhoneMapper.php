<?php

namespace App\Services\Catalogue;

use App\Models\Phone;
use Illuminate\Support\Str;

class LegacyPhoneMapper
{
    private const BRANDS = [
        'iphone' => 'Apple',
        'samsung' => 'Samsung',
        'google pixel' => 'Google',
        'redmi' => 'Redmi',
        'oppo' => 'Oppo',
        'vivo' => 'Vivo',
        'tecno' => 'Tecno',
        'infinix' => 'Infinix',
    ];

    /**
     * @return array<string, mixed>
     */
    public function map(Phone $phone): array
    {
        $brand = $this->brand($phone->name);
        $storageGb = $this->storageGb($phone->name);
        $ramGb = $this->ramGb($phone->name);
        $colour = $this->colour($phone->name);
        $connectivity = $this->connectivity($phone->name);
        $productName = $this->productName($phone->name, $colour);
        $warnings = [];

        if ($brand === 'Unknown') {
            $warnings[] = 'Brand could not be identified';
        }

        if ($storageGb === null) {
            $warnings[] = 'Storage could not be identified';
        }

        if (blank($phone->image_path) || ! is_file(public_path($phone->image_path))) {
            $warnings[] = 'Image file is missing';
        }

        return [
            'legacy_phone_id' => $phone->getKey(),
            'source' => 'legacy_phone',
            'source_key' => (string) $phone->getKey(),
            'brand' => $brand,
            'brand_slug' => Str::slug($brand),
            'category' => $this->isTablet($phone->name) ? 'Tablets' : 'Smartphones',
            'product_name' => $productName,
            'product_slug' => Str::slug(str_replace('+', ' plus ', $productName)),
            'sku' => sprintf('LEGACY-PHONE-%06d', $phone->getKey()),
            'label' => $phone->name,
            'storage_gb' => $storageGb,
            'ram_gb' => $ramGb,
            'colour' => $colour,
            'connectivity' => $connectivity,
            'condition' => 'new',
            'price_minor' => $phone->price > 0 ? $phone->price * 100 : null,
            'currency' => 'KES',
            'quote_required' => $phone->price <= 0,
            'payment_plan_eligible' => false,
            'image_path' => $phone->image_path,
            'warnings' => $warnings,
        ];
    }

    private function brand(string $name): string
    {
        $lowerName = Str::lower($name);

        foreach (self::BRANDS as $prefix => $brand) {
            if (Str::startsWith($lowerName, $prefix)) {
                return $brand;
            }
        }

        return 'Unknown';
    }

    private function storageGb(string $name): ?int
    {
        if (! preg_match('/\b(\d+)\s*(GB|TB)\b/i', $name, $matches)) {
            return null;
        }

        $value = (int) $matches[1];

        return Str::upper($matches[2]) === 'TB' ? $value * 1024 : $value;
    }

    private function ramGb(string $name): ?int
    {
        return preg_match('/(?:\+\s*)?(\d+)\s*GB\s+RAM\b/i', $name, $matches)
            ? (int) $matches[1]
            : null;
    }

    private function colour(string $name): ?string
    {
        if (! preg_match('/\(([^)]+)\)\s*$/', $name, $matches)) {
            return null;
        }

        $value = trim($matches[1]);

        return Str::contains(Str::lower($value), ['sim card', 'model']) ? null : $value;
    }

    private function connectivity(string $name): ?string
    {
        if (preg_match('/\bE-?Sim\b/i', $name)) {
            return 'E-SIM';
        }

        if (preg_match('/\b5G\b/i', $name)) {
            return '5G';
        }

        if (preg_match('/\b4G\b/i', $name)) {
            return '4G';
        }

        return null;
    }

    private function productName(string $name, ?string $colour): string
    {
        $productName = $name;

        if ($colour !== null) {
            $productName = preg_replace('/\s*\('.preg_quote($colour, '/').'\)\s*$/i', '', $productName);
        }

        $productName = preg_replace('/\s*\+\s*\d+\s*GB\s+RAM\b/i', '', $productName);
        $productName = preg_replace('/\s+\d+\s*(?:GB|TB)\b/i', '', $productName);
        $productName = preg_replace('/\s+E-?Sim\b/i', '', $productName);
        $productName = preg_replace('/\s+(?:4G|5G)\b/i', '', $productName);
        $productName = preg_replace('/\s+/', ' ', (string) $productName);

        return trim($productName);
    }

    private function isTablet(string $name): bool
    {
        return preg_match('/\b(?:Pad|XPAD|Megapad)\b/i', $name) === 1;
    }
}
