<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config', function (Blueprint $table) {
            $table->string('key', 50)->primary();
            $table->string('value', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
