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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->boolean('is_property')->default(true);
            $table->timestamps();
        });

        Schema::create('category_fields', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->enum('data_type', ['number', 'text', 'textarea', 'boolean', 'date', 'single_select', 'multi_select']);
            $table->boolean('is_required')->default(false);
            $table->json('options')->nullable();
            $table->json('default_value')->nullable();
            $table->json('validation')->nullable();
            $table->timestamps();
        });

        Schema::create('category_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('category_field_id')->constrained('category_fields')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['category_id', 'category_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_settings');
        Schema::dropIfExists('category_fields');
        Schema::dropIfExists('categories');
    }
};
