<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // If admin, redirect to admin dashboard
        if (Auth::user() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        // Otherwise, show the regular user dashboard
        return view('dashboard');
    }
}
 