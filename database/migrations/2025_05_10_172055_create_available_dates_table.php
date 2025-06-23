<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('available_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->foreignId('package_id')->constrained();
            $table->unsignedInteger('max_capacity')->default(100);
            $table->unsignedInteger('booked_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_dates');
    }
};
