<?php

namespace App\Observers;

use App\Models\Moderation;
use App\Models\Property;

class PropertyObserver
{
    public function created(Property $property): void
    {
        if ($property->is_published && $this->hasSubscription($property)) {
            $this->createModerationRecord($property, 'created');
        }
    }

    public function updated(Property $property): void
    {
        if ($property->wasChanged('is_published') && $property->is_published && $this->hasSubscription($property)) {
            $this->createModerationRecord($property, 'updated');
        }
    }

    protected function hasSubscription(Property $property): bool
    {
        if ($property->relationLoaded('activeSubscribedPropertyLink')) {
            return $property->activeSubscribedPropertyLink !== null;
        }

        return (bool) $property->activeSubscribedPropertyLink()->exists();
    }

    protected function createModerationRecord(Property $property, string $action): void
    {
        Moderation::create([
            'moderatable_type' => Property::class,
            'moderatable_id' => $property->id,
            'action' => $action,
            'status' => 'pending',
            'reason' => null,
            'moderated_by' => null,
        ]);
    }
}
