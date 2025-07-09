<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles first
        $this->call(RoleSeeder::class);

        // Create test admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // Create test power user
        $powerUser = User::factory()->create([
            'name' => 'Power User',
            'email' => 'power@example.com',
        ]);
        $powerUser->assignRole('power_user');

        // Regular test user (optional)
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
        ]);
    }
}
