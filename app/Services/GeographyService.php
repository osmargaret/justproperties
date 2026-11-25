<?php

namespace App\Services;


use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;

class GeographyService
{
    private const BASE_URL = 'https://api.countrystatecity.in/v1/countries';

    /**
     * Fetch and persist states for the given country.
     * Safe to call multiple times — uses updateOrCreate internally.
     */
    public function fetchAndSaveStates(Country $country): void
    {
        try {
            $this->fetchStates($country);
        } catch (\Throwable $e) {
            Log::warning('GeographyService: failed to fetch geography for country '.$country->code, [
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    protected function apiKey(): string
    {
        return config('services.countrystatecity', '');
    }

    protected function fetchStates(Country $country): void
    {
        $states = $this->fetchApiData(self::BASE_URL."/{$country->code}/states");

        foreach ($states as $stateData) {
            if (! is_array($stateData)) {
                continue;
            }

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
                ]
            );
        }
    }

    protected function fetchApiData(string $url): array
    {
        $response = Curl::to($url)
            ->withHeaders(['X-CSCAPI-KEY' => $this->apiKey()])
            ->withTimeout(15)
            ->returnResponseObject()
            ->get();

        if (isset($response->error)) {
            throw new \RuntimeException('GeographyService: API request failed: '.$response->error);
        }

        if ($response->status < 200 || $response->status >= 300) {
            throw new \RuntimeException('GeographyService: API returned HTTP '.$response->status);
        }

        $data = json_decode($response->content, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($data) || ! array_is_list($data)) {
            throw new \UnexpectedValueException('GeographyService: invalid API response');
        }

        return $data;
    }

}