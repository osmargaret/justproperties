<?php

namespace App\Services\Subscriptions;

use App\Models\Property;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ManagesSubscriptionProperties
{
    public function assign(Property $property, Subscription $subscription, User $owner): SubscribedProperty
    {
        $this->assertOwner($property, $owner);
        $this->assertOwnerSubscription($subscription, $owner);
        $this->assertSubscriptionUsable($subscription);

        if ($this->isPropertyOnSubscription($property, $subscription)) {
            return SubscribedProperty::query()
                ->where('property_id', $property->id)
                ->where('subscription_id', $subscription->id)
                ->firstOrFail();
        }

        if ($subscription->remainingSeats() < 1) {
            throw ValidationException::withMessages([
                'subscription_id' => __('This subscription has no seats left.'),
            ]);
        }

        return DB::transaction(function () use ($property, $subscription) {
            SubscribedProperty::query()
                ->where('property_id', $property->id)
                ->where('subscription_id', '!=', $subscription->id)
                ->delete();

            return SubscribedProperty::query()->firstOrCreate([
                'property_id' => $property->id,
                'subscription_id' => $subscription->id,
            ]);
        });
    }

    public function remove(Property $property, Subscription $subscription, User $owner): void
    {
        $this->assertOwner($property, $owner);
        $this->assertOwnerSubscription($subscription, $owner);

        SubscribedProperty::query()
            ->where('property_id', $property->id)
            ->where('subscription_id', $subscription->id)
            ->delete();
    }

    public function isPropertyOnSubscription(Property $property, Subscription $subscription): bool
    {
        return SubscribedProperty::query()
            ->where('property_id', $property->id)
            ->where('subscription_id', $subscription->id)
            ->exists();
    }

    protected function assertOwner(Property $property, User $owner): void
    {
        if ((int) $property->user_id !== (int) $owner->id) {
            throw ValidationException::withMessages([
                'property' => __('You do not own this property.'),
            ]);
        }
    }

    protected function assertOwnerSubscription(Subscription $subscription, User $owner): void
    {
        if ((int) $subscription->user_id !== (int) $owner->id) {
            throw ValidationException::withMessages([
                'subscription_id' => __('You do not own this subscription.'),
            ]);
        }
    }

    protected function assertSubscriptionUsable(Subscription $subscription): void
    {
        if (! $subscription->isCurrentlyActive()) {
            throw ValidationException::withMessages([
                'subscription_id' => __('This subscription is not active.'),
            ]);
        }
    }
}
