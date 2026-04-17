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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_plan_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans');
            $table->integer('seats')->default(1);
            $table->integer('days')->default(30);  
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('renew_at');
            $table->string('status')->default('pending'); // pending, active, inactive, expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
