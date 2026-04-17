<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['property_id', 'promotion_plan_id', 'start_at', 'end_at', 'status'])]
class Promotion extends Model
{
    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PromotionPlan::class, 'promotion_plan_id');
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->status === 'active');
    }
}
