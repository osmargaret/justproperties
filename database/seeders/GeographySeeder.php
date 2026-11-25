<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GeographySeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('countries.json');
        $json = file_get_contents($path);

        if ($json === false) {
            throw new \RuntimeException('Could not read countries.json');
        }

        $countries = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($countries) || ! array_is_list($countries)) {
            throw new \UnexpectedValueException('countries.json must contain a list of countries');
        }

        foreach ($countries as $countryData) {
            if (! is_array($countryData)) {
                throw new \UnexpectedValueException('countries.json contains an invalid country record');
            }

            $code = strtoupper(trim((string) ($countryData['iso2'] ?? '')));
            $name = trim((string) ($countryData['name'] ?? ''));

            if ($code === '' || $name === '') {
                throw new \UnexpectedValueException('countries.json country records require iso2 and name');
            }

            $phoneCode = trim((string) ($countryData['phonecode'] ?? ''));
            if ($phoneCode !== '' && ! str_starts_with($phoneCode, '+')) {
                $phoneCode = '+'.$phoneCode;
            }

            $country = Country::query()->updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'slug' => $countryData['slug'] ?? Str::slug($name),
                    'flag' => $countryData['emoji'] ?? null,
                    'phone_code' => $phoneCode !== '' ? $phoneCode : null,
                    'currency' => $countryData['currency_name'] ?? null,
                    'currency_code' => $countryData['currency'] ?? null,
                    'currency_symbol' => $countryData['currency_symbol'] ?? null,
                ]
            );

            $currencyCode = strtoupper(trim((string) ($countryData['currency'] ?? '')));
            if ($currencyCode !== '' && strlen($currencyCode) !== 3) {
                throw new \UnexpectedValueException("Country {$code} has an invalid currency code");
            }

            if ($code === 'NG') {
                $country->update(['language_code' => $country->language_code ?: 'en']);
            }
        }

        $nigeria = Country::query()->where('code', 'NG')->first();
        if (! $nigeria) {
            throw new \RuntimeException('Nigeria must be present in countries.json before seeding its states.');
        }

        $this->seedNigeriaStates($nigeria);

        Currency::query()->firstOrCreate(
            ['currency_code' => 'NGN'],
            [
                'currency_name' => 'Nigerian Naira',
                'currency_symbol' => '₦',
                'payment_gateway' => 'paystack',
            ]
        );

        Currency::query()->firstOrCreate(
            ['currency_code' => 'USD'],
            [
                'currency_name' => 'US Dollar',
                'currency_symbol' => '$',
            ]
        );
    }

    private function seedNigeriaStates(Country $nigeria): void
    {
        $path = base_path('nigeria-states.json');
        $json = file_get_contents($path);

        if ($json === false) {
            throw new \RuntimeException('Could not read nigeria-states.json');
        }

        $states = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($states) || ! array_is_list($states)) {
            throw new \UnexpectedValueException('nigeria-states.json must contain a list of states');
        }

        foreach ($states as $stateData) {
            if (! is_array($stateData)) {
                throw new \UnexpectedValueException('nigeria-states.json contains an invalid state record');
            }

            $name = trim((string) ($stateData['name'] ?? ''));
            $slug = trim((string) ($stateData['slug'] ?? Str::slug($name)));

            if ($name === '' || $slug === '') {
                throw new \UnexpectedValueException('Nigerian state records require a name and slug');
            }

            State::query()->updateOrCreate(
                ['country_id' => $nigeria->id, 'slug' => $slug],
                [
                    'name' => $name,
                    'code' => $stateData['code'] ?? null,
                    'latitude' => $stateData['latitude'] ?? null,
                    'longitude' => $stateData['longitude'] ?? null,
                    'timezone' => $stateData['timezone'] ?? null,
                ]
            );
        }
    }
}