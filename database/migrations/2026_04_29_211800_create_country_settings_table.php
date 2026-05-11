<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->unique()->constrained('countries')->cascadeOnDelete();
            $table->string('primary_payment_gateway')->nullable();
            $table->string('secondary_payment_gateway')->nullable();
            $table->json('verification_requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_settings');
    }
};
