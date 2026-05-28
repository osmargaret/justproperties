<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['user_id', 'property_id', 'promotion_plan_id', 'promotable_id', 'promotable_type', 'start_at', 'end_at', 'usage', 'status'])]
class Promotion extends Model
{
    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'usage' => 'array',
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

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PromotionPlan::class, 'promotion_plan_id');
    }

    public function promotable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->status === 'active');
    }
}
