<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->dropConstrainedForeignId('moderated_by');
            $table->dropColumn(['accepts_inspection_requests', 'inspection_fee', 'moderation_status', 'moderation_reason', 'moderated_at']);
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->boolean('accepts_inspection_requests')->default(false)->after('show_address');
            $table->decimal('inspection_fee', 10, 2)->default(0)->after('accepts_inspection_requests');
            $table->foreignId('moderated_by')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            $table->string('moderation_status')->default('pending')->after('moderated_by');
            $table->text('moderation_reason')->nullable()->after('moderation_status');
            $table->dateTime('moderated_at')->nullable()->after('moderation_reason');
            $table->dropColumn('slug');
        });
    }
};
