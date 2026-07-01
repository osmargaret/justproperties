<?php

namespace App\Livewire\Guest\Concerns;

use App\Models\Category;
use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

trait DisplaysCategoryProperties
{
    use WithPagination;

    abstract protected function getCategorySlug(): string;

    #[Computed]
    public function properties()
    {
        return Property::whereHas('category', function ($query) {
                $query->where('slug', $this->getCategorySlug());
            })
            ->where('status', 'published')
            ->with(['media', 'features'])
            ->latest()
            ->paginate(12);
    }
}
