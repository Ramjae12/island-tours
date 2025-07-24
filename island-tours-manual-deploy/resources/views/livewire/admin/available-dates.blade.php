<div>
    <h2 class="font-bold text-lg mb-2">Manage Available Dates</h2>
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif
    <form wire:submit.prevent="save" class="flex flex-col gap-4 bg-white p-4 rounded shadow mb-4">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex flex-col">
                <label class="font-semibold mb-1">
                    <input type="radio" wire:model="date_type" value="single" class="mr-1"> Single Date
                </label>
                <label class="font-semibold">
                    <input type="radio" wire:model="date_type" value="range" class="mr-1"> Date Range
                </label>
            </div>
            <div class="flex flex-col w-full max-w-md">
                @if(!$date_type)
                    <div class="text-gray-500 italic mb-2">Please select a date type above.</div>
                @else
                    @if(!$show_picker)
                        <button type="button" wire:click="$set('show_picker', true)" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-3 py-1 rounded mb-2">
                            {{ $date_type === 'single' ? 'Select Date' : 'Select Date Range' }}
                        </button>
                    @else
                        @if($date_type === 'single')
                            <div wire:key="single-date-picker">
                                <label class="mb-1 font-semibold">Select Date</label>
                                <input type="date" wire:model="start_date" class="border rounded px-2 py-2 mb-2" min="{{ now()->format('Y-m-d') }}" />
                            </div>
                        @elseif($date_type === 'range')
                            <div wire:key="range-date-picker">
                                <label class="mb-1 font-semibold">Select Date Range</label>
                                <div class="flex gap-2">
                                    <input type="date" wire:model="start_date" class="border rounded px-2 py-2 w-full" min="{{ now()->format('Y-m-d') }}" />
                                    <span class="self-center">to</span>
                                    <input type="date" wire:model="end_date" class="border rounded px-2 py-2 w-full" min="{{ $start_date ?? now()->format('Y-m-d') }}" />
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="flex flex-col">
                <input type="number" wire:model="max_capacity" min="1" class="border rounded px-2 py-1" placeholder="Max Capacity" @if($closed) disabled @endif>
                @if($closed)
                    <span class="text-xs text-gray-500">No capacity needed when closed.</span>
                @endif
            </div>
            <div class="flex items-center">
                <label class="flex items-center font-semibold">
                    <input type="checkbox" wire:model="closed" class="mr-1"> Closed
                </label>
            </div>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow whitespace-nowrap">Add Date</button>
    </form>
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-2 py-1">Date</th>
                <th class="px-2 py-1">Max Capacity</th>
                <th class="px-2 py-1">Booked</th>
                <th class="px-2 py-1">Closed</th>
                <th class="px-2 py-1">Available</th>
                <th class="px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($availableDates as $ad)
            <tr>
                <td class="px-2 py-1">{{ \Illuminate\Support\Carbon::parse($ad->date)->format('M d, Y') }}</td>
                <td class="px-2 py-1">{{ $ad->capacity ?? $ad->max_capacity }}</td>
                <td class="px-2 py-1">{{ $ad->booked ?? $ad->booked_count ?? 0 }}</td>
                <td class="px-2 py-1">{{ $ad->closed ? 'Yes' : 'No' }}</td>
                <td class="px-2 py-1 font-bold">
                    @if($ad->closed)
                        <span class="text-red-600">Closed</span>
                    @else
                        {{ ($ad->capacity ?? $ad->max_capacity) - ($ad->booked ?? $ad->booked_count ?? 0) }}
                    @endif
                </td>
                <td class="px-2 py-1 flex gap-1">
                    <button wire:click="edit({{ $ad->id }})" class="bg-yellow-300 hover:bg-yellow-400 text-black px-3 py-1 rounded shadow text-xs font-bold">Edit</button>
                    <button wire:click="delete({{ $ad->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-xs font-bold">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2">
        {{ $availableDates->links() }}
    </div>
</div>
