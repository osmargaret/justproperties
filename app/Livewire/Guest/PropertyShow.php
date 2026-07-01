<?php

namespace App\Livewire\Guest;

use App\Models\Property;
use Livewire\Component;

class PropertyShow extends Component
{
    public Property $property;
    public bool $showReportModal = false;
    public string $reportReason = '';
    public string $reportDescription = '';

    public function mount(Property $property)
    {
        $this->property = $property->load(['category', 'media', 'features', 'user']);
    }

    public function submitReport()
    {
        $this->validate([
            'reportReason' => 'required|string|max:255',
            'reportDescription' => 'nullable|string|max:1000',
        ]);

        \App\Models\PropertyReport::create([
            'property_id' => $this->property->id,
            'user_id' => auth()->id(),
            'reason' => $this->reportReason,
            'description' => $this->reportDescription,
            'status' => 'pending',
        ]);

        $this->reset(['showReportModal', 'reportReason', 'reportDescription']);
        
        session()->flash('success', 'Thank you. The property has been reported and our team will review it shortly.');
    }

    public function render()
    {
        return view('livewire.guest.property-show')->layout('layouts.app');
    }
}
