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

            $table->timestamp('start_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->decimal('discount', 10, 2)->default(0);

            $table->json('eligible_items')->nullable(); //
            $table->boolean('is_published')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->unique('code');
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
