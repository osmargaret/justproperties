<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('promotable_id')->nullable()->after('promotion_plan_id');
            $table->string('promotable_type')->nullable()->after('promotable_id');
            $table->index(['promotable_type', 'promotable_id']);
            $table->index('status');
            $table->index('start_at');
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropIndex(['promotable_type', 'promotable_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['start_at']);
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['promotable_id', 'promotable_type']);
        });
    }
};
