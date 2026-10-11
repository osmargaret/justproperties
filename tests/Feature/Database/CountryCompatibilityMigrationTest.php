<?php

namespace Tests\Feature\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CountryCompatibilityMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_adds_the_default_country_flag_when_missing(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });

        $migration = require database_path('migrations/2026_10_11_000001_add_is_default_to_countries_if_missing.php');
        $migration->up();

        $this->assertTrue(Schema::hasColumn('countries', 'is_default'));

        DB::table('countries')->insert([
            'name' => 'Nigeria',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('countries', [
            'name' => 'Nigeria',
            'is_default' => false,
        ]);
    }
}
