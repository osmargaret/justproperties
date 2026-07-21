<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOTE: Bank details were moved to currencies table (bank_details per payment currency).
// This migration is intentionally a no-op placeholder kept for ordering continuity.
return new class extends Migration
{
    public function up(): void
    {
        // Bank details are stored on currencies table, not countries.
        // See: 2026_07_20_012943_add_bank_details_to_currencies_table.php
    }

    public function down(): void
    {
        //
    }
};
