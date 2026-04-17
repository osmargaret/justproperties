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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('promotion_plan_id');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('promotion_plan_id')->references('id')->on('promotion_plans');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('status')->default('pending'); // pending, active, inactive, expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
