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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('priceable_id')->nullable();
            $table->string('priceable_type')->nullable();
            $table->timestamps();
            $table->index('priceable_id');
            $table->index('priceable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
