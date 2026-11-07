<?php

namespace Tests\Unit;

use App\Models\InventoryLevel;
use App\Models\Location;
use App\Models\ProductVariant;
use App\Services\Inventory\AvailabilityService;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class AvailabilityServiceTest extends TestCase
{
    public function test_listed_product_without_inventory_is_available(): void
    {
        $variant = new ProductVariant;
        $variant->setRelation('inventoryLevels', new Collection);

        $availability = (new AvailabilityService)->forVariant($variant);

        $this->assertSame('available', $availability['status']);
        $this->assertSame('Available', $availability['label']);
        $this->assertNull($availability['available_quantity']);
    }

    public function test_fresh_exact_inventory_uses_on_hand_minus_reserved(): void
    {
        $location = new Location(['name' => 'Nairobi', 'code' => 'NAIROBI', 'is_active' => true]);
        $level = new InventoryLevel([
            'tracking_mode' => 'exact',
            'status' => 'available',
            'quantity_on_hand' => 5,
            'quantity_reserved' => 2,
            'observed_at' => now(),
        ]);
        $level->setRelation('location', $location);

        $variant = new ProductVariant;
        $variant->setRelation('inventoryLevels', new Collection([$level]));

        $availability = (new AvailabilityService)->forVariant($variant);

        $this->assertSame('available', $availability['status']);
        $this->assertSame(3, $availability['available_quantity']);
    }

    public function test_stale_inventory_falls_back_to_available(): void
    {
        $location = new Location(['name' => 'Nairobi', 'code' => 'NAIROBI', 'is_active' => true]);
        $level = new InventoryLevel([
            'tracking_mode' => 'coarse',
            'status' => 'available',
            'observed_at' => now()->subDays(2),
        ]);
        $level->setRelation('location', $location);

        $variant = new ProductVariant;
        $variant->setRelation('inventoryLevels', new Collection([$level]));

        $availability = (new AvailabilityService)->forVariant($variant);

        $this->assertSame('available', $availability['status']);
    }

    public function test_recent_out_of_stock_update_is_still_shown(): void
    {
        $location = new Location(['name' => 'Nairobi', 'code' => 'NAIROBI', 'is_active' => true]);
        $level = new InventoryLevel([
            'tracking_mode' => 'coarse',
            'status' => 'out_of_stock',
            'observed_at' => now(),
        ]);
        $level->setRelation('location', $location);

        $variant = new ProductVariant;
        $variant->setRelation('inventoryLevels', new Collection([$level]));

        $availability = (new AvailabilityService)->forVariant($variant);

        $this->assertSame('out_of_stock', $availability['status']);
        $this->assertSame('Out of stock', $availability['label']);
    }
}
