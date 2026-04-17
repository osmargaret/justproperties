<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'user_id',
    'currency_id',
    'paymentable_id',
    'paymentable_type',
    'reference',
    'request_id',
    'amount',
    'coupon_id',
    'coupon_value',
    'vat_rate',
    'vat_value',
    'total',
    'method',
    'status',
])]
class Payment extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'coupon_value' => 'decimal:2',
            'vat_rate' => 'decimal:2',
            'vat_value' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function isSuccessful(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->status === 'completed');
    }
}
