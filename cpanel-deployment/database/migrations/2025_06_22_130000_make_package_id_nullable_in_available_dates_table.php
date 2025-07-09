<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('available_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('available_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id')->nullable(false)->change();
        });
    }
};
