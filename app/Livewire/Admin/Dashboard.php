<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\User;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'newBookings' => Booking::whereDate('created_at', now())->count(),
            'pendingApproval' => Booking::where('status', 'pending')->count(),
            'registeredUsers' => User::count(),
            'revenueThisMonth' => Booking::whereMonth('created_at', now()->month)
                ->where('status', 'paid')
                ->sum('total_amount'),
            'recentBookings' => Booking::latest()->take(5)->get(),
        ])->layout('layouts.admin');
    }
}
