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
        Schema::create('property_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->unsignedBigInteger('property_id')->nullable();
            $table->string('type'); // new_property, price_change,
            $table->string('status')->default('active'); // active, inactive
            $table->timestamp('last_sent_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties');
            $table->index('user_id');
            $table->index('category_id');
            $table->index('property_id');
            $table->index('type');
            $table->index('status');
            $table->index('last_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_alerts');
    }
};
