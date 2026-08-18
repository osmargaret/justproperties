<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$defaultCountry = \App\Models\Country::where('is_default', true)->first();
echo "Default Country ID: " . ($defaultCountry?->id ?? 'null') . " (Name: " . ($defaultCountry?->name ?? 'null') . ")\n";

$countriesInProps = \App\Models\Property::distinct()->pluck('country_id');
echo "Country IDs in Properties Table: " . implode(', ', $countriesInProps->toArray()) . "\n";
