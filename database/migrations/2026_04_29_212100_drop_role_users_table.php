<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('role_users');
    }

    public function down(): void
    {
        Schema::create('role_users', function ($table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->index('role_id');
            $table->index('user_id');
            $table->unique(['role_id', 'user_id']);
        });
    }
};
