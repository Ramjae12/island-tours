<div class="p-6">
    <div class="mb-4 flex justify-end">
        <a href="/booking" class="btn btn-primary">+ New Booking</a>
    </div>
    <h2 class="text-xl font-bold mb-4">My Bookings</h2>
    <table class="w-full border">
        <thead>
            <tr>
                <th class="p-2 border">Reference</th>
                <th class="p-2 border">Date</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td class="p-2 border">{{ $booking->id }}</td>
                <td class="p-2 border">{{ \Illuminate\Support\Carbon::parse($booking->date)->format('M d, Y') }}</td>
                <td class="p-2 border">{{ ucfirst($booking->status) }}</td>
                <td class="p-2 border">
                    <a href="{{ route('user.booking.show', $booking->id) }}" class="text-blue-600">View</a>
                    @if($booking->status === 'approved')
                        <a href="{{ route('user.booking.pay', $booking->id) }}" class="text-green-600 ml-2">Pay Now</a>
                    @endif
                    @if($booking->status === 'returned')
                        <a href="{{ route('user.booking.edit', $booking->id) }}" class="text-yellow-600 ml-2">Edit</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-2 text-center">No bookings found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
