<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('inspections');
    }

    public function down(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('buyer_id')->constrained('users');
            $table->dateTime('scheduled_at');
            $table->decimal('inspection_fee', 10, 2)->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
};
