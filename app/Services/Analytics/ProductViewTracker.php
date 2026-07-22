<?php

namespace App\Services\Analytics;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductViewTracker
{
    public function record(ProductVariant $variant): void
    {
        DB::statement(
            'INSERT INTO product_view_metrics (product_variant_id, metric_date, view_count, created_at, updated_at)
             VALUES (?, CURRENT_DATE, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
             ON CONFLICT (product_variant_id, metric_date)
             DO UPDATE SET view_count = product_view_metrics.view_count + 1, updated_at = CURRENT_TIMESTAMP',
            [$variant->getKey()]
        );
    }
}
