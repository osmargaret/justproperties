<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ng = \App\Models\Country::where('code', 'NG')->first();
echo "Nigeria Country ID: " . ($ng?->id ?? 'not found') . " | Name: " . ($ng?->name ?? 'not found') . "\n";

$allCountries = \App\Models\Country::all();
echo "Total Countries: " . $allCountries->count() . "\n";
foreach ($allCountries as $c) {
    echo "ID: {$c->id} | Code: {$c->code} | Name: {$c->name} | Default: " . ($c->is_default ? 'Yes' : 'No') . "\n";
}
