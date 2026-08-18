<?php

namespace App\Livewire\Guest;

use App\Models\Category;
use Livewire\Component;

class Welcome extends Component
{
    public string $location = '';
    public string $category_slug = '';
    public string $price_range = '';

    public function searchProperties(): mixed
    {
        $routeMap = [
            'landed-properties' => 'landed-properties',
            'uncompleted-properties' => 'uncompleted-properties',
            'completed-properties' => 'completed-properties',
            'facilities' => 'facilities',
            'rent-lease' => 'rent-lease',
            'short-let' => 'short-lets',
        ];

        $targetRoute = $routeMap[$this->category_slug] ?? 'landed-properties';

        $params = [];
        if (! empty(trim($this->location))) {
            $params['city'] = trim($this->location);
        }

        if (! empty(trim($this->price_range))) {
            $params['price_range'] = trim($this->price_range);
        }

        return redirect()->route($targetRoute, array_filter($params));
    }

    public function render()
    {
        $categories = Category::query()
            ->where('is_property', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.guest.welcome', [
            'categories' => $categories,
        ]);
    }
}
