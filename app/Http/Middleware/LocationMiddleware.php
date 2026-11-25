<?php

namespace App\Http\Middleware;

use App\Jobs\FetchCountryStates;
use App\Http\Traits\GeoLocationTrait;
use App\Models\Location;
use Closure;
use Illuminate\Http\Request;

class LocationMiddleware
{
    use GeoLocationTrait;

    private const LOCALHOST_IPS = ['127.0.0.1', '::1', '172.18.0.1', '172.17.0.1'];

    private const NIGERIAN_TEST_IP = '197.211.58.12';

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        if (in_array($ip, self::LOCALHOST_IPS, true)) {
            $ip = self::NIGERIAN_TEST_IP;
        }

        $location = Location::query()->where('ip', $ip)->first();

        if ($location && $location->suspended_at) {
            abort(403, $location->suspension_reason);
        }

        if (! $location) {
            $location = $this->fetchAndSaveLocation($ip);
        }

        if (! $location) {
            abort(503, 'Could not identify your location');
        }

        $country = $location->country()->first();
        if (! $country) {
            abort(503, 'Could not identify your country');
        }

        if (! $country->states()->exists()) {
            FetchCountryStates::dispatch($country);
        }

        $currentLocation = [
            'country_id' => $country->id,
            'country_code' => strtolower($location->country_code ?: $country->code),
            'country_name' => $location->country_name ?: $country->name,
            'state_id' => null,
            'state_name' => $location->state ?? '',
            'city' => $location->city ?? '',
        ];
        session()->put('current_location', $currentLocation);

        return $next($request);
    }
}
