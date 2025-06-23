<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Booking;

class BookingResubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Booking Resubmitted for Review')
            ->greeting('Hello Admin,')
            ->line('A user has resubmitted a booking for review.')
            ->line('Booking Reference: ' . $this->booking->id)
            ->action('View Booking', url('/admin/bookings'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A booking has been resubmitted for review: ' . $this->booking->id,
            'booking_id' => $this->booking->id,
        ];
    }
}
