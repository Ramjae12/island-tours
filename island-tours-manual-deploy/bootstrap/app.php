<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckRole;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Redirect guests (unauthenticated) to login
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));

        // Redirect authenticated users away from guest-only pages (like /login)
        $middleware->redirectUsersTo(function (Request $request) {
            $user = $request->user();
            if ($user && ($user->hasRole('admin') || $user->hasRole('power_user'))) {
                return route('admin.dashboard');
            }
            return route('dashboard');
        });

        // Register middleware aliases
        $middleware->alias([
            'is_admin' => IsAdmin::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'check.role' => CheckRole::class,  // Added your custom role middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
