<?php

namespace App\Livewire\Seller;

use App\Models\Category;
use App\Models\CategorySetting;
use Illuminate\View\View;
use Livewire\Component;

class ListProperty extends Component
{
    /** Selected row from `categories` (drives `category_settings` fields). */
    public ?int $listing_category_id = null;

    /**
     * Values for dynamic category fields, keyed by `category_settings.key`.
     * Multi-select keys hold string[]; scalars hold string|int|null.
     *
     * @var array<string, mixed>
     */
    public array $dynamicAttributes = [];

    public function updatedListingCategoryId(mixed $value): void
    {
        $this->dynamicAttributes = [];
        $id = $value !== null && $value !== '' ? (int) $value : null;
        if (! $id) {
            return;
        }
        $category = Category::query()->with('settings')->find($id);
        foreach ($category?->settings ?? [] as $setting) {
            if ($setting->data_type === CategorySetting::TYPE_MULTI_ENUM) {
                $this->dynamicAttributes[$setting->key] = [];
            }
        }
    }

    public function render(): View
    {
        return view('livewire.seller.list-property', [
            'categories' => Category::query()->with('settings')->orderBy('name')->get(),
        ]);
    }
}
