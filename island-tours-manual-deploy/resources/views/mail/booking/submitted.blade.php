<x-mail::message>
# {{ $isAdmin ? 'New Booking Submitted' : 'Booking Confirmation' }}

@if($isAdmin)
A new booking has been submitted by **{{ $booking->full_name }}**.

**Booking Reference:** {{ $booking->id }}

**Date:** {{ \Illuminate\Support\Carbon::parse($booking->date)->format('F j, Y') }}

**Status:** {{ ucfirst($booking->status) }}

<x-mail::button :url="$url">
View Booking in Admin Panel
</x-mail::button>

@else
Hello, **{{ $notifiable->name }}**!

Your booking has been submitted and is now pending review.

**Booking Reference:** {{ $booking->id }}

**Date:** {{ \Illuminate\Support\Carbon::parse($booking->date)->format('F j, Y') }}

**Status:** {{ ucfirst($booking->status) }}

<x-mail::button :url="$url">
View My Bookings
</x-mail::button>

@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
