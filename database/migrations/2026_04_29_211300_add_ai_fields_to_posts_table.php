<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('content_source')->default('manual')->after('content');
            $table->timestamp('ai_generated_at')->nullable()->after('content_source');
            $table->index('content_source');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['content_source']);
            $table->dropColumn(['content_source', 'ai_generated_at']);
        });
    }
};
