<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Booking;

class BookingStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;
    public $oldStatus;
    public $newStatus;

    public function __construct(Booking $booking, $oldStatus, $newStatus)
    {
        $this->booking = $booking;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Status Updated')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The status of your booking has changed from ' . ucfirst($this->oldStatus) . ' to ' . ucfirst($this->newStatus) . '.')
            ->line('Booking Reference: ' . $this->booking->id)
            ->action('View Booking', url('/user/bookings/' . $this->booking->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your booking status changed from ' . ucfirst($this->oldStatus) . ' to ' . ucfirst($this->newStatus) . '.',
            'booking_id' => $this->booking->id,
        ];
    }
}
