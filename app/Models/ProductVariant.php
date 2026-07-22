<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'legacy_phone_id', 'sku', 'label', 'storage_gb', 'ram_gb',
        'colour', 'connectivity', 'condition', 'price_minor', 'currency',
        'quote_required', 'payment_plan_eligible', 'is_active', 'source', 'source_key',
    ];

    protected $casts = [
        'quote_required' => 'boolean',
        'payment_plan_eligible' => 'boolean',
        'is_active' => 'boolean',
        'price_minor' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function legacyPhone(): BelongsTo
    {
        return $this->belongsTo(Phone::class, 'legacy_phone_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }
}
