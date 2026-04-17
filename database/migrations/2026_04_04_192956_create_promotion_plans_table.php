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
        Schema::create('promotion_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type'); // views, contact, blog posts (generation), social media posts (generation & publish), email marketing, sms marketing, whatsapp marketing, events, inquiries, newsletters, appointments, featured listings
            $table->json('features')->nullable();
            $table->integer('days')->default(30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_plans');
    }
};
