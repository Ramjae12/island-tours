<div>
    <h2 class="text-2xl font-bold mb-4">Packages Management</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="mb-6 bg-white p-4 rounded shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <input type="text" wire:model="name" placeholder="Package Name" 
                       class="w-full p-2 border rounded" required>
                <textarea wire:model="description" placeholder="Description" 
                          class="w-full p-2 border rounded"></textarea>
            </div>
            
            <div class="space-y-2">
                <input type="number" wire:model="price" step="0.01" placeholder="Price" 
                       class="w-full p-2 border rounded" required>
                <input type="number" wire:model="discount_price" step="0.01" 
                       placeholder="Discount Price" class="w-full p-2 border rounded">
            </div>

            <div class="space-y-2">
                <select wire:model="type" class="w-full p-2 border rounded" required>
                    <option value="">Select Type</option>
                    <option value="Island Entrance">Island Entrance</option>
                    <option value="Malinta Tunnel">Malinta Tunnel</option>
                    <option value="Seaport">Seaport</option>
                    <option value="Airport">Airport</option>
                </select>
                <input type="text" wire:model="price_label" placeholder="Price Label" 
                       class="w-full p-2 border rounded" value="per person/day">
            </div>

            <div class="space-y-2 flex items-center gap-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="active" class="form-checkbox">
                    <span>Active</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model="requires_id" class="form-checkbox">
                    <span>Requires ID</span>
                </label>
            </div>
        </div>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ $isEditing ? 'Update' : 'Create' }} Package
            </button>
            @if($isEditing)
                <button type="button" wire:click="resetForm" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
            @endif
        </div>
    </form>

    <div class="flex items-center mb-4 gap-2">
        <form wire:submit.prevent="searchNow" class="flex items-center gap-1 flex-1">
            <input type="text" wire:model="search" placeholder="Search by Name, Type, Active, Requires ID..." class="p-2 border rounded flex-1 min-w-[200px]">
            @if($search)
                <button type="button" wire:click="$set('search', '')" class="px-2 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400" title="Clear">
                    <i class="fas fa-times"></i>
                </button>
            @endif
            <button type="submit" class="hidden">Search</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('name')">
                        Name
                        <span class="ml-1">@if($sortField === 'name') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('type')">
                        Type
                        <span class="ml-1">@if($sortField === 'type') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('price')">
                        Price
                        <span class="ml-1">@if($sortField === 'price') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('discount_price')">
                        Discount
                        <span class="ml-1">@if($sortField === 'discount_price') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('active')">
                        Active
                        <span class="ml-1">@if($sortField === 'active') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left cursor-pointer select-none" wire:click="sortBy('requires_id')">
                        Requires ID
                        <span class="ml-1">@if($sortField === 'requires_id') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $package)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $package->name }}</td>
                        <td class="px-4 py-2">{{ $package->type }}</td>
                        <td class="px-4 py-2">₱{{ number_format($package->price, 2) }}</td>
                        <td class="px-4 py-2">
                            @if($package->discount_price)
                                ₱{{ number_format($package->discount_price, 2) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="{{ $package->active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $package->active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span class="{{ $package->requires_id ? 'text-green-600' : 'text-red-600' }}">
                                {{ $package->requires_id ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 space-x-2 flex gap-2">
                            <button wire:click="edit({{ $package->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition flex items-center gap-1">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button wire:click="delete({{ $package->id }})"
                                    onclick="if(!confirm('Delete this package?')){event.stopImmediatePropagation();event.preventDefault();}"
                                    class="px-3 py-1 bg-red-600 text-white font-semibold rounded shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition flex items-center gap-1">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-gray-500">No packages found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $packages->links() }}
    </div>
</div>
