<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SecureFileController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Livewire\Login;
use App\Livewire\BookingForm;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Bookings;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Packages;
use App\Livewire\Admin\AvailableDates;
use App\Livewire\UserBookings;
use App\Livewire\UserBookingShow;
use App\Livewire\UserBookingPay;
use App\Livewire\UserBookingEdit;

// Public routes
Route::view('/', 'welcome');

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function() {
        // Only redirect to admin dashboard if user has the 'admin' role
        /** @var User $user */
        $user = Auth::user();
        if (Auth::check() && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        // Redirect regular users to their bookings page
        return redirect()->route('user.bookings');
    })->name('dashboard');
    
    Route::view('profile', 'profile')->name('profile');
    Route::get('/booking', BookingForm::class)->name('booking');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin routes using custom 'check.role' middleware
Route::middleware(['auth', 'check.role:admin,power_user'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/bookings', Bookings::class)->name('bookings');
    Route::get('/packages', Packages::class)->name('packages');
    Route::get('/available-dates', AvailableDates::class)->name('available-dates');
});

Route::middleware(['auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', Users::class)->name('users');
});

Route::middleware(['auth', 'check.role:admin'])->group(function () {
    Route::get('/admin/secure-file/{fileName}', [SecureFileController::class, 'download'])
         ->name('admin.secure.file');
});


// Users bookings

Route::middleware(['auth'])->group(function () {
    Route::get('/user/bookings', UserBookings::class)->name('user.bookings');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/bookings/{booking}', UserBookingShow::class)->name('user.booking.show');
});

Route::get('/user/bookings/{booking}/pay', UserBookingPay::class)->name('user.booking.pay');
Route::get('/user/bookings/{booking}/edit', BookingForm::class)
    ->middleware(['auth'])
    ->name('user.booking.edit');

// Mark all notifications as read for the authenticated user
Route::post('/notifications/mark-read', function() {
    if (Auth::check()) {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 401);
})->middleware('auth')->name('notifications.markRead');

// Debug route for user roles
if (file_exists(base_path('routes/debug.php'))) {
    require base_path('routes/debug.php');
}

require __DIR__.'/auth.php';
