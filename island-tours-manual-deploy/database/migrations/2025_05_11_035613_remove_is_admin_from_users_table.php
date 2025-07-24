<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Step 1: Assign 'admin' role to existing admins
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        User::where('is_admin', true)
            ->each(function ($user) use ($adminRole) {
                $user->assignRole($adminRole);
            });

        // Step 2: Remove the column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    public function down()
    {
        // Re-add the column (optional: repopulate is_admin from roles)
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });
    }
};
