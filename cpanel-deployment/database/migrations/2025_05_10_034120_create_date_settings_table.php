<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('date_settings', function (Blueprint $table) {
            // Recommended to use auto-incrementing ID as primary key
            $table->id();
            
            // Date should be unique but not primary key
            $table->date('date')->unique();
            
            // Allow null for max_slots (0 might be ambiguous)
            $table->integer('max_slots')->nullable();
            
            // Default names for boolean fields should be present tense
            $table->boolean('closed')->default(false);
            
            // Renamed for clarity (current_bookings vs total_bookings)
            $table->integer('current_bookings')->default(0);
            
            // Added timestamp columns for auditing
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('date_settings');
    }
};
