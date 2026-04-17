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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties');
            $table->foreignId('user_id')->constrained('users');
            $table->date('booking_date');
            $table->time('buyer_time');
            $table->date('seller_date')->nullable();
            $table->time('seller_time')->nullable();
            $table->date('confirmed_date')->nullable();
            $table->time('confirmed_time')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, paid, completed, cancelled
            $table->decimal('inspection_fee', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
