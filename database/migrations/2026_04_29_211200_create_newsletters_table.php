<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('subject')->nullable();
            $table->longText('content')->nullable();
            $table->string('audience_type')->nullable();
            $table->json('audience_snapshot')->nullable();
            $table->string('status')->default('draft');
            $table->string('content_source')->default('manual');
            $table->timestamp('ai_generated_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('audience_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
