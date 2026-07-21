<?php

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeographyService
{
    private const BASE_URL = 'https://api.countrystatecity.in/v1/countries';

    /**
     * Fetch and persist states + cities for the given country.
     * Uses the countrystatecity.in API with X-CSCAPI-KEY header.
     * Safe to call multiple times — uses updateOrCreate internally.
     */
    public function fetchAndSave(Country $country): void
    {
        try {
            $this->fetchStates($country);
            $this->fetchCities($country);
        } catch (\Throwable $e) {
            Log::warning('GeographyService: failed to fetch geography for country '.$country->code, [
                'error' => $e->getMessage(),
            ]);
        }
    }

    // -------------------------------------------------------------------------
    // Internals
    // -------------------------------------------------------------------------

    protected function apiKey(): string
    {
        return config('services.countrystatecity.key', '');
    }

    /**
     * Fetch all states for a country and save them.
     * GET https://api.countrystatecity.in/v1/countries/{country_code}/states
     */
    protected function fetchStates(Country $country): void
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->apiKey(),
        ])->timeout(15)->get(self::BASE_URL."/{$country->code}/states");

        if (! $response->successful()) {
            Log::warning('GeographyService: HTTP error fetching states', [
                'country' => $country->code,
                'status'  => $response->status(),
            ]);

            return;
        }

        $states = $response->json();

        if (! is_array($states)) {
            return;
        }

        foreach ($states as $stateData) {
            $stateName = $stateData['name'] ?? null;
            if (! $stateName) {
                continue;
            }

            $stateSlug = Str::slug($stateName);

            State::query()->updateOrCreate(
                ['country_id' => $country->id, 'slug' => $stateSlug],
                [
                    'name'      => $stateName,
                    'code'      => $stateData['iso2'] ?? strtoupper(substr($stateSlug, 0, 4)),
                    'latitude'  => $stateData['latitude'] ?? null,
                    'longitude' => $stateData['longitude'] ?? null,
                    'timezone'  => null, // state-level timezone not in this API
                    'is_active' => true,
                ]
            );
        }
    }

    /**
     * Fetch all cities for a country and save them, linking to the matching state.
     * GET https://api.countrystatecity.in/v1/countries/{country_code}/cities
     */
    protected function fetchCities(Country $country): void
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->apiKey(),
        ])->timeout(30)->get(self::BASE_URL."/{$country->code}/cities");

        if (! $response->successful()) {
            Log::warning('GeographyService: HTTP error fetching cities', [
                'country' => $country->code,
                'status'  => $response->status(),
            ]);

            return;
        }

        $cities = $response->json();

        if (! is_array($cities)) {
            return;
        }

        // Cache states by their ISO2 code for lookup
        $statesByIso2 = State::query()
            ->where('country_id', $country->id)
            ->get()
            ->keyBy('code');

        foreach ($cities as $cityData) {
            $cityName  = $cityData['name'] ?? null;
            $stateCode = $cityData['state_code'] ?? null;

            if (! $cityName) {
                continue;
            }

            $citySlug = Str::slug($cityName);
            $state    = $stateCode ? ($statesByIso2[$stateCode] ?? null) : null;

            if (! $state) {
                continue; // skip cities whose state we couldn't resolve
            }

            City::query()->updateOrCreate(
                ['state_id' => $state->id, 'slug' => $citySlug],
                [
                    'name'       => $cityName,
                    'country_id' => $country->id,
                    'latitude'   => $cityData['latitude'] ?? null,
                    'longitude'  => $cityData['longitude'] ?? null,
                    'timezone'   => $cityData['timezone'] ?? null,
                    'population' => isset($cityData['population']) ? (int) $cityData['population'] : null,
                    'is_active'  => true,
                ]
            );
        }
    }
}
