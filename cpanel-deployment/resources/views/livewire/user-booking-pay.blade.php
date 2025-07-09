<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Pay for Booking</h2>
    <p><strong>Booking Reference:</strong> {{ $booking->id }}</p>
    <p><strong>Amount:</strong> ₱{{ number_format($booking->total_amount, 2) }}</p>
    <!-- Add your payment gateway/button here -->
</div>
