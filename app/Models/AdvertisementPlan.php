<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug',
    'name',
    'description',
    'billing_quantity',
    'billing_period',
    'impressions_included',
    'features',
    'is_active',
])]
class AdvertisementPlan extends Model
{
    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function spaces(): BelongsToMany
    {
        return $this->belongsToMany(
            AdvertisementSpace::class,
            'advertisement_plan_spaces',
            'advertisement_plan_id',
            'advertisement_space_id'
        )->withPivot('quantity');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(AdvertisementPlanPrice::class);
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(Advertisement::class);
    }
}
