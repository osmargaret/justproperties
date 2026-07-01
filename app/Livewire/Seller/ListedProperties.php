<?php

namespace App\Livewire\Seller;

use App\Models\Property;
use App\Models\Moderation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ListedProperties extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = '';

    public $filterModeration = '';

    public $sortBy = 'latest';

    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterModeration()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::query()
            ->with(['category'])
            ->where('user_id', Auth::id());

        // Search filter
        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%');
        }

        // Status filter (based on is_published)
        if ($this->filterStatus) {
            if ($this->filterStatus === 'published') {
                $query->where('is_published', true);
            } elseif ($this->filterStatus === 'draft') {
                $query->where('is_published', false);
            }
        }

        // Moderation status filter - get the latest moderation status
        if ($this->filterModeration) {
            $query->leftJoinSub(
                (new Moderation)
                    ->select('moderatable_id', 'status')
                    ->whereColumn('moderatable_id', 'properties.id')
                    ->where('moderatable_type', Property::class)
                    ->latestOfMany(),
                'latest_moderation',
                function ($join) {
                    $join->on('properties.id', '=', 'latest_moderation.moderatable_id');
                }
            )
            ->where('latest_moderation.status', $this->filterModeration);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_high':
                $query->orderByDesc('cost');
                break;
            case 'price_low':
                $query->orderBy('cost');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $properties = $query->paginate($this->perPage);

        return view('livewire.seller.listed-properties', [
            'properties' => $properties,
        ]);
    }
}
