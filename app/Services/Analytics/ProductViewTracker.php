<?php

namespace App\Services\Analytics;

use App\Models\ProductVariant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductViewTracker
{
    public function record(ProductVariant $variant): void
    {
        try {
            $attributes = [
                'product_variant_id' => $variant->getKey(),
                'metric_date' => today()->toDateString(),
            ];

            if ($this->incrementExisting($attributes)) {
                return;
            }

            try {
                DB::table('product_view_metrics')->insert([
                    ...$attributes,
                    'view_count' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (QueryException $exception) {
                // A concurrent request may have inserted today's row first.
                if (! $this->incrementExisting($attributes)) {
                    throw $exception;
                }
            }
        } catch (Throwable $exception) {
            // Analytics must never prevent a customer from viewing a phone.
            report($exception);
        }
    }

    /**
     * @param  array{product_variant_id: int, metric_date: string}  $attributes
     */
    private function incrementExisting(array $attributes): bool
    {
        return DB::table('product_view_metrics')
            ->where($attributes)
            ->increment('view_count', 1, ['updated_at' => now()]) > 0;
    }
}
