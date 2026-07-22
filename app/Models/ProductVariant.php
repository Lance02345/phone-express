<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function getRouteKeyName(): string
    {
        return 'legacy_phone_id';
    }

    public function getNameAttribute(): string
    {
        return $this->label;
    }

    public function getPriceAttribute(): int
    {
        return $this->price_minor === null ? 0 : (int) round($this->price_minor / 100);
    }

    public function getImagePathAttribute(): ?string
    {
        return $this->media->sortByDesc('is_primary')->sortBy('sort_order')->first()?->path;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereHas('product', fn (Builder $product) => $product
                ->where('status', 'active')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now()));
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        $operator = config('database.default') === 'pgsql' ? 'ilike' : 'like';

        return $query->where(function (Builder $query) use ($operator, $search): void {
            $query->where('label', $operator, "%{$search}%")
                ->orWhere('sku', $operator, "%{$search}%")
                ->orWhereHas('product', fn (Builder $product) => $product
                    ->where('name', $operator, "%{$search}%"));
        });
    }
}
