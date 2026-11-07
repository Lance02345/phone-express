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
            return $this->listed();
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
            default => 'available',
        };

        return [
            'status' => $status,
            'label' => match ($status) {
                'available' => 'Available',
                'limited' => 'Limited availability',
                'out_of_stock' => 'Out of stock',
            },
            'message' => match ($status) {
                'available' => 'A recent stock update shows this variant as available. Confirm before payment.',
                'limited' => 'Availability is limited. Contact our team before making payment.',
                'out_of_stock' => 'This variant is currently marked out of stock. Ask about alternatives.',
            },
            'available_quantity' => null,
            'observed_at' => $levels->max('observed_at')?->toIso8601String(),
        ];
    }

    /**
     * Everything listed on the site is available unless a recent stock update says otherwise.
     *
     * @return array{status: string, label: string, message: string, available_quantity: null, observed_at: null}
     */
    private function listed(): array
    {
        return [
            'status' => 'available',
            'label' => 'Available',
            'message' => 'Available now. Message our team to arrange payment and delivery.',
            'available_quantity' => null,
            'observed_at' => null,
        ];
    }
}
