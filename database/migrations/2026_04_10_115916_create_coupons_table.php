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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('quantity')->default(1);
            $table->integer('limit_per_user')->nullable();
            $table->integer('limit_for_user')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_percentage');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('discount_cap', 10, 2)->nullable();
            $table->decimal('minimum_spend', 10, 2)->nullable();
            $table->json('eligible_items')->nullable(); //
            $table->boolean('is_published')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
