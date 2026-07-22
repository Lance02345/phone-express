<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecificationDefinition extends Model
{
    protected $fillable = ['key', 'label', 'unit', 'value_type', 'is_filterable'];

    protected $casts = ['is_filterable' => 'boolean'];

    public function productSpecifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }
}
