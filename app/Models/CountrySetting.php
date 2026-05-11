<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'country_id',
    'primary_payment_gateway',
    'secondary_payment_gateway',
    'verification_requirements',
])]
class CountrySetting extends Model
{
    protected function casts(): array
    {
        return [
            'verification_requirements' => 'array',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
