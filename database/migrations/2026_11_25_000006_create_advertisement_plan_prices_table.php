<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_plan_prices', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('advertisement_plan_id');
            $table->foreignId('currency_id')->constrained('currencies')->restrictOnDelete();
            $table->decimal('amount', 12, 2);
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('default_advertisement_plan_id')
                ->nullable()
                ->storedAs('CASE WHEN is_default = 1 THEN advertisement_plan_id ELSE NULL END');
            $table->timestamps();
            $table->unique(
                ['advertisement_plan_id', 'currency_id'],
                'ad_plan_price_currency_unique'
            );
            $table->unique('default_advertisement_plan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_plan_prices');
    }
};
