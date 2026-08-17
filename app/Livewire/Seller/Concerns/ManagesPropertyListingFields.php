<?php

namespace App\Livewire\Seller\Concerns;

use App\Models\Category;
use App\Models\CategoryField;
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

        $property->loadMissing('features', 'category.fields');

        foreach ($property->features as $row) {
            $decoded = json_decode($row->value, true);
            $this->dynamicAttributes[$row->feature] = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                ? $decoded
                : $row->value;
        }

        foreach ($property->category?->fields ?? [] as $field) {
            if (array_key_exists($field->key, $this->dynamicAttributes)) {
                continue;
            }

            $this->dynamicAttributes[$field->key] = $this->defaultForCategoryField($field);
        }
    }

    protected function resetDynamicAttributesForCategory(?int $categoryId): void
    {
        $this->dynamicAttributes = [];

        if (! $categoryId) {
            return;
        }

        $category = Category::query()->with('fields')->find($categoryId);
        foreach ($category?->fields ?? [] as $field) {
            $this->dynamicAttributes[$field->key] = $this->defaultForCategoryField($field);
        }
    }

    protected function defaultForCategoryField(CategoryField $field): mixed
    {
        $default = $field->default_value;

        return match ($field->data_type) {
            CategoryField::TYPE_MULTI_SELECT => is_array($default) ? $default : [],
            CategoryField::TYPE_BOOLEAN => (bool) ($default ?? false),
            default => is_array($default) ? null : $default,
        };
    }

    /**
     * @return array<string, list<mixed>>
     */
    protected function buildDynamicRules(Collection $settings): array
    {
        $rules = [];
        foreach ($settings as $field) {
            $base = $field->is_required ? ['required'] : ['nullable'];
            $path = 'dynamicAttributes.'.$field->key;
            switch ($field->data_type) {
                case CategoryField::TYPE_NUMBER:
                    $rules[$path] = [...$base, 'numeric'];
                    break;
                case CategoryField::TYPE_MULTI_SELECT:
                    $rules[$path] = [...$base, 'array'];
                    $rules[$path.'.*'] = ['string'];
                    break;
                case CategoryField::TYPE_BOOLEAN:
                    $rules[$path] = [...$base, 'boolean'];
                    break;
                case CategoryField::TYPE_DATE:
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

            $stringValue = match (true) {
                is_bool($value) => $value ? '1' : '0',
                is_array($value) => json_encode(array_values($value)),
                default => (string) $value,
            };

            PropertyFeature::query()->create([
                'property_id' => $property->id,
                'feature' => $feature,
                'value' => $stringValue,
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
