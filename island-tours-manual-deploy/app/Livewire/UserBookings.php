<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserBookings extends Component
{
    use WithPagination;

    public function render()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.user-bookings', [
            'bookings' => $bookings
        ])->layout('layouts.app');
    }
}

