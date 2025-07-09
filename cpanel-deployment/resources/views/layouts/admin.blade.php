<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Island Tours</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    @livewireStyles
    @stack('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">
                <h2>Island Tours</h2>
                <p>Admin Panel</p>
            </div>
            <ul class="sidebar-menu">
                <li>
                    @if(Auth::check() && Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @endif
                </li>
                <li>
                    <a href="{{ route('admin.bookings') }}">
                        <i class="fas fa-calendar-check"></i> Bookings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.packages') }}">
                        <i class="fas fa-box-open"></i> Packages
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.available-dates') }}">
                        <i class="fas fa-calendar-alt"></i> Date Management
                    </a>
                </li>
            </ul>
            <div style="position: absolute; bottom: 32px; left: 0; width: 100%; text-align: center;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" id="adminLogout" style="background:none;border:none;color:inherit;cursor:pointer; font-size: 1.1em; padding: 12px 0; width: 100%;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="main-content">
            <div class="top-bar" style="display: flex; align-items: center; justify-content: flex-end;">
                <div style="display: flex; align-items: center; gap: 24px; margin-left: auto;">
                    <x-notification-bell />
                    <div class="admin-profile">
                        <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
                        <img src="{{ asset('image/user.png') }}" alt="Admin">
                    </div>
                </div>
            </div>
            <div class="content">
                {{ $slot }}
            </div>
        </div>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>
