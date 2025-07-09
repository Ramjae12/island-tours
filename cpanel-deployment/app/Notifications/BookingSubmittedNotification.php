<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingSubmittedNotification extends Notification
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Determine if recipient is admin or user
        $isAdmin = isset($notifiable->role) && $notifiable->role === 'admin';

        $mail = (new MailMessage)
            ->subject($isAdmin ? 'New Booking Submitted' : 'Your Booking Has Been Submitted')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($isAdmin
                ? 'A new booking has been submitted by ' . $this->booking->full_name . '.'
                : 'Your booking has been submitted and is now pending review.'
            )
            ->line('Booking Reference: ' . $this->booking->id)
            ->line('Booking Date: ' . date('F j, Y', strtotime($this->booking->date)))
            ->line('Status: ' . ucfirst($this->booking->status));

        // Set action URL depending on recipient
        if ($isAdmin) {
            $mail->action('View Booking in Admin Panel', url('/admin/bookings'));
        } else {
            $mail->action('View My Bookings', url('/user/bookings'));
        }

        $mail->line('Thank you for using our application!');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->booking->status,
        ];
    }
}
