<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLevel extends Model
{
    protected $fillable = [
        'product_variant_id', 'location_id', 'tracking_mode', 'status',
        'quantity_on_hand', 'quantity_reserved', 'source', 'source_key', 'observed_at',
    ];

    protected $casts = [
        'quantity_on_hand' => 'integer',
        'quantity_reserved' => 'integer',
        'observed_at' => 'datetime',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function availableQuantity(): ?int
    {
        if ($this->tracking_mode !== 'exact') {
            return null;
        }

        return max(0, $this->quantity_on_hand - $this->quantity_reserved);
    }
}
