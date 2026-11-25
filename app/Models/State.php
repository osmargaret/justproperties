<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'code', 'country_id', 'latitude', 'longitude', 'timezone'])]
class State extends Model
{

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
