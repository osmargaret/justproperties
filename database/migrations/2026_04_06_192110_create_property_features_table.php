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
        Schema::create('property_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties');
            $table->string('feature')->nullable(); // swimming pool, gym, parking_space, furnished, 24/7 security
            $table->string('value')->nullable(); // 1, 2, 3, 4, 5
            $table->string('unit')->nullable(); // sqm, sqft, acres, hectares
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_features');
    }
};
