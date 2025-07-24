<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserBookingEdit extends Component
{
    public $booking;
    public $date;
    public $details;

    public function mount($booking)
    {
        $this->booking = Booking::where('id', $booking)
            ->where('user_id', Auth::id())
            ->where('status', 'returned')
            ->firstOrFail();
        $this->date = $this->booking->date;
        $this->details = $this->booking->details;
    }

    public function updateBooking()
    {
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'details' => 'required|string|min:5',
        ]);
        $this->booking->update([
            'date' => $this->date,
            'details' => $this->details,
            'status' => 'pending', // Set back to pending after edit
        ]);
        session()->flash('success', 'Booking updated and resubmitted for review.');
        return redirect()->route('user.bookings');
    }

    public function render()
    {
        return view('livewire.user-booking-edit')->layout('layouts.app');
    }
}
