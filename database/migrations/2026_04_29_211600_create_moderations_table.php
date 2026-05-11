<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status');
            $table->string('action');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->index(['property_id', 'status']);
            $table->index('actor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderations');
    }
};
