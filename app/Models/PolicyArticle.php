<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PolicyArticle extends Model
{
    protected $fillable = [
        'key', 'slug', 'title', 'summary', 'content', 'status', 'version',
        'is_public', 'effective_at', 'reviewed_at',
    ];

    protected $casts = [
        'content' => 'array',
        'is_public' => 'boolean',
        'effective_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->where('is_public', true)->whereIn('status', ['guidance', 'approved']);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved' && $this->reviewed_at !== null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
