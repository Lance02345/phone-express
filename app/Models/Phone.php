<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['name', 'price', 'image_path'];

    public function scopeSearch(Builder $query, string $search): Builder
    {
        if (config('database.default') === 'mysql') {
            return $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$search . '*']);
        }

        // Fallback to LIKE for other databases
        return $query->where('name', 'like', "%{$search}%");
    }
}
