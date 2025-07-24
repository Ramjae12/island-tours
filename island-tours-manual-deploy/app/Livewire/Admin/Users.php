<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $editUserId = null;
    public $editRoles = [];

    // Add User properties
    public $showAddUserForm = false;
    public $newUserName = '';
    public $newUserEmail = '';
    public $newUserPassword = '';
    public $newUserRole = '';

    public function addUser()
    {
        $validated = $this->validate([
            'newUserName' => 'required|string|max:255',
            'newUserEmail' => 'required|email|unique:users,email',
            'newUserPassword' => 'required|string|min:6',
            'newUserRole' => 'required|string|exists:roles,name',
        ]);

        try {
            // Create user (no legacy role column)
            $user = User::create([
                'name' => $this->newUserName,
                'email' => $this->newUserEmail,
                'password' => bcrypt($this->newUserPassword),
            ]);

            // Assign Spatie role
            $user->assignRole($this->newUserRole);

            // Reset form fields
            $this->resetForm();

            session()->flash('success', 'User added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->showAddUserForm = false;
        $this->reset([
            'newUserName',
            'newUserEmail',
            'newUserPassword',
            'newUserRole'
        ]);
    }

    public function startEdit($userId)
    {
        $this->editUserId = $userId;
        $user = User::find($userId);
        $this->editRoles = $user ? $user->roles->pluck('name')->toArray() : [];
    }

    public function saveRoles()
    {
        $user = User::find($this->editUserId);
        if ($user) {
            // Sync Spatie roles only
            $user->syncRoles($this->editRoles);

            session()->flash('success', 'User roles updated successfully!');
        }
        $this->editUserId = null;
        $this->editRoles = [];
    }

    public function cancelEdit()
    {
        $this->editUserId = null;
        $this->editRoles = [];
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function searchNow()
    {
        // This will force Livewire to re-render with the current search value
        $this->search = $this->search;
        // Optionally, you can reset the page if paginated
        $this->resetPage();
    }

    public function deleteUser($userId)
    {
        // Prevent deleting yourself
        if (auth()->id() == $userId) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user = User::find($userId);
        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        // Prevent deleting the last admin
        if ($user->hasRole('admin')) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                session()->flash('error', 'You cannot delete the last admin user.');
                return;
            }
        }

        // Prevent deleting user with bookings
        if ($user->bookings()->count() > 0) {
            session()->flash('error', 'Cannot delete user with existing bookings. Please delete or reassign their bookings first.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully!');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function($query) {
                $query->where('id', 'like', '%'.$this->search.'%')
                      ->orWhere('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhereHas('roles', function($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.users', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.admin');
    }
}
