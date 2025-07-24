<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('available_dates', function (Blueprint $table) {
            $table->integer('capacity')->default(0);
            $table->integer('booked')->default(0);
            $table->boolean('closed')->default(false);
        });
    }

    public function down()
    {
        Schema::table('available_dates', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'booked', 'closed']);
        });
    }
};
