<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->string('gateway')->nullable()->after('method');
            $table->text('details')->nullable()->after('gateway');
            $table->json('gateway_payload')->nullable()->after('details');

            $table->index('paid_at');
            $table->index('status');
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['paid_at']);
            $table->dropIndex(['status']);
            $table->dropIndex(['reference']);
            $table->dropColumn(['paid_at', 'gateway', 'details', 'gateway_payload']);
        });
    }
};
