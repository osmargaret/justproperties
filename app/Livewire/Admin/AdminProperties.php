<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProperties extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'category')]
    public ?int $category = null;

    #[Url(as: 'status')]
    public string $status = '';

    #[Url(as: 'dir')]
    public string $sortDir = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function approve(int $propertyId): void
    {
        $property = Property::query()->findOrFail($propertyId);
        $property->update(['status' => 'active']);
    }

    public function disapprove(int $propertyId): void
    {
        $property = Property::query()->findOrFail($propertyId);
        $property->update(['status' => 'inactive']);
    }

    public function delete(int $propertyId): void
    {
        Property::query()->findOrFail($propertyId)->delete();
    }

    public function render()
    {
        $properties = Property::query()
            ->with(['user', 'category'])
            ->when($this->search !== '', function (Builder $query) {
                $query->where(function (Builder $inner) {
                    $inner->where('name', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', fn (Builder $userQuery) => $userQuery->where('name', 'like', '%'.$this->search.'%'));
                });
            })
            ->when($this->category, fn (Builder $query) => $query->where('category_id', $this->category))
            ->when($this->status !== '', fn (Builder $query) => $query->where('status', $this->status))
            ->latest('created_at')
            ->paginate(10);

        return view('livewire.admin.admin-properties', [
            'properties' => $properties,
            'categories' => Category::query()->orderBy('name','asc')->get(['id', 'name']),
            'statusOptions' => Property::query()->distinct()->pluck('status')->filter()->values(),
        ]);
    }
}
