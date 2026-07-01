<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('featured_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('click_count')->default(0);
            $table->json('action_counts')->nullable();
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_count')->default(0);
            $table->dateTime('start_at')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['property_id', 'status']);
            $table->index('target_type');
            $table->index('start_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_properties');
    }
};
