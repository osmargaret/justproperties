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
            $table->string('email');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('post_id')->nullable()->constrained('posts');
            $table->foreignId('property_id')->nullable()->constrained('properties');
            $table->boolean('get_new_posts')->default(false);
            $table->boolean('get_comments')->default(false);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['email', 'post_id'], 'blog_subscriptions_email_post_unique');
            $table->unique(['email', 'property_id'], 'blog_subscriptions_email_property_unique');
            $table->unique(['email', 'category_id'], 'blog_subscriptions_email_category_unique');
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
