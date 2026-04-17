<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('country_currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('currency_id');
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->index('country_id');
            $table->index('currency_id');
            $table->unique(['country_id', 'currency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_currencies');
    }
};
