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
    public function test_missing_inventory_is_reported_as_unknown(): void
    {
        $variant = new ProductVariant;
        $variant->setRelation('inventoryLevels', new Collection);

        $availability = (new AvailabilityService)->forVariant($variant);

        $this->assertSame('unknown', $availability['status']);
        $this->assertSame('Confirm availability', $availability['label']);
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

    public function test_stale_inventory_requires_confirmation(): void
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

        $this->assertSame('unknown', $availability['status']);
        $this->assertStringContainsString('no longer current', $availability['message']);
    }
}
