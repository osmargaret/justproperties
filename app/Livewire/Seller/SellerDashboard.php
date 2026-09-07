<?php

namespace App\Livewire\Seller;

use App\Models\Promotion;
use App\Models\Property;
use App\Models\ViewedProperty;
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

        // Get active listings count (published and approved)
        $activeListings = Property::query()
            ->where('user_id', $user->id)
            ->published()
            ->approved()
            ->count();

        // Get pending review (moderation) count
        $pendingReview = Property::query()
            ->where('user_id', $user->id)
            ->pending()
            ->count();

        // Get listing views in last 30 days
        $listingViews = ViewedProperty::query()
            ->whereHas('property', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Get total promotions count
        $promotionsCount = Promotion::query()
            ->whereHas('property', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        // Get top performing properties
        $topProperties = Property::query()
            ->where('user_id', $user->id)
            ->with(['latestModeration', 'activeSubscribedPropertyLink'])
            ->withCount('viewedByUsers as views')
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
