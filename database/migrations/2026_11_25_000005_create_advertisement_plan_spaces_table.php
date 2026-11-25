<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_plan_spaces', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('advertisement_plan_id')
                ->constrained('advertisement_plans')
                ->cascadeOnDelete();
            $table->foreignId('advertisement_space_id')
                ->constrained('advertisement_spaces')
                ->restrictOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unique(
                ['advertisement_plan_id', 'advertisement_space_id'],
                'ad_plan_space_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_plan_spaces');
    }
};
