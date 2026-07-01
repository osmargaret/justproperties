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
        $pendingModeration = Moderation::query()
            ->where('moderatable_type', Property::class)
            ->where('moderatable_id', $this->property->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingModeration) {
            $pendingModeration->update([
                'status' => 'approved',
                'moderated_by' => auth()->id(),
            ]);
        }

        $this->property->update(['is_published' => true]);
        $this->property->refresh();
        $this->logModeration('approved', 'approve');
        session()->flash('status', __('Property approved.'));
    }

    public function disapprove(): void
    {
        $pendingModeration = Moderation::query()
            ->where('moderatable_type', Property::class)
            ->where('moderatable_id', $this->property->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingModeration) {
            $pendingModeration->update([
                'status' => 'rejected',
                'moderated_by' => auth()->id(),
            ]);
        }

        $this->property->update(['is_published' => false]);
        $this->property->refresh();
        $this->logModeration('rejected', 'disapprove');
        session()->flash('status', __('Property disapproved.'));
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
            'moderatable_type' => Property::class,
            'moderatable_id' => $this->property->id,
            'moderated_by' => auth()->id(),
            'status' => $status,
            'action' => $action,
            'reason' => null,
        ]);
    }

    public function render()
    {
        $this->property->load([
            'user',
            'category',
            'media',
            'subscribedPropertyLinks.subscription.plan',
            'promotions.plan',
        ]);
        $moderations = Moderation::query()
            ->where('moderatable_type', Property::class)
            ->where('moderatable_id', $this->property->id)
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('livewire.admin.admin-property-details', ['moderations' => $moderations]);
    }
}
