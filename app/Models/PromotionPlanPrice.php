<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['promotion_plan_id', 'currency_id', 'amount', 'is_default'])]
class PromotionPlanPrice extends Model
{
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_default' => 'boolean',
        ];
    }

    public function promotionPlan(): BelongsTo
    {
        return $this->belongsTo(PromotionPlan::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
