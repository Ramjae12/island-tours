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
            $table->date('date');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->integer('max_capacity')->default(0);
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('available_dates');
    }
};