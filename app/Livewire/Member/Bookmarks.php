<?php

namespace App\Livewire\Member;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Bookmarks extends Component
{
    use WithPagination;

    public function remove(int $savedPropertyId): void
    {
        Auth::user()->savedProperties()->whereKey($savedPropertyId)->delete();
    }

    public function render()
    {
        return view('livewire.member.bookmarks', [
            'bookmarks' => Auth::user()->savedProperties()
                ->with('property.category', 'property.media')
                ->latest()
                ->paginate(12),
        ]);
    }
}
