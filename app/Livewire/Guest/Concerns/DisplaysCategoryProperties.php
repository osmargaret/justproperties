<?php

namespace App\Livewire\Guest\Concerns;

use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Country;
use App\Models\Property;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

trait DisplaysCategoryProperties
{
    use WithPagination;

    abstract protected function getCategorySlug(): string;

    // Filter Form State Properties
    public string $search = '';
    public string $category;
    public string $country_id = '';
    public string $state_id = '';
    public array $cities = [];
    public array $selectedTypes = [];
    public array $selectedRentFrequencies = [];
    public ?string $minPrice = null;
    public ?string $maxPrice = null;
    public string $selectedBedrooms = '';
    public string $selectedBathrooms = '';
    public string $selectedKitchens = '';
    public array $selectedFeatures = [];
    public array $selectedTitles = [];
    public string $sortBy = 'newest';

    // Currently Applied Filters (used by properties query)
    public array $appliedFilters = [];

    public function mountDisplaysCategoryProperties(): void
    {
        $this->initDefaultCountry();
        $this->hydrateFiltersFromQuery();
        $this->applyFilters();
    }

    protected function hydrateFiltersFromQuery(): void
    {
        $request = request();

        if ($request->has('city') && ! empty($request->get('city'))) {
            $city = trim((string) $request->get('city'));
            if (! in_array($city, $this->cities, true)) {
                $this->cities[] = $city;
            }
        }

        if ($request->has('search') && ! empty($request->get('search')) && empty($this->search)) {
            $this->search = trim((string) $request->get('search'));
        }

        if ($request->has('price_range') && ! empty($request->get('price_range'))) {
            $range = (string) $request->get('price_range');
            [$min, $max] = $this->parsePriceRange($range);
            if ($min !== null) {
                $this->minPrice = (string) $min;
            }
            if ($max !== null) {
                $this->maxPrice = (string) $max;
            }
        }

        if ($request->has('minPrice') && ! empty($request->get('minPrice'))) {
            $this->minPrice = (string) $request->get('minPrice');
        }

        if ($request->has('maxPrice') && ! empty($request->get('maxPrice'))) {
            $this->maxPrice = (string) $request->get('maxPrice');
        }
    }

    protected function parsePriceRange(string $range): array
    {
        return match (strtolower(trim($range))) {
            '0-1m', '0-10m', 'under 1m', 'under 10m' => [null, 1_000_000],
            '1m-5m' => [1_000_000, 5_000_000],
            '5m-10m' => [5_000_000, 10_000_000],
            '10m-30m' => [10_000_000, 30_000_000],
            '10m-50m' => [10_000_000, 50_000_000],
            '30m-50m' => [30_000_000, 50_000_000],
            '50m-100m' => [50_000_000, 100_000_000],
            '100m+', 'above 100m' => [100_000_000, null],
            default => [null, null],
        };
    }

    protected function initDefaultCountry(): void
    {
        if (Auth::check() && Auth::user()->country_id) {
            $this->country_id = (string) Auth::user()->country_id;
        } else {
            $defaultCountry = Country::query()->where('is_default', true)->first();
            if (! $defaultCountry) {
                $defaultCountry = Country::query()->where('code', 'NG')->first() ?? Country::query()->first();
            }
            $this->country_id = $defaultCountry ? (string) $defaultCountry->id : '';
        }
    }

    public function updatedSearch(): void
    {
        $this->appliedFilters['search'] = trim($this->search);
        $this->resetPage();
    }

    public function updatedSortBy(): void
    {
        $this->appliedFilters['sortBy'] = $this->sortBy;
        $this->resetPage();
    }

    public function updatedCountryId($value): void
    {
        $this->state_id = '';
    }

