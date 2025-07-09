<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

try {
    // Check if test user already exists
    $existingUser = User::where('email', 'test@example.com')->first();
    
    if ($existingUser) {
        echo "Test user already exists with ID: " . $existingUser->id . "\n";
    } else {
        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);
        echo "User created successfully with ID: " . $user->id . "\n";
    }
    
    // Test authentication
    if (Auth::attempt(['email' => 'test@example.com', 'password' => 'password'])) {
        echo "Authentication test passed!\n";
    } else {
        echo "Authentication test failed!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
