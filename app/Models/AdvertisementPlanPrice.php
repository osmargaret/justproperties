<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['advertisement_plan_id', 'currency_id', 'amount', 'is_default'])]
class AdvertisementPlanPrice extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_default' => 'boolean',
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
