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
    'limit_for_user',
    'start_at',
    'expires_at',
    'is_percentage',
    'discount',
    'discount_cap',
    'minimum_spend',
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
            'is_percentage' => 'boolean',
            'discount' => 'decimal:2',
            'discount_cap' => 'decimal:2',
            'minimum_spend' => 'decimal:2',
            'eligible_items' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
