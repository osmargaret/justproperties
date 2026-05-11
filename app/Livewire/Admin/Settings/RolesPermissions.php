<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RolesPermissions extends Component
{
    public bool $showRoleModal = false;

    public ?int $editingRoleId = null;

    public string $name = '';

    public string $roleSlug = '';

    public string $type = 'admin';

    /** @var list<string> */
    public array $selectedPermissions = [];

    public string $newPermissionName = '';

    public string $newPermissionSlug = '';

    public function openCreateRole(): void
    {
        $this->editingRoleId = null;
        $this->name = '';
        $this->roleSlug = '';
        $this->type = 'admin';
        $this->selectedPermissions = [];
        $this->resetErrorBag();
        $this->showRoleModal = true;
    }

    public function openEditRole(int $id): void
    {
        $role = Role::query()->findOrFail($id);
        $this->editingRoleId = $role->id;
        $this->name = $role->name;
        $this->roleSlug = (string) ($role->slug ?? '');
        $this->type = $role->type;
        $perms = $role->permissions ?? [];
        $this->selectedPermissions = is_array($perms) ? array_values(array_filter($perms)) : [];
        $this->resetErrorBag();
        $this->showRoleModal = true;
    }

    public function closeRoleModal(): void
    {
        $this->showRoleModal = false;
        $this->editingRoleId = null;
    }

    public function saveRole(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'roleSlug' => ['nullable', 'string', 'max:255'],
            'type' => ['required', Rule::in(['admin', 'seller'])],
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['string', 'max:120'],
        ]);

        $slug = $this->roleSlug !== '' ? Str::slug($this->roleSlug) : Str::slug($this->name);

        $slugQuery = Role::query()->where('slug', $slug);
        if ($this->editingRoleId) {
            $slugQuery->where('id', '!=', $this->editingRoleId);
        }
        if ($slugQuery->exists()) {
            $this->addError('roleSlug', __('This slug is already in use.'));

            return;
        }

        $known = Permission::query()->pluck('slug')->all();
        $filtered = array_values(array_intersect($this->selectedPermissions, $known));

        if ($this->editingRoleId) {
            Role::query()->whereKey($this->editingRoleId)->update([
                'name' => $this->name,
                'slug' => $slug,
                'type' => $this->type,
                'permissions' => $filtered,
            ]);
        } else {
            Role::query()->create([
                'name' => $this->name,
                'slug' => $slug,
                'type' => $this->type,
                'permissions' => $filtered,
            ]);
        }

        session()->flash('status', __('Role saved.'));
        $this->closeRoleModal();
    }

    public function deleteRole(int $id): void
    {
        $role = Role::query()->findOrFail($id);
        if ($role->users()->exists()) {
            session()->flash('error', __('Cannot delete a role assigned to users.'));

            return;
        }
        $role->delete();
        session()->flash('status', __('Role deleted.'));
    }

    public function addPermission(): void
    {
        $this->validate([
            'newPermissionName' => ['required', 'string', 'max:255'],
            'newPermissionSlug' => ['required', 'string', 'max:120', 'regex:/^[a-z][a-z0-9_-]*$/', 'unique:permissions,slug'],
        ]);

        Permission::query()->create([
            'name' => $this->newPermissionName,
            'slug' => $this->newPermissionSlug,
        ]);

        $this->newPermissionName = '';
        $this->newPermissionSlug = '';
        session()->flash('status', __('Permission added.'));
    }

    public function render()
    {
        $roles = Role::query()->orderBy('type')->orderBy('name')->get();
        $permissions = Permission::query()->orderBy('slug')->get();

        return view('livewire.admin.settings.roles-permissions', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}
