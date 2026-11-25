<?php

namespace Tests\Unit\Services;

use App\Models\Country;
use App\Services\GeographyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;
use Tests\TestCase;

class GeographyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rethrows_curl_connection_errors_so_the_queue_can_retry(): void
    {
        $builder = \Mockery::mock(Builder::class);

        Curl::shouldReceive('to')
            ->once()
            ->with('https://api.countrystatecity.in/v1/countries/NG/states')
            ->andReturn($builder);

        $builder->shouldReceive('withHeaders')->once()->andReturnSelf();
        $builder->shouldReceive('withTimeout')->once()->with(15)->andReturnSelf();
        $builder->shouldReceive('returnResponseObject')->once()->andReturnSelf();
        $builder->shouldReceive('get')->once()->andReturn((object) [
            'status' => 0,
            'error' => 'Could not resolve API host',
            'content' => false,
        ]);

        $country = new Country;
        $country->code = 'NG';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Could not resolve API host');

        app(GeographyService::class)->fetchAndSaveStates($country);
    }

    public function test_it_throws_when_the_api_returns_an_unsuccessful_status(): void
    {
        $builder = \Mockery::mock(Builder::class);

        Curl::shouldReceive('to')
            ->once()
            ->with('https://api.countrystatecity.in/v1/countries/NG/states')
            ->andReturn($builder);

        $builder->shouldReceive('withHeaders')->once()->andReturnSelf();
        $builder->shouldReceive('withTimeout')->once()->with(15)->andReturnSelf();
        $builder->shouldReceive('returnResponseObject')->once()->andReturnSelf();
        $builder->shouldReceive('get')->once()->andReturn((object) [
            'status' => 401,
            'content' => '{"message":"Unauthorized"}',
        ]);

        $country = new Country;
        $country->code = 'NG';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('API returned HTTP 401');

        app(GeographyService::class)->fetchAndSaveStates($country);
    }

}
