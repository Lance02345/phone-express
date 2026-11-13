<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsEvent extends Model
{
    public const UPDATED_AT = null;

    public const NAMES = ['whatsapp_click', 'call_click', 'email_click', 'outbound_click'];

    protected $guarded = ['id'];

    protected $casts = ['local_date' => 'date', 'created_at' => 'datetime'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
