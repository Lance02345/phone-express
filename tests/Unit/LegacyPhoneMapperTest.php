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
        $this->assertFalse($mapped['payment_plan_eligible']);
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
        $this->assertTrue($mapped['payment_plan_eligible']);
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

    public function test_it_classifies_macbooks_and_excludes_them_from_payment_plans(): void
    {
        $mapped = $this->mapper->map($this->phone(
            45,
            'MacBook Pro 14-inch M5 Pro 24GB RAM 1TB SSD',
            350000,
            null
        ));

        $this->assertSame('Apple', $mapped['brand']);
        $this->assertSame('Laptops', $mapped['category']);
        $this->assertSame(1024, $mapped['storage_gb']);
        $this->assertSame(24, $mapped['ram_gb']);
        $this->assertFalse($mapped['payment_plan_eligible']);
    }

    public function test_plus_models_receive_distinct_url_slugs(): void
    {
        $standard = $this->mapper->map($this->phone(50, 'Samsung Galaxy Note 10 5G 256GB', 26000, null));
        $plus = $this->mapper->map($this->phone(51, 'Samsung Galaxy Note 10+ 5G 256GB', 33000, null));

        $this->assertSame('samsung-galaxy-note-10', $standard['product_slug']);
        $this->assertSame('samsung-galaxy-note-10-plus', $plus['product_slug']);
        $this->assertNotSame($standard['product_slug'], $plus['product_slug']);
    }

    public function test_it_recognizes_new_brands_and_keeps_samsung_regions_out_of_colour(): void
    {
        $samsung = $this->mapper->map($this->phone(
            52,
            'Samsung Galaxy A56 256GB + 8GB RAM (East Africa)',
            48000,
            null
        ));
        $honor = $this->mapper->map($this->phone(53, 'Honor X5c 64GB + 4GB RAM', 14400, null));
        $itel = $this->mapper->map($this->phone(54, 'Itel A06 64GB + 2GB RAM', 10500, null));

        $this->assertSame('Samsung Galaxy A56', $samsung['product_name']);
        $this->assertNull($samsung['colour']);
        $this->assertSame('Honor', $honor['brand']);
        $this->assertSame('Itel', $itel['brand']);
    }

    public function test_it_classifies_wearables_audio_accessories_and_desktops(): void
    {
        $watch = $this->mapper->map($this->phone(60, 'Apple Watch Ultra 3 49mm (Stainless)', 108000, null));
        $buds = $this->mapper->map($this->phone(61, 'Samsung Galaxy Buds3 Pro', 18500, null));
        $airpods = $this->mapper->map($this->phone(62, 'AirPods Pro 3 (2 Years Warranty)', 32000, null));
        $pencil = $this->mapper->map($this->phone(63, 'Apple Pencil Pro', 18500, null));
        $macMini = $this->mapper->map($this->phone(64, 'Mac mini M4 16GB RAM 256GB SSD', 113500, null));

        $this->assertSame('Watches', $watch['category']);
        $this->assertSame('Stainless', $watch['colour']);
        $this->assertSame('Audio', $buds['category']);
        $this->assertSame('Apple', $airpods['brand']);
        $this->assertSame('Audio', $airpods['category']);
        $this->assertNull($airpods['colour']);
        $this->assertSame('Accessories', $pencil['category']);
        $this->assertNotContains('Storage could not be identified', $pencil['warnings']);
        $this->assertFalse($pencil['payment_plan_eligible']);
        $this->assertSame('Apple', $macMini['brand']);
        $this->assertSame('Desktops', $macMini['category']);
        $this->assertSame(256, $macMini['storage_gb']);
        $this->assertFalse($macMini['payment_plan_eligible']);
    }

    public function test_it_reads_tablet_connectivity_and_new_brands(): void
    {
        $tab = $this->mapper->map($this->phone(70, 'Samsung Galaxy Tab S10 FE 128GB + 8GB RAM (WiFi)', 58000, null));
        $oneplus = $this->mapper->map($this->phone(71, 'OnePlus 15 256GB + 12GB RAM', 107000, null));
        $nothing = $this->mapper->map($this->phone(72, 'Nothing Phone 3a Lite 128GB + 8GB RAM', 37000, null));
        $poco = $this->mapper->map($this->phone(73, 'Poco X8 Pro 512GB + 12GB RAM', 63000, null));

        $this->assertSame('Tablets', $tab['category']);
        $this->assertSame('WiFi', $tab['connectivity']);
        $this->assertNull($tab['colour']);
        $this->assertSame('Samsung Galaxy Tab S10 FE', $tab['product_name']);
        $this->assertSame('OnePlus', $oneplus['brand']);
        $this->assertSame('Nothing', $nothing['brand']);
        $this->assertSame('Xiaomi', $poco['brand']);
        $this->assertSame('Poco X8 Pro', $poco['product_name']);
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
