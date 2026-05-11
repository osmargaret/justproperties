<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('currency_id')->constrained('countries')->nullOnDelete();
            $table->index(['priceable_type', 'priceable_id', 'currency_id', 'country_id']);
        });
    }

    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropIndex(['priceable_type', 'priceable_id', 'currency_id', 'country_id']);
            $table->dropConstrainedForeignId('country_id');
        });
    }
};
