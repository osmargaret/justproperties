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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('property_id')->nullable()->constrained('properties');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('content_source')->default('manual');
            $table->timestamp('ai_generated_at')->nullable();
            $table->json('tags')->nullable();
            $table->string('status')->default('draft'); // draft, published, archived
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('click_count')->default(0);
            $table->json('action_counts')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id');
            $table->index('content_source');
            $table->index('category_id');
            $table->index('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
