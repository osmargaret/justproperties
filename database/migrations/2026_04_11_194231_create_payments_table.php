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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->string('currency_code', 3)->nullable();
            $table->unsignedBigInteger('paymentable_id')->nullable();
            $table->string('paymentable_type')->nullable();
            $table->string('reference');
            $table->string('request_id', 255)->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('coupon_value')->default('0');
            $table->decimal('vat_rate', 10, 2)->default(0);
            $table->decimal('vat_value', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('method')->nullable();
            $table->string('gateway')->nullable();
            $table->text('details')->nullable();
            $table->json('gateway_payload')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed, refunded, cancelled
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            

            
            $table->string('receipt')->nullable();
            $table->index('paid_at');
            $table->index('status');
            $table->index('reference');
            
            $table->index('paymentable_id');
            $table->index('paymentable_type');
            $table->index('country_id');
            $table->index('coupon_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
