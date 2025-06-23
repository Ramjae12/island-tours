<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->enum('status', ['pending','approved','returned','cancelled','completed','rejected'])->default('pending');
            $table->text('return_reason')->nullable();
            $table->string('full_name', 100);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->text('address');
            $table->integer('adult_qty')->default(0);
            $table->integer('child_qty')->default(0);
            $table->integer('pwd_senior_qty')->default(0);
            $table->integer('student_qty')->default(0);
            $table->integer('lights_show_qty')->default(0);
            $table->integer('exclusive_show_qty')->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
