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
        Schema::create('property_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('rating'); // expected range 1-5
            $table->text('comment');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['property_id', 'user_id']);
            $table->index('property_id');
            $table->index('user_id');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_reviews');
    }
};