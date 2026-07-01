<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'subscription_plan_id',
    'seats',
    'days',
    'start_at',
    'end_at',
    'renew_at',
    'status',
])]
class Subscription extends Model
{
    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'renew_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function subscribedProperties(): HasMany
    {
        return $this->hasMany(SubscribedProperty::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCurrentlyActive(): bool
    {
        return $this->isActive()
            && $this->end_at !== null
            && $this->end_at->isFuture();
    }

    public function usedSeats(): int
    {
        if ($this->relationLoaded('subscribed_properties_count')) {
            return (int) $this->subscribed_properties_count;
        }

        return (int) $this->subscribedProperties()->count();
    }

    public function remainingSeats(): int
    {
        return max(0, (int) $this->seats - $this->usedSeats());
    }
}
