<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SecureFileController;
use App\Livewire\Login;
use App\Livewire\BookingForm;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Bookings;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Packages;
use App\Livewire\Admin\AvailableDates;

// Public routes
Route::view('/', 'welcome');

// // Authentication routes (Livewire SPA)
// Route::middleware('guest')->group(function () {
//     Route::get('/login', Login::class)->name('login'); // Livewire login component
// });

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    Route::get('/booking', BookingForm::class)->name('booking');
});

// Logout
Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Power user and admin routes - can access most admin features
Route::middleware(['auth', 'role:admin|power_user'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');           // /admin
    Route::get('/dashboard', Dashboard::class);                     // /admin/dashboard (no extra name needed)
    Route::get('/bookings', Bookings::class)->name('bookings');
    Route::get('/packages', Packages::class)->name('packages');
    Route::get('/available-dates', AvailableDates::class)->name('available-dates');
});

// Admin-only routes - for user management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', Users::class)->name('users');
});

// Secure admin file download route
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/secure-file/{fileName}', [SecureFileController::class, 'download'])
         ->name('admin.secure.file');
});

// Enable default auth routes (login, register, etc.)
require __DIR__.'/auth.php';
