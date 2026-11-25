<?php

namespace App\Jobs;

use App\Models\Country;
use App\Services\GeographyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCountryStates implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public array $backoff = [60, 300, 900, 1800];

    public function __construct(public Country $country) {}

    public function uniqueId(): string
    {
        return 'country-states:'.$this->country->getKey();
    }

    public function handle(GeographyService $geographyService): void
    {
        $geographyService->fetchAndSaveStates($this->country);
    }
}
