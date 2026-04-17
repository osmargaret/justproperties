<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'code',
    'symbol',
    'symbol_position',
    'thousands_separator',
    'decimal_separator',
    'decimal_multiplier',
    'is_default',
    'is_active',
])]
class Currency extends Model
{
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'country_currencies')
            ->withTimestamps();
    }

    protected function display(): Attribute
    {
        return Attribute::make(
            get: fn (): string => trim(($this->symbol ?? '').' '.$this->code)
        );
    }
}
