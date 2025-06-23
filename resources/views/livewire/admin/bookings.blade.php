<div class="p-6">
    <!-- Filters -->
    <div class="flex gap-2 mb-6 items-center flex-wrap">
        <div class="flex items-center gap-1">
            <input type="text" wire:model.lazy="search" placeholder="Search by Booking ID, Customer, Email..." class="px-4 py-2 border rounded-lg w-72" />
            <button type="button" wire:click="$refresh" class="px-2 py-2 bg-blue-500 text-white rounded hover:bg-blue-600" title="Search">
                <i class="fas fa-search"></i>
            </button>
            @if($search)
                <button type="button" wire:click="$set('search', '')" class="px-2 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400" title="Clear">
                    <i class="fas fa-times"></i>
                </button>
            @endif
        </div>
        <select wire:model="statusFilter" wire:change="sortBy('status')" class="px-4 py-2 border rounded-lg">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="returned">Returned</option>
            <option value="rejected">Rejected</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <input type="date" wire:model="dateFilter" wire:change="sortBy('date')" class="px-4 py-2 border rounded-lg" />
    </div>

    <!-- Bookings Table -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Booking ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 cursor-pointer select-none" wire:click="sortBy('user_id')">
                        Customer
                        <span class="ml-1">
                            @if($sortField === 'user_id')
                                @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 cursor-pointer select-none" wire:click="sortBy('date')">
                        Date
                        <span class="ml-1">
                            @if($sortField === 'date')
                                @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Amount</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500 cursor-pointer select-none" wire:click="sortBy('status')">
                        Status
                        <span class="ml-1">
                            @if($sortField === 'status')
                                @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 text-sm">{{ $booking->id }}</td>
                    <td class="px-6 py-4 text-sm">
                        {{ $booking->user->name ?? 'Guest' }}<br>
                        <span class="text-gray-500">{{ $booking->user->email ?? '' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($booking->date)
                            {{ $booking->date->format('M d, Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">₱{{ number_format($booking->total_amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs 
                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'approved') bg-green-100 text-green-800
                            @elseif($booking->status === 'rejected') bg-red-600 text-white
                            @elseif($booking->status === 'cancelled') bg-gray-400 text-white
                            @elseif($booking->status === 'returned') bg-orange-200 text-orange-900
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <button wire:click="showBooking('{{ $booking->id }}')" 
                                class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                            View Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>

    <!-- Booking Details Modal -->
    @if($showModal && $selectedBooking)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Booking #{{ $selectedBooking->id }}</h2>
                <button wire:click="$set('showModal', false)" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>

            <!-- Customer Details -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Customer Information</h3>
                <p><span class="font-medium">Name:</span> {{ $selectedBooking->full_name }}</p>
                <p><span class="font-medium">Email:</span> {{ $selectedBooking->email }}</p>
                <p><span class="font-medium">Phone:</span> {{ $selectedBooking->phone }}</p>
            </div>

            <!-- Documents -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Uploaded Documents</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($selectedBooking->bookingIds as $document)
                    <a href="{{ route('admin.secure.file', basename($document->file_path)) }}" 
                       target="_blank" 
                       class="text-indigo-600 hover:text-indigo-800 truncate">
                        📄 {{ basename($document->file_path) }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Packages -->
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Selected Packages</h3>
                <div class="space-y-2">
                    @foreach($selectedBooking->bookingPackages as $package)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <div>
                            <span class="font-medium">{{ $package->package->name }}</span>
                            <span class="text-gray-600">({{ $package->quantity }} pax)</span>
                        </div>
                        <span class="text-gray-600">₱{{ number_format($package->package->price, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Status Update -->
            <div class="border-t pt-4">
                <div class="mb-4">
                    <label class="block font-medium mb-2">Status Update</label>
                    <select wire:model.live="statusUpdate" class="w-full border rounded p-2 mb-2">
                        <option value="">Select Action</option>
                        <option value="approved">Approve Booking</option>
                        <option value="returned">Return for Edits</option>
                        <option value="rejected">Reject Booking</option>
                        <option value="cancelled">Cancel Booking</option>
                    </select>
                    @if(in_array($statusUpdate, ['returned', 'rejected', 'cancelled']))
                        <textarea wire:model.live="returnComment"
                                  placeholder="Enter reason for this action..."
                                  class="w-full border rounded p-2 mt-2"
                                  rows="3"></textarea>
                        @error('returnComment') 
                            <span class="text-red-500 text-xs">
                                {{ $message === 'The return comment field is required.' ? 'Please provide at least 5 characters.' : $message }}
                            </span>
                        @enderror
                    @endif
                </div>
                <div class="flex justify-end gap-2">
                    @php
                        $buttonEnabled = $statusUpdate && 
                            (!in_array($statusUpdate, ['returned', 'rejected', 'cancelled']) || 
                            (isset($returnComment) && is_string($returnComment) && strlen(trim($returnComment)) >= 5));
                    @endphp
                    <button wire:click="updateStatus"
                            class="px-4 py-2 rounded text-white font-semibold
                                {{ $buttonEnabled ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed' }}"
                            {{ $buttonEnabled ? '' : 'disabled' }}>
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
