<?php

namespace App\Livewire\Seller\Concerns;

use App\Models\Category;
use App\Models\CategorySetting;
use App\Models\Property;
use App\Models\PropertyFeature;
use Illuminate\Support\Collection;

trait ManagesPropertyListingFields
{
    /** @var array<string, mixed> */
    public array $dynamicAttributes = [];

    protected function hydrateDynamicAttributesFromProperty(Property $property): void
    {
        $this->dynamicAttributes = [];

        $property->loadMissing('features', 'category.settings');

        foreach ($property->features as $row) {
            $decoded = json_decode($row->value, true);
            $this->dynamicAttributes[$row->feature] = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                ? $decoded
                : $row->value;
        }

        foreach ($property->category?->settings ?? [] as $setting) {
            if (array_key_exists($setting->key, $this->dynamicAttributes)) {
                continue;
            }

            $this->dynamicAttributes[$setting->key] = $this->defaultForCategorySetting($setting);
        }
    }

    protected function resetDynamicAttributesForCategory(?int $categoryId): void
    {
        $this->dynamicAttributes = [];

        if (! $categoryId) {
            return;
        }

        $category = Category::query()->with('settings')->find($categoryId);
        foreach ($category?->settings ?? [] as $setting) {
            $this->dynamicAttributes[$setting->key] = $this->defaultForCategorySetting($setting);
        }
    }

    protected function defaultForCategorySetting(CategorySetting $setting): mixed
    {
        $default = $setting->default_value;

        return match ($setting->data_type) {
            CategorySetting::TYPE_MULTI_ENUM => is_array($default) ? $default : [],
            CategorySetting::TYPE_BOOLEAN => (bool) ($default ?? false),
            default => is_array($default) ? null : $default,
        };
    }

    /**
     * @return array<string, list<mixed>>
     */
    protected function buildDynamicRules(Collection $settings): array
    {
        $rules = [];
        foreach ($settings as $setting) {
            $base = $setting->is_required ? ['required'] : ['nullable'];
            $path = 'dynamicAttributes.'.$setting->key;
            switch ($setting->data_type) {
                case CategorySetting::TYPE_NUMBER:
                    $rules[$path] = [...$base, 'numeric'];
                    break;
                case CategorySetting::TYPE_MULTI_ENUM:
                    $rules[$path] = [...$base, 'array'];
                    $rules[$path.'.*'] = ['string'];
                    break;
                case CategorySetting::TYPE_BOOLEAN:
                    $rules[$path] = [...$base, 'boolean'];
                    break;
                case CategorySetting::TYPE_DATE:
                    $rules[$path] = [...$base, 'date'];
                    break;
                default:
                    $rules[$path] = [...$base, 'string', 'max:255'];
                    break;
            }
        }

        return $rules;
    }

    protected function syncPropertyFeatures(Property $property): void
    {
        PropertyFeature::query()->where('property_id', $property->id)->delete();

        foreach ($this->dynamicAttributes as $feature => $value) {
            if ($value === null || $value === '' || $value === []) {
                continue;
            }

            PropertyFeature::query()->create([
                'property_id' => $property->id,
                'feature' => $feature,
                'value' => is_array($value) ? json_encode(array_values($value)) : (string) $value,
                'unit' => null,
            ]);
        }
    }

    /**
     * @return array<string, string>
     */
    protected function propertyListingValidationAttributes(): array
    {
        return [
            'property.name' => 'property title',
            'property.category_id' => 'listing category',
            'property.cost' => 'cost',
            'property.state_id' => 'state',
            'property.city' => 'city/LGA',
            'uploadedImages' => 'property images',
        ];
    }
}
