<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['slug', 'name', 'description', 'format', 'dimensions', 'icon', 'sort_order', 'is_active'])]
class AdvertisementSpace extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(
            AdvertisementPlan::class,
            'advertisement_plan_spaces',
            'advertisement_space_id',
            'advertisement_plan_id'
        )->withPivot('quantity');
    }
}
