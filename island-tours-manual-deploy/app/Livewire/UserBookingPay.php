<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserBookingPay extends Component
{
    public $booking;

    public function mount($booking)
    {
        $this->booking = Booking::where('id', $booking)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.user-booking-pay')
            ->layout('layouts.app');
    }
}
