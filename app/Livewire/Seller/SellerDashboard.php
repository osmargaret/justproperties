<?php

namespace App\Livewire\Seller;

use App\Models\Promotion;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SellerDashboard extends Component
{
    public function mount(): void
    {
        $user = Auth::user();
        if ($user && $user->active_role !== 'seller') {
            $user->forceFill(['active_role' => 'seller'])->save();
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Get active listings count
        $activeListings = Property::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Get pending review (moderation) count
        $pendingReview = Property::where('user_id', $user->id)
            ->where('moderation_status', 'pending')
            ->count();

        // Get listing views in last 30 days (using property views field if available)
        $listingViews = Property::where('user_id', $user->id)
            ->where('status', 'active')
            ->sum('views') ?? 0;

        // Get total promotions count
        $promotionsCount = Promotion::whereHas('property', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        // Get top performing properties
        $topProperties = Property::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        return view('livewire.seller.seller-dashboard', [
            'activeListings' => $activeListings,
            'pendingReview' => $pendingReview,
            'listingViews' => $listingViews,
            'promotionsCount' => $promotionsCount,
            'topProperties' => $topProperties,
        ]);
    }
}
