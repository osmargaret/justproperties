<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\Country::where('code', 'NG')->update(['is_default' => true]);
echo "Updated Nigeria is_default to true.\n";
