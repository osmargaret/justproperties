<?php

namespace App\Http\Traits;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait GeoLocationTrait
{
    protected function fetchAndSaveLocation(string $ip): ?Location
    {
        try {
            $response = Http::timeout(10)->get("http://ip-api.com/json/{$ip}");
            if (! $response->successful()) {
                Log::warning('IP geolocation request failed', [
                    'ip' => $ip,
                    'status' => $response->status(),
                ]);

                return null;
            }

            $data = $response->json();
            if (! is_array($data) || ($data['status'] ?? null) === 'fail') {
                Log::warning('IP geolocation returned invalid data', [
                    'ip' => $ip,
                    'response' => $data,
                ]);

                return null;
            }
            Log::info('IP geolocation successful', [
                'ip' => $ip,
                'response' => $data,
            ]);
            return $this->saveLocation($ip, $data);
        } catch (\Throwable $e) {
            Log::error('IP geolocation lookup failed', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    protected function saveLocation(string $ip, array $result): ?Location
    {
        $countryCode = strtoupper(trim($result['countryCode'] ?? ''));
        $countryName = trim($result['country'] ?? '');

        if ($countryCode === '' || $countryName === '') {
            Log::warning('IP geolocation did not include a country', [
                'ip' => $ip,
                'response' => $result,
            ]);

            return null;
        }

        try {
            $country = Country::query()->firstOrNew(['code' => $countryCode]);
            if (! $country->exists) {
                $country->fill([
                    'name' => $countryName,
                    'slug' => Str::slug($countryName),
                    'code' => $countryCode
                ]);
                $country->save();
            }

            $location = Location::query()->updateOrCreate(
                ['ip' => $ip],
                [
                    'continent' => $result['continent'] ?? '',
                    'country_id' => $country->id,
                    'country_name' => $country->name,
                    'country_code' => $country->code,
                    'country_dial' => $country->phone_code,
                    'state' => $result['regionName'] ?? '',
                    'city' => $result['city'] ?? '',
                ]
            );

            return $location;
        } catch (\Throwable $e) {
            Log::error('Could not save IP geolocation', [
                'ip' => $ip,
                'country_code' => $countryCode,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
