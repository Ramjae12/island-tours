@if($booking)
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Booking Details</h2>
    <div class="mb-4">
        <p><strong>Reference:</strong> {{ $booking->id }}</p>
        <p><strong>Date:</strong> {{ \Illuminate\Support\Carbon::parse($booking->date)->format('F j, Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    </div>
    <a href="{{ route('user.bookings') }}" class="text-blue-600 hover:underline">Back to My Bookings</a>
</div>
@else
<div class="p-6 text-red-600">
    <h2 class="text-xl font-bold mb-4">Booking Not Found</h2>
    <p>The booking you are trying to view does not exist or you do not have access to it.</p>
    <a href="{{ route('user.bookings') }}" class="text-blue-600 hover:underline">Back to My Bookings</a>
</div>
@endif
