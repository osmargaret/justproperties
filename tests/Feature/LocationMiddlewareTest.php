<?php

namespace Tests\Feature;

use App\Http\Middleware\LocationMiddleware;
use App\Jobs\FetchCountryStates;
use App\Models\Country;
use App\Models\Location;
use App\Models\State;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LocationMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uses_the_country_saved_for_the_visitors_ip(): void
    {
        $country = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        State::query()->create([
            'name' => 'Ontario',
            'slug' => 'ontario',
            'code' => 'ON',
            'country_id' => $country->id,
        ]);
        Location::query()->create([
            'ip' => '203.0.113.10',
            'continent' => 'North America',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'country_code' => $country->code,
            'state' => '',
            'city' => '',
        ]);
        Http::fake();
        Queue::fake();

        $response = $this->runMiddlewareForIp('203.0.113.10');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($country->id, session('current_location.country_id'));
        Http::assertNothingSent();
        Queue::assertNothingPushed();
    }

    public function test_it_queues_state_import_when_an_existing_country_has_no_states(): void
    {
        $country = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        Location::query()->create([
            'ip' => '203.0.113.13',
            'continent' => 'North America',
            'country_id' => $country->id,
            'country_name' => $country->name,
            'country_code' => $country->code,
            'state' => '',
            'city' => '',
        ]);
        Queue::fake();

        $response = $this->runMiddlewareForIp('203.0.113.13');

        $this->assertSame(200, $response->getStatusCode());
        Queue::assertPushed(FetchCountryStates::class, fn (FetchCountryStates $job) => $job->country->is($country));
    }

    public function test_it_saves_a_new_country_and_ip_and_queues_state_import(): void
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'country' => 'Canada',
                'countryCode' => 'CA',
                'continent' => 'North America',
                'regionName' => 'Ontario',
                'city' => 'Toronto',
            ]),
        ]);
        Queue::fake();

        $response = $this->runMiddlewareForIp('203.0.113.11');

        $this->assertSame(200, $response->getStatusCode());
        $country = Country::query()->where('code', 'CA')->firstOrFail();
        $this->assertSame('Canada', $country->name);
        $this->assertDatabaseHas('locations', [
            'ip' => '203.0.113.11',
            'country_id' => $country->id,
            'country_name' => 'Canada',
            'country_code' => 'CA',
            'state' => 'Ontario',
            'city' => 'Toronto',
        ]);
        $this->assertSame($country->id, session('current_location.country_id'));
        Queue::assertPushed(FetchCountryStates::class, fn (FetchCountryStates $job) => $job->country->is($country));
    }

    public function test_it_reuses_an_existing_country_without_queueing_another_state_import(): void
    {
        $country = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        State::query()->create([
            'name' => 'Ontario',
            'slug' => 'ontario',
            'code' => 'ON',
            'country_id' => $country->id,
        ]);
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'country' => 'Canada',
                'countryCode' => 'CA',
            ]),
        ]);
        Queue::fake();

        $response = $this->runMiddlewareForIp('203.0.113.12');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, Country::query()->where('code', 'CA')->count());
        $this->assertDatabaseHas('locations', [
            'ip' => '203.0.113.12',
            'country_id' => $country->id,
        ]);
        Queue::assertNothingPushed();
    }

    public function test_localhost_uses_the_nigerian_ip_for_location_lookup(): void
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'country' => 'Nigeria',
                'countryCode' => 'NG',
                'continent' => 'Africa',
            ]),
        ]);
        Queue::fake();

        $response = $this->runMiddlewareForIp('127.0.0.1');

        $this->assertSame(200, $response->getStatusCode());
        $this->assertDatabaseHas('locations', [
            'ip' => '197.211.58.12',
            'country_name' => 'Nigeria',
            'country_code' => 'NG',
            'country_dial' => null,
        ]);

        $ipv6Response = $this->runMiddlewareForIp('::1');
        $this->assertSame(200, $ipv6Response->getStatusCode());
        Http::assertSentCount(1);
    }

    public function test_legacy_location_country_columns_are_renamed_and_dial_becomes_nullable(): void
    {
        Schema::drop('locations');
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('code');
            $table->string('dial');
        });
        DB::table('locations')->insert([
            'country' => 'Nigeria',
            'code' => 'NG',
            'dial' => '+234',
        ]);

        $migration = require base_path('database/migrations/2026_11_23_000001_rename_location_country_fields.php');
        $migration->up();

        $this->assertDatabaseHas('locations', [
            'country_name' => 'Nigeria',
            'country_code' => 'NG',
            'country_dial' => '+234',
        ]);
        DB::table('locations')->insert([
            'country_name' => 'Unknown',
            'country_code' => 'XX',
            'country_dial' => null,
        ]);
        $this->assertDatabaseHas('locations', [
            'country_name' => 'Unknown',
            'country_dial' => null,
        ]);
    }

    private function runMiddlewareForIp(string $ip)
    {
        $request = Request::create('/', 'GET', [], [], [], [
            'REMOTE_ADDR' => $ip,
            'HTTP_HOST' => 'localhost',
        ]);

        return app(LocationMiddleware::class)->handle($request, fn () => response('OK'));
    }
}
