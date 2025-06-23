<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop legacy/unused tables. Add or remove as needed for your app.
        $tablesToDrop = [
            'admins',
            'is_admin',
            'save',
            'old-booking',
            'edit',
            // Add any other legacy/test tables you want to drop
        ];
        foreach ($tablesToDrop as $table) {
            if (Schema::hasTable($table)) {
                Schema::drop($table);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down migration for dropped tables
    }
};
