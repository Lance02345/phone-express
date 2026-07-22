<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['name', 'price', 'image_path'];

    public function scopeSearch(Builder $query, string $search): Builder
    {
        $driver = config('database.default');

        if ($driver === 'mysql') {
            return $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$search . '*']);
        }

        return $query->where(
            'name',
            $driver === 'pgsql' ? 'ilike' : 'like',
            "%{$search}%"
        );
    }
}
