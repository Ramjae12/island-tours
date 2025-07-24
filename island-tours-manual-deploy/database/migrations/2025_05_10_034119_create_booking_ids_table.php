<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_ids', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 36); // UUID support
            $table->string('file_path', 255);
            $table->integer('person_number');
            $table->timestamp('uploaded_at')->useCurrent();

            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_ids');
    }
};
