<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignAdminRole extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Assign the admin role to a user by email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error('User not found.');
            return 1;
        }
        $user->assignRole('admin');
        $this->info('Admin role assigned to ' . $email);
        return 0;
    }
}
