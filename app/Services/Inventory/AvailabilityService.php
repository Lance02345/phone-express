<?php

namespace App\Services\Inventory;

use App\Models\InventoryLevel;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;

class AvailabilityService
{
    /**
     * @return array{status: string, label: string, message: string, available_quantity: int|null, observed_at: string|null}
     */
    public function forVariant(ProductVariant $variant): array
    {
        $levels = $variant->relationLoaded('inventoryLevels')
            ? $variant->inventoryLevels
            : $variant->inventoryLevels()->with('location')->get();

        $activeLevels = $levels->filter(fn (InventoryLevel $level) => $level->location?->is_active ?? true);
        $freshLevels = $activeLevels->filter(fn (InventoryLevel $level) => $this->isFresh($level));

        if ($freshLevels->isEmpty()) {
            return $this->unknown($activeLevels->isNotEmpty());
        }

        $exactLevels = $freshLevels->where('tracking_mode', 'exact');
        if ($exactLevels->isNotEmpty() && $exactLevels->count() === $freshLevels->count()) {
            return $this->fromExactLevels($exactLevels);
        }

        return $this->fromCoarseLevels($freshLevels);
    }

    private function isFresh(InventoryLevel $level): bool
    {
        return $level->observed_at !== null
            && $level->observed_at->gte(now()->subHours(config('catalogue.inventory_stale_after_hours')));
    }

    /**
     * @param  Collection<int, InventoryLevel>  $levels
     * @return array{status: string, label: string, message: string, available_quantity: int, observed_at: string|null}
     */
    private function fromExactLevels(Collection $levels): array
    {
        $available = $levels->sum(fn (InventoryLevel $level) => $level->availableQuantity() ?? 0);

        return [
            'status' => $available > 0 ? 'available' : 'out_of_stock',
            'label' => $available > 0 ? 'Available' : 'Out of stock',
            'message' => $available > 0
                ? 'A recent stock update shows this variant as available. Confirm before payment.'
                : 'A recent stock update shows no available units. Ask about alternatives.',
            'available_quantity' => $available,
            'observed_at' => $levels->max('observed_at')?->toIso8601String(),
        ];
    }

    /**
     * @param  Collection<int, InventoryLevel>  $levels
     * @return array{status: string, label: string, message: string, available_quantity: null, observed_at: string|null}
     */
    private function fromCoarseLevels(Collection $levels): array
    {
        $status = match (true) {
            $levels->contains('status', 'available') => 'available',
            $levels->contains('status', 'limited') => 'limited',
            $levels->every(fn (InventoryLevel $level) => $level->status === 'out_of_stock') => 'out_of_stock',
            default => 'unknown',
        };

        return [
            'status' => $status,
            'label' => match ($status) {
                'available' => 'Available',
                'limited' => 'Limited availability',
                'out_of_stock' => 'Out of stock',
                default => 'Confirm availability',
            },
            'message' => match ($status) {
                'available' => 'A recent stock update shows this variant as available. Confirm before payment.',
                'limited' => 'Availability is limited. Contact our team before making payment.',
                'out_of_stock' => 'This variant is currently marked out of stock. Ask about alternatives.',
                default => 'Our team needs to confirm the latest stock position.',
            },
            'available_quantity' => null,
            'observed_at' => $levels->max('observed_at')?->toIso8601String(),
        ];
    }

    /**
     * @return array{status: string, label: string, message: string, available_quantity: null, observed_at: null}
     */
    private function unknown(bool $hasStaleData): array
    {
        return [
            'status' => 'unknown',
            'label' => 'Confirm availability',
            'message' => $hasStaleData
                ? 'The last stock update is no longer current. Please confirm with our team.'
                : 'Stock has not yet been connected for this variant. Please confirm with our team.',
            'available_quantity' => null,
            'observed_at' => null,
        ];
    }
}
