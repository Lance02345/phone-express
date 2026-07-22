<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductViewMetric extends Model
{
    protected $fillable = ['product_variant_id', 'metric_date', 'view_count'];

    protected $casts = ['metric_date' => 'date', 'view_count' => 'integer'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