    public function applyFilters(): void
    {
        $this->appliedFilters = [
            'search' => trim($this->search),
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'cities' => array_values(array_filter(array_map('trim', $this->cities))),
            'selectedTypes' => array_values($this->selectedTypes),
            'selectedRentFrequencies' => array_values($this->selectedRentFrequencies),
            'minPrice' => $this->minPrice !== null && $this->minPrice !== '' ? (float) preg_replace('/[^0-9.]/', '', $this->minPrice) : null,
            'maxPrice' => $this->maxPrice !== null && $this->maxPrice !== '' ? (float) preg_replace('/[^0-9.]/', '', $this->maxPrice) : null,
            'selectedBedrooms' => $this->selectedBedrooms,
            'selectedBathrooms' => $this->selectedBathrooms,
            'selectedKitchens' => $this->selectedKitchens,
            'selectedFeatures' => array_values($this->selectedFeatures),
            'selectedTitles' => array_values($this->selectedTitles),
            'sortBy' => $this->sortBy,
        ];

        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->state_id = '';
        $this->cities = [];
        $this->selectedTypes = [];
        $this->selectedRentFrequencies = [];
        $this->minPrice = null;
        $this->maxPrice = null;
        $this->selectedBedrooms = '';
        $this->selectedBathrooms = '';
        $this->selectedKitchens = '';
        $this->selectedFeatures = [];
        $this->selectedTitles = [];
        $this->sortBy = 'newest';

        $this->initDefaultCountry();
        $this->applyFilters();
    }

    public function addCityTag(string $city): void
    {
        $city = trim($city);
        if ($city !== '') {
            $exists = false;
            foreach ($this->cities as $c) {
                if (strtolower($c) === strtolower($city)) {
                    $exists = true;
                    break;
                }
            }
            if (! $exists) {
                $this->cities[] = $city;
            }
        }
    }

    public function push(string $property, mixed $value): void
    {
        if ($property === 'cities') {
            $this->addCityTag((string) $value);
        }
    }

    public function removeCityTag(string $city): void
    {
        $this->cities = array_values(array_filter($this->cities, fn ($c) => strtolower($c) !== strtolower($city)));
    }

    #[Computed]
    public function category(): ?Category
    {
        return Category::query()
            ->where('slug', $this->getCategorySlug())
            ->with(['fields' => function ($q) {
                $q->orderBy('category_settings.sort_order');
            }])
            ->first();
    }

    #[Computed]
    public function countries()
    {
        return Country::query()->orderBy('name')->get();
    }

