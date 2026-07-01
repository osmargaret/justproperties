<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'code',
    'quantity',
    'limit_per_user',

    'start_at',
    'expires_at',

    'discount',

    'eligible_items',
    'is_published',
])]
class Coupon extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'expires_at' => 'datetime',

            'discount' => 'decimal:2',

            'eligible_items' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
