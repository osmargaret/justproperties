<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'image',
    'description',
    'advertisement_plan_id',
    'currency_id',
    'company',
    'email',
    'amount',
    'payment_method',
    'payment_status',
    'receipt',
    'start_date',
    'end_date',
])]
class Advertisement extends Model
{
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function advertisementPlan(): BelongsTo
    {
        return $this->belongsTo(AdvertisementPlan::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
