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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('promotion_plan_id');
            $table->unsignedBigInteger('promotable_id')->nullable(); // featured listing id, blog post id, newsletter id,
            $table->string('promotable_type')->nullable(); // featured listing, blog post, newsletter,
            $table->dateTime('start_at');
            $table->json('usage')->nullable(); // tracks usage of features (clicks, posts, emails, recipients)
            $table->string('status')->default('pending'); // pending, active, inactive, expired, completed
            $table->timestamps();
            $table->string('target_type')->nullable()->after('status');
            $table->unsignedBigInteger('target_count')->default(0)->after('target_type');
            $table->text('content_brief')->nullable()->after('target_count');
            $table->json('audience_config')->nullable()->after('content_brief');

            $table->index(['target_type', 'target_count']);
            $table->index(['promotable_type', 'promotable_id']);
            $table->index('status');
            $table->index('start_at');
            $table->foreign('property_id')->references('id')->on('properties');
            $table->foreign('promotion_plan_id')->references('id')->on('promotion_plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
