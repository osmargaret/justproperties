<?php

namespace App\Models;

use App\Observers\SubscribedPropertyObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['property_id', 'subscription_id'])]
#[ObservedBy([SubscribedPropertyObserver::class])]
class SubscribedProperty extends Model
{
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
