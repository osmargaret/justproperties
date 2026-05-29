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

        if ($moderation->moderatable_type === 'user') {
            $moderation->moderatable?->update(['verified_at' => now()]);
        }

        $moderation->update([
            'status' => 'approved',
            'moderated_by' => auth()->id(),
        ]);
        session()->flash('status', __('Moderation approved.'));
    }

    public function reject(int $id, string $reason = ''): void
    {
        $moderation = Moderation::query()->findOrFail($id);
        $moderation->update([
            'status' => 'rejected',
            'moderated_by' => auth()->id(),
            'reason' => $reason,
        ]);
        session()->flash('status', __('Moderation rejected.'));
    }

    public function render()
    {
        $query = Moderation::query()
            ->with('moderator')
            ->with('moderatable')
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
