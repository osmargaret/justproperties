<?php

namespace App\Livewire\Member;

use App\Models\Promotion;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        return view('livewire.member.dashboard', [
            'activeListings' => Property::query()
                ->where('user_id', $user->id)
                ->published()
                ->approved()
                ->count(),
            'pendingListings' => Property::query()
                ->where('user_id', $user->id)
                ->pending()
                ->count(),
            'properties' => $user->properties()
                ->with(['media', 'latestModeration'])
                ->latest()
                ->take(5)
                ->get(),
            'promotionsCount' => Promotion::query()
                ->where('user_id', $user->id)
                ->count(),
            'viewedPosts' => $user->viewedPosts()
                ->with('post.category', 'post.media')
                ->latest('updated_at')
                ->take(5)
                ->get(),
        ]);
    }
}
