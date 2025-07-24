<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_packages', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 20);
            $table->unsignedBigInteger('package_id');
            $table->integer('quantity');

            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            // If packages table uses bigIncrements, use unsignedBigInteger for package_id
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_packages');
    }
};
