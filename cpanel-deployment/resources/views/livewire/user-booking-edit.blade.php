<div class="p-6 max-w-lg mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Booking</h2>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <form wire:submit.prevent="updateBooking">
        <div class="mb-4">
            <label class="block mb-1 font-medium">Date</label>
            <input type="date" wire:model.defer="date" class="w-full border rounded px-3 py-2">
            @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-medium">Details</label>
            <textarea wire:model.defer="details" class="w-full border rounded px-3 py-2"></textarea>
            @error('details') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Booking</button>
        <a href="{{ route('user.bookings') }}" class="ml-4 text-gray-600 underline">Cancel</a>
    </form>
</div>
