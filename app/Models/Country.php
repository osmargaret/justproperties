<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'name',
    'slug',
    'code',
    'flag',
    'phone_code',
    'language_code',
    'currency',
    'currency_code',
    'currency_symbol',
    'is_default'
])]
class Country extends Model
{
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function settings(): HasOne
    {
        return $this->hasOne(CountrySetting::class);
    }

}
