<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Booking;
use App\Notifications\BookingStatusChangedNotification;

class Bookings extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $dateFilter = '';
    public $selectedBooking;
    public $statusUpdate = '';
    public $returnComment = '';
    public $showModal = false;
    public $search = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';

    protected $listeners = ['refresh' => '$refresh'];

    // Add this computed property to handle button enable/disable logic
    public function getIsButtonEnabledProperty()
    {
        if (!$this->statusUpdate) {
            return false;
        }
        
        if (in_array($this->statusUpdate, ['returned', 'rejected', 'cancelled'])) {
            return isset($this->returnComment) && 
                   is_string($this->returnComment) && 
                   strlen(trim($this->returnComment)) >= 5;
        }
        
        return true;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $bookings = Booking::with(['user', 'bookingPackages.package'])
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFilter, fn($q) => $q->whereDate('date', $this->dateFilter))
            ->when($this->search, function($q) {
                $q->where(function($query) {
                    $query->where('id', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function($uq) {
                            $uq->where('name', 'like', '%'.$this->search.'%')
                               ->orWhere('email', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.bookings', [
            'bookings' => $bookings
        ])->layout('layouts.admin');
    }

    public function showBooking(Booking $booking)
    {
        $this->selectedBooking = $booking->load('bookingIds', 'bookingPackages.package');
        $this->statusUpdate = $booking->status;
        $this->returnComment = $booking->return_reason ?? '';
        $this->showModal = true;
    }

public function updateStatus()
{
    if (!$this->selectedBooking) {
        $this->dispatch('toast', message: 'No booking selected. Please try again.');
        return;
    }
    if (in_array($this->statusUpdate, ['returned', 'rejected', 'cancelled'])) {
        $this->validate([
            'returnComment' => 'required|min:5'
        ]);
    }
    $oldStatus = $this->selectedBooking->status; // <--- Add this line before update
    $this->selectedBooking->update([
        'status' => $this->statusUpdate,
        'return_reason' => in_array($this->statusUpdate, ['returned', 'rejected', 'cancelled']) ? $this->returnComment : null
    ]);
    // Notify the user (email + dashboard)
    if ($this->selectedBooking->user) {
        $this->selectedBooking->user->notify(
            new BookingStatusChangedNotification($this->selectedBooking, $oldStatus, $this->statusUpdate)
        );
    }
    $this->reset(['selectedBooking', 'statusUpdate', 'returnComment', 'showModal']);
    $this->dispatch('toast', message: 'Booking updated successfully');
}
}
