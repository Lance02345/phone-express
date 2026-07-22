<?php

namespace Tests\Unit;

use App\Models\Phone;
use App\Services\Catalogue\LegacyPhoneMapper;
use PHPUnit\Framework\TestCase;

class LegacyPhoneMapperTest extends TestCase
{
    private LegacyPhoneMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new LegacyPhoneMapper;
    }

    public function test_it_maps_a_phone_to_a_product_variant_without_losing_ram(): void
    {
        $mapped = $this->mapper->map($this->phone(
            12,
            'Samsung Galaxy S24 Ultra 5G 512GB + 12GB RAM',
            90000,
            null
        ));

        $this->assertSame('Samsung', $mapped['brand']);
        $this->assertSame('Samsung Galaxy S24 Ultra', $mapped['product_name']);
        $this->assertSame(512, $mapped['storage_gb']);
        $this->assertSame(12, $mapped['ram_gb']);
        $this->assertSame('5G', $mapped['connectivity']);
        $this->assertSame(9000000, $mapped['price_minor']);
        $this->assertFalse($mapped['quote_required']);
        $this->assertSame('LEGACY-PHONE-000012', $mapped['sku']);
    }

    public function test_it_maps_colour_esim_and_terabyte_storage(): void
    {
        $mapped = $this->mapper->map($this->phone(
            25,
            'iPhone 17 Pro Max 2TB E-Sim (Orange)',
            280000,
            null
        ));

        $this->assertSame('Apple', $mapped['brand']);
        $this->assertSame('iPhone 17 Pro Max', $mapped['product_name']);
        $this->assertSame(2048, $mapped['storage_gb']);
        $this->assertSame('Orange', $mapped['colour']);
        $this->assertSame('E-SIM', $mapped['connectivity']);
    }

    public function test_zero_price_becomes_an_explicit_quote_required_state(): void
    {
        $mapped = $this->mapper->map($this->phone(31, 'Oppo A6 Pro 5G 256GB + 8GB RAM', 0, null));

        $this->assertNull($mapped['price_minor']);
        $this->assertTrue($mapped['quote_required']);
    }

    public function test_it_classifies_tablets(): void
    {
        $mapped = $this->mapper->map($this->phone(44, 'Redmi Pad 2 4G 128GB + 4GB RAM', 20000, null));

        $this->assertSame('Tablets', $mapped['category']);
        $this->assertSame('Redmi Pad 2', $mapped['product_name']);
    }

    public function test_plus_models_receive_distinct_url_slugs(): void
    {
        $standard = $this->mapper->map($this->phone(50, 'Samsung Galaxy Note 10 5G 256GB', 26000, null));
        $plus = $this->mapper->map($this->phone(51, 'Samsung Galaxy Note 10+ 5G 256GB', 33000, null));

        $this->assertSame('samsung-galaxy-note-10', $standard['product_slug']);
        $this->assertSame('samsung-galaxy-note-10-plus', $plus['product_slug']);
        $this->assertNotSame($standard['product_slug'], $plus['product_slug']);
    }

    private function phone(int $id, string $name, int $price, ?string $imagePath): Phone
    {
        $phone = new Phone([
            'name' => $name,
            'price' => $price,
            'image_path' => $imagePath,
        ]);
        $phone->id = $id;

        return $phone;
    }
}
