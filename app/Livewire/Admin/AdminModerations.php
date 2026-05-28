<?php

namespace App\Livewire\Admin;

use App\Models\Moderation;
use Livewire\Component;

class AdminModerations extends Component
{
    public string $filter = 'pending';

    public function approve(int $id): void
    {
        $moderation = Moderation::query()->findOrFail($id);
        $moderation->update([
            'status' => 'approved',
            'actor_id' => auth()->id(),
            'action' => 'approved',
        ]);
        session()->flash('status', __('Moderation approved.'));
    }

    public function reject(int $id, string $reason = ''): void
    {
        $moderation = Moderation::query()->findOrFail($id);
        $moderation->update([
            'status' => 'rejected',
            'actor_id' => auth()->id(),
            'action' => 'rejected',
            'reason' => $reason,
        ]);
        session()->flash('status', __('Moderation rejected.'));
    }

    public function render()
    {
        $query = Moderation::query()
            ->with(['property.user.country', 'actor'])
            ->orderBy('created_at');

        if ($this->filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($this->filter === 'processed') {
            $query->whereIn('status', ['approved', 'rejected']);
        }

        $moderations = $query->get();

        return view('livewire.admin.admin-moderations', [
            'moderations' => $moderations,
        ]);
    }
}
