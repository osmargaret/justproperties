<?php

namespace App\Services\Notifications;

use App\Models\Property;
use App\Models\PropertyAlert;
use App\Notifications\PropertyAlertNotification;

class NotifiesPropertyAlertSubscribers
{
    public function notify(Property $property): void
    {
        PropertyAlert::query()
            ->where('category_id', $property->category_id)
            ->where('status', 'active')
            ->where(function ($query) use ($property): void {
                $query->whereNull('property_id')->orWhere('property_id', $property->id);
            })
            ->with('user')
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->each(fn ($user) => $user->notify(new PropertyAlertNotification($property)));
    }
}