    #[Computed]
    public function states()
    {
        if (! $this->country_id) {
            return collect();
        }

        return State::query()
            ->where('country_id', $this->country_id)
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function typeField(): ?CategoryField
    {
        $typeKey = $this->getCategorySlug().'-type';
        return $this->category?->fields->firstWhere('key', $typeKey);
    }

    #[Computed]
    public function rentFrequencyField(): ?CategoryField
    {
        return $this->category?->fields->firstWhere('key', 'rent_amount_frequency');
    }

    #[Computed]
    public function featuresField(): ?CategoryField
    {
        return $this->category?->fields->firstWhere('key', 'features');
    }

    #[Computed]
    public function titleField(): ?CategoryField
    {
        return $this->category?->fields->firstWhere('key', 'title_document');
    }

    #[Computed]
    public function hasBedrooms(): bool
    {
        return (bool) $this->category?->fields->contains('key', 'bedrooms');
    }

    #[Computed]
    public function hasBathrooms(): bool
    {
        return (bool) $this->category?->fields->contains('key', 'bathrooms');
    }

    #[Computed]
    public function hasKitchens(): bool
    {
        return (bool) $this->category?->fields->contains('key', 'kitchens');
    }

    #[Computed]
    public function hasRoomsSection(): bool
    {
        return $this->hasBedrooms() || $this->hasBathrooms() || $this->hasKitchens();
    }

    #[Computed]
    public function hasFeatures(): bool
    {
        return (bool) $this->category?->fields->contains('key', 'features');
    }

    #[Computed]
    public function hasTitles(): bool
    {
        return (bool) $this->category?->fields->contains('key', 'title_document');
    }

    #[Computed]
    public function properties()
    {
        $category = $this->category;
        if (! $category) {
            return Property::query()->whereRaw('1=0')->paginate(12);
        }

        $query = Property::query()
            ->where('category_id', $category->id)
            ->where('is_published', true)
            ->with(['media', 'features', 'country', 'state', 'user']);

        $applied = $this->appliedFilters;

        if (! empty($applied['search'])) {
            $search = $applied['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('neighborhood', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if (! empty($applied['country_id'])) {
            $countryId = $applied['country_id'];
            $query->where(function ($q) use ($countryId) {
                $q->where('country_id', $countryId)
                    ->orWhereNull('country_id');
            });
        }

        if (! empty($applied['state_id'])) {
            $query->where('state_id', $applied['state_id']);
        }

        if (! empty($applied['cities'])) {
            $cities = $applied['cities'];
            $query->where(function ($q) use ($cities) {
                foreach ($cities as $city) {
                    $q->orWhere('city', 'like', "%{$city}%")
                        ->orWhere('neighborhood', 'like', "%{$city}%")
                        ->orWhere('name', 'like', "%{$city}%")
                        ->orWhere('address', 'like', "%{$city}%");
                }
            });
        }

        if (isset($applied['minPrice']) && $applied['minPrice'] > 0) {
            $query->where('cost', '>=', $applied['minPrice']);
        }

        if (isset($applied['maxPrice']) && $applied['maxPrice'] > 0) {
            $query->where('cost', '<=', $applied['maxPrice']);
        }

        if (! empty($applied['selectedTypes'])) {
            $typeKey = $this->getCategorySlug().'-type';
            $types = (array) $applied['selectedTypes'];
            $query->whereHas('features', function ($q) use ($typeKey, $types) {
                $q->where('feature', $typeKey)->where(function ($subQ) use ($types) {
                    foreach ($types as $t) {
                        $subQ->orWhere('value', $t)
                            ->orWhere('value', 'like', '%"'.addcslashes($t, '"').'"%');
                    }
                });
            });
        }

        if (! empty($applied['selectedRentFrequencies'])) {
            $freqs = (array) $applied['selectedRentFrequencies'];
            $query->whereHas('features', function ($q) use ($freqs) {
                $q->where('feature', 'rent_amount_frequency')->where(function ($subQ) use ($freqs) {
                    foreach ($freqs as $f) {
                        $subQ->orWhere('value', $f)
                            ->orWhere('value', 'like', '%"'.addcslashes($f, '"').'"%');
                    }
                });
            });
        }

        if (! empty($applied['selectedBedrooms']) && $applied['selectedBedrooms'] !== 'any') {
            $beds = (int) preg_replace('/[^0-9]/', '', $applied['selectedBedrooms']);
            if ($beds > 0) {
                $query->whereHas('features', function ($q) use ($beds) {
                    $q->where('feature', 'bedrooms')->whereRaw('CAST(value AS UNSIGNED) >= ?', [$beds]);
                });
            }
        }

        if (! empty($applied['selectedBathrooms']) && $applied['selectedBathrooms'] !== 'any') {
            $baths = (int) preg_replace('/[^0-9]/', '', $applied['selectedBathrooms']);
            if ($baths > 0) {
                $query->whereHas('features', function ($q) use ($baths) {
                    $q->where('feature', 'bathrooms')->whereRaw('CAST(value AS UNSIGNED) >= ?', [$baths]);
                });
            }
        }

        if (! empty($applied['selectedKitchens']) && $applied['selectedKitchens'] !== 'any') {
            $kitchens = (int) preg_replace('/[^0-9]/', '', $applied['selectedKitchens']);
            if ($kitchens > 0) {
                $query->whereHas('features', function ($q) use ($kitchens) {
                    $q->where('feature', 'kitchens')->whereRaw('CAST(value AS UNSIGNED) >= ?', [$kitchens]);
                });
            }
        }

        if (! empty($applied['selectedFeatures'])) {
            $features = (array) $applied['selectedFeatures'];
            foreach ($features as $feat) {
                $query->whereHas('features', function ($q) use ($feat) {
                    $q->where('feature', 'features')->where('value', 'like', '%"'.addcslashes($feat, '"').'"%');
                });
            }
        }

        if (! empty($applied['selectedTitles'])) {
            $titles = (array) $applied['selectedTitles'];
            $query->whereHas('features', function ($q) use ($titles) {
                $q->where('feature', 'title_document')->where(function ($subQ) use ($titles) {
                    foreach ($titles as $t) {
                        $subQ->orWhere('value', $t)
                            ->orWhere('value', 'like', '%"'.addcslashes($t, '"').'"%');
                    }
                });
            });
        }

        $sortBy = $applied['sortBy'] ?? 'newest';
        match ($sortBy) {
            'price_asc' => $query->orderBy('cost', 'asc'),
            'price_desc' => $query->orderBy('cost', 'desc'),
            default => $query->latest(),
        };

        return $query->paginate(12);
    }
}
