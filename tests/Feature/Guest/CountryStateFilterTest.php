<?php

namespace Tests\Feature\Guest;

use App\Livewire\Guest\LandedProperty;
use App\Models\Country;
use App\Models\State;
use App\Services\GeographyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CountryStateFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_defaults_to_location_country_and_fetches_missing_country_states(): void
    {
        $canada = Country::query()->create([
            'name' => 'Canada',
            'code' => 'CA',
        ]);
        State::query()->create([
            'name' => 'Ontario',
            'slug' => 'ontario',
            'code' => 'ON',
            'country_id' => $canada->id,
        ]);
        $ghana = Country::query()->create([
            'name' => 'Ghana',
            'code' => 'GH',
        ]);
        session()->put('current_location', ['country_id' => $canada->id]);

        $geography = \Mockery::mock(GeographyService::class);
        $geography->shouldReceive('fetchAndSaveStates')
            ->once()
            ->withArgs(fn (Country $country): bool => $country->is($ghana))
            ->andReturnUsing(function (Country $country): void {
                State::query()->create([
                    'name' => 'Greater Accra',
                    'slug' => 'greater-accra',
                    'code' => 'AA',
                    'country_id' => $country->id,
                ]);
            });
        $this->app->instance(GeographyService::class, $geography);

        Livewire::test(LandedProperty::class)
            ->assertSet('country_id', (string) $canada->id)
            ->assertSee('Search for a country')
            ->assertSee('Search states or choose all')
            ->assertDontSee('x-for="country in filteredCountries"')
            ->assertDontSee('x-for="state in filteredStates"')
            ->assertDontSee('x-text="[country.flag, country.name]')
            ->assertSee('Ontario')
            ->set('country_id', (string) $ghana->id)
            ->assertSet('state_id', '')
            ->assertSee('Greater Accra')
            ->assertDontSee('Ontario');
    }
}
