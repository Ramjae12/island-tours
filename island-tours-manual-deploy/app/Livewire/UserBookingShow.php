<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserBookingShow extends Component
{
    public $booking;

    public function mount($booking)
    {
        try {
            $this->booking = Booking::where('id', $booking)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } catch (\Exception $e) {
            // Show a friendly error if not found or unauthorized
            abort(404, 'Booking not found or you do not have access to this booking.');
        }
    }

    public function render()
    {
        return view('livewire.user-booking-show')
            ->layout('layouts.app');
    }
}
