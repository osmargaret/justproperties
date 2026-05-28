<?php

namespace App\Livewire\Admin;

use App\Models\Moderation;
use App\Models\Property;
use Livewire\Component;

class AdminPropertyDetails extends Component
{
    public Property $property;

    public function mount(Property $property): void
    {
        $this->property = $property;
    }

    public function approve(): void
    {
        $this->property->update(['status' => 'active']);
        $this->logModeration('approved', 'approve');
    }

    public function disapprove(): void
    {
        $this->property->update(['status' => 'inactive']);
        $this->logModeration('rejected', 'disapprove');
    }

    public function delete(): mixed
    {
        $propertyId = $this->property->id;
        $this->logModeration('deleted', 'delete');
        $this->property->delete();
        session()->flash('status', __('Property #:id deleted.', ['id' => $propertyId]));

        return redirect()->route('admin.properties');
    }

    private function logModeration(string $status, string $action): void
    {
        Moderation::query()->create([
            'property_id' => $this->property->id,
            'actor_id' => auth()->id(),
            'status' => $status,
            'action' => $action,
            'reason' => null,
        ]);
    }

    public function render()
    {
        $this->property->load(['user', 'category', 'media', 'subscriptionLinks.subscription.plan', 'promotions.plan']);
        $moderations = Moderation::query()
            ->where('property_id', $this->property->id)
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('livewire.admin.admin-property-details', ['moderations' => $moderations]);
    }
}
