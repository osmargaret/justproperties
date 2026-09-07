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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->json('users_permission')->nullable();
            $table->json('subscriptions_permission')->nullable();
            $table->json('promotions_permission')->nullable();
            $table->json('properties_permission')->nullable();
            $table->json('posts_permission')->nullable();
            $table->json('payments_permission')->nullable();
            $table->json('coupons_permission')->nullable();
            $table->json('settings_permission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
