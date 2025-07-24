<div>
    <h2>Date Management</h2>

    @if (session()->has('success'))
        <div class="alert alert-success mb-2">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="mb-4">
        <input type="date" wire:model.defer="date" required>
        <input type="text" wire:model.defer="label" placeholder="Label (optional)">
        <label>
            <input type="checkbox" wire:model.defer="active">
            Active
        </label>
        <button type="submit" class="btn btn-primary">
            {{ $isEditing ? 'Update' : 'Add' }} Date
        </button>
        @if($isEditing)
            <button type="button" wire:click="resetForm" class="btn btn-secondary">Cancel</button>
        @endif
    </form>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Date</th>
                <th>Label</th>
                <th>Active?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dates as $d)
                <tr>
                    <td>{{ $d->date }}</td>
                    <td>{{ $d->label }}</td>
                    <td>
                        @if($d->active)
                            <span class="text-green-600 font-bold">Yes</span>
                        @else
                            <span class="text-gray-500">No</span>
                        @endif
                    </td>
                    <td>
                        <button wire:click="edit({{ $d->id }})" class="btn btn-sm btn-info">Edit</button>
                        <button wire:click="delete({{ $d->id }})" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No dates found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $dates->links() }}
    </div>
</div>
