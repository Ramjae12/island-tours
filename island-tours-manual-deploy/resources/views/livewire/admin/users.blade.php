<div>
    <h2 class="mb-4 font-bold text-lg">Users Management</h2>

    <!-- Success/Flash Message -->
    @if (session()->has('success'))
        <div class="mb-2 text-green-700 bg-green-100 border border-green-200 rounded p-2">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-2 text-red-700 bg-red-100 border border-red-200 rounded p-2">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add User Button and Search -->
    <div class="flex items-center mb-4 gap-2">
        <button wire:click="$set('showAddUserForm', true)"
            class="px-4 py-2 bg-green-600 text-white rounded border border-green-800 shadow hover:bg-green-700 transition">
            + Add User
        </button>
        <form wire:submit.prevent="searchNow" class="flex items-center gap-1 flex-1">
            <input id="user-search-input" type="text" wire:model="search" placeholder="Search by ID, Name, Email..." class="p-2 border rounded flex-1 min-w-[200px]">
            @if($search)
                <button type="button" wire:click="$set('search', '')" class="px-2 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400" title="Clear">
                    <i class="fas fa-times"></i>
                </button>
            @endif
            <button type="submit" class="hidden">Search</button>
        </form>
    </div>

    <!-- Add User Form -->
    @if($showAddUserForm)
        <form wire:submit.prevent="addUser" class="mb-4 flex flex-wrap items-center gap-2">
            <input type="text" wire:model="newUserName" placeholder="Name" class="p-2 border rounded">
            @error('newUserName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <input type="email" wire:model="newUserEmail" placeholder="Email" class="p-2 border rounded">
            @error('newUserEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <input type="password" wire:model="newUserPassword" placeholder="Password" class="p-2 border rounded">
            @error('newUserPassword') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <select wire:model="newUserRole" class="p-2 border rounded">
                <option value="">Select Role</option>
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
            @error('newUserRole') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded border border-blue-800 shadow hover:bg-blue-700 transition">
                Save
            </button>
            <button type="button" wire:click="$set('showAddUserForm', false)"
                class="px-4 py-2 bg-gray-400 text-white rounded border border-gray-600 shadow hover:bg-gray-500 transition">
                Cancel
            </button>
        </form>
    @endif

    <div class="overflow-x-auto">
        <table class="user-table table-fixed w-full bg-white rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 font-semibold cursor-pointer select-none" wire:click="sortBy('id')">
                        ID
                        <span class="ml-1">@if($sortField === 'id') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="py-2 px-4 font-semibold cursor-pointer select-none" wire:click="sortBy('name')">
                        Name
                        <span class="ml-1">@if($sortField === 'name') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="py-2 px-4 font-semibold cursor-pointer select-none" wire:click="sortBy('email')">
                        Email
                        <span class="ml-1">@if($sortField === 'email') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="py-2 px-4 font-semibold select-none">
                        Roles
                    </th>
                    <th class="py-2 px-4 font-semibold cursor-pointer select-none" wire:click="sortBy('created_at')">
                        Created At
                        <span class="ml-1">@if($sortField === 'created_at') @if($sortDirection === 'asc') ▲ @else ▼ @endif @endif</span>
                    </th>
                    <th class="py-2 px-4 font-semibold text-center align-middle">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 align-middle">{{ $user->id }}</td>
                        <td class="py-2 px-4 align-middle">{{ $user->name }}</td>
                        <td class="py-2 px-4 align-middle">{{ $user->email }}</td>
                        <td class="py-2 px-4 align-middle">
                            {{ implode(', ', $user->getRoleNames()->toArray()) }}
                        </td>
                        <td class="py-2 px-4 align-middle">{{ $user->created_at }}</td>
                        <td class="py-2 px-4 text-center align-middle">
                            @if($editUserId === $user->id)
                                <form wire:submit.prevent="saveRoles" class="flex flex-col items-center gap-2">
                                    <select multiple size="2" wire:model="editRoles" class="border rounded p-1 mb-2 w-full" style="min-width:100px; max-width:140px;">
                                        <option value="admin">admin</option>
                                        <option value="user">user</option>
                                    </select>
                                    <div class="flex gap-2">
                                        <button type="submit"
                                            class="px-2 py-1 bg-green-500 text-white rounded border border-green-800 shadow hover:bg-green-600 transition">
                                            Save
                                        </button>
                                        <button type="button" wire:click="cancelEdit"
                                            class="px-2 py-1 bg-gray-300 text-gray-800 rounded border border-gray-600 shadow hover:bg-gray-400 transition">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="flex flex-col gap-2 items-center">
                                    <button wire:click="startEdit({{ $user->id }})"
                                        class="px-2 py-1 bg-blue-500 text-white rounded border border-blue-800 shadow hover:bg-blue-600 transition">
                                        Edit Roles
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                        <button
                                            onclick="if(!confirm('Are you sure you want to delete this user?')){event.stopImmediatePropagation();event.preventDefault();}"
                                            wire:click.prevent="deleteUser({{ $user->id }})"
                                            class="px-2 py-1 bg-red-600 text-white font-bold rounded border border-red-800 shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 transition">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
