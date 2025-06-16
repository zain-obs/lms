<?php

namespace App\Livewire\UsersTable;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersTable extends Component
{
    use WithPagination;
    public $search = '';
    public $rolesToAssign = [];
    public $rolesToRevoke = [];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editRole($userId)
    {
        $user = User::findOrFail($userId);
        $user->assignRole($this->rolesToAssign);
        foreach ($this->rolesToRevoke as $role) {
            $user->removeRole($role);
        }
        $this->reset(['rolesToAssign', 'rolesToRevoke']);
    }

    public function deleteUser($userId){
        $user = User::findOrFail($userId);
        $user->delete();
    }

    public function render()
    {
        $users = User::with('roles')
            ->where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->paginate(10);
        $roles = Role::all();

        return view('livewire.users-table.users-table', compact('users', 'roles'));
    }
}
