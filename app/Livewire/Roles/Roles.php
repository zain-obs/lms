<?php

namespace App\Livewire\Roles;

use Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use withPagination;
    public $search = '';
    public $permission = '';
    public $rolesSelection = [];
    public $rolesSelectionToRemove = [];
    public $roleCreationName = '';
    public function addPermission()
    {
        $this->permission = trim($this->permission);
        if (!Permission::where('name', $this->permission)->exists()) {
            Permission::create(['name' => $this->permission, 'guard_name' => 'web']);
        }
        $this->reset(['permission']);
    }

    public function deletePermission($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        if ($permission) {
            $permission->roles()->detach();
            $permission->users()->detach();
            $permission->delete();
            $this->reset(['permission']);
        }
    }

    public function createRole()
    {
        if (!Role::where('name', $this->roleCreationName)->exists()) {
            $role = Role::create(['name' => $this->roleCreationName, 'guard_name' => 'web']);
            if (!empty($this->rolesSelection)) {
                $role->syncPermissions($this->rolesSelection);
            }
            $this->reset(['rolesSelection', 'roleCreationName']);
        }
    }

    public function editRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->givePermissionTo($this->rolesSelection);
        $role->revokePermissionTo($this->rolesSelectionToRemove);
        $this->reset(['rolesSelection', 'rolesSelectionToRemove']);
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();
        $this->reset();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $allPermissions = Permission::all();
        $permissions = Permission::paginate(6);
        $roles = Role::with('permissions')
            ->where('name', 'LIKE', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.roles.roles', ['roles' => $roles, 'permissions' => $permissions, 'allPermissions' => $allPermissions]);
    }
}
