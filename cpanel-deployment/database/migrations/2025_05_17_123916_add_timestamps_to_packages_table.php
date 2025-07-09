<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'discount_price')) {
                $table->decimal('discount_price', 8, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('packages', 'type')) {
                $table->string('type', 100)->nullable()->after('discount_price');
            }
            if (!Schema::hasColumn('packages', 'active')) {
                $table->boolean('active')->default(1)->after('type');
            }
            if (!Schema::hasColumn('packages', 'price_label')) {
                $table->string('price_label', 100)->nullable()->after('active');
            }
            if (!Schema::hasColumn('packages', 'requires_id')) {
                $table->string('requires_id', 100)->nullable()->after('price_label');
            }
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'discount_price')) {
                $table->dropColumn('discount_price');
            }
            if (Schema::hasColumn('packages', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('packages', 'active')) {
                $table->dropColumn('active');
            }
            if (Schema::hasColumn('packages', 'price_label')) {
                $table->dropColumn('price_label');
            }
            if (Schema::hasColumn('packages', 'requires_id')) {
                $table->dropColumn('requires_id');
            }
        });
    }
};
