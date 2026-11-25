<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_plan_prices', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('promotion_plan_id');
            $table->foreignId('currency_id');
            $table->decimal('amount', 12, 2);
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('default_plan_id')
                ->nullable()
                ->storedAs('CASE WHEN is_default = 1 THEN promotion_plan_id ELSE NULL END');
            $table->timestamps();
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->restrictOnDelete();
            $table->unique(['promotion_plan_id', 'currency_id']);
            $table->unique('default_plan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_plan_prices');
    }
};
