<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'property_id',
    'user_id',
    'booking_date',
    'buyer_time',
    'seller_date',
    'seller_time',
    'confirmed_date',
    'confirmed_time',
    'status',
    'inspection_fee',
])]
class Inspection extends Model
{
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'buyer_time' => 'string',
            'seller_date' => 'date',
            'seller_time' => 'string',
            'confirmed_date' => 'date',
            'confirmed_time' => 'string',
            'inspection_fee' => 'decimal:2',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
