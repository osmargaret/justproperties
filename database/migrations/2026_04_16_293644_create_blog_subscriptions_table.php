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
        Schema::create('blog_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('categories');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->boolean('get_new_posts')->default(false);
            $table->boolean('get_comments')->default(false);
            $table->softDeletes();
            $table->timestamps();
            $table->index('user_id');
            $table->index('category_id');
            $table->index('post_id');
            $table->index('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_subscriptions');
    }
};
