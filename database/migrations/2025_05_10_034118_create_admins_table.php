<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('email', 100)->unique();
            $table->boolean('is_super_admin')->default(0);
            $table->timestamp('last_login')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
