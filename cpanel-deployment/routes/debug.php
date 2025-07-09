<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/debug/users-roles', function() {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) {
        abort(403, 'Unauthorized');
    }
    $users = User::all();
    echo '<h2>User Roles Debug</h2>';
    echo '<table border="1" cellpadding="6" style="border-collapse:collapse;">';
    echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Roles</th></tr>';
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user->id . '</td>';
        echo '<td>' . htmlspecialchars($user->name) . '</td>';
        echo '<td>' . htmlspecialchars($user->email) . '</td>';
        echo '<td>' . implode(", ", $user->getRoleNames()->toArray()) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    exit;
});
