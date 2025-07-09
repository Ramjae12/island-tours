<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
// In your packages table migration
Schema::create('packages', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 8, 2);
    $table->decimal('discount_price', 8, 2)->nullable();
    $table->string('type');
    $table->boolean('active')->default(true);
    $table->string('price_label')->default('per person/day');
    $table->boolean('requires_id')->default(true);
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
