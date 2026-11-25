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
    'country_id',
    'currency_code',
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
    'gateway',
    'details',
    'gateway_payload',
    'status',
    'paid_at',
    'receipt',
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
            'gateway_payload' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'currency_code');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function payable(): Attribute
    {
        return Attribute::make(get: fn (): float => (float) $this->total);
    }



    protected function currencyCode(): Attribute
    {
        return Attribute::make(get: fn (?string $value): string => strtoupper((string) ($value ?: ($this->country?->currency_code ?? 'NGN'))));
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed' || $this->status === 'success';
    }

    protected function isSuccessful(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->isCompleted());
    }
}
