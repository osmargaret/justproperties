<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$props = \App\Models\Property::with('category')->get();
echo "Total Properties: " . $props->count() . "\n\n";

foreach ($props as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | Cat Slug: {$p->category?->slug} | Country ID: {$p->country_id} | State ID: {$p->state_id} | City: '{$p->city}' | Neighborhood: '{$p->neighborhood}' | Cost: {$p->cost} | Published: " . ($p->is_published ? 'Yes' : 'No') . "\n";
}
