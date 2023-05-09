<?php

namespace NovatoPro\Lrp\Http\Livewire;

use Livewire\Component;
use NovatoPro\Lrp\Models\Permission;
use NovatoPro\Lrp\Models\Role;
use Illuminate\Support\Str;

class RolePermission extends Component
{
    public $search, $roletitle = 'Create new role', $permissiontitle = 'Create new permission';
    public Role $role;
    public Permission $permission;
    public function rules()
    {
        return [
            'role' => 'array',
            'role.name' => 'nullable',
            'role.slug' => 'nullable',
            'permission' => 'array',
            'permission.name' => 'nullable',
            'permission.slug' => 'nullable',
            'permission.description' => 'nullable',
        ];
    }
    public function mount()
    {
        $this->resetInputs();
    }
    public function render()
    {
        return view('livewire.role-permission', ['roles' => Role::when($this->search,fn($q)=>$q->where('name','like',"%$this->search%"))->get(), 'permissions' => Permission::when($this->search,fn($q)=>$q->where('name','like',"%$this->search%"))->get()]);
    }
    public function resetInputs()
    {
        $this->reset('roletitle', 'permissiontitle');
        $this->role = new Role;
        $this->permission = new Permission;
    }
    public function updatedRole($value, $property)
    {
        if ($property == 'name') {
            $this->role->slug = Str::slug($value);
        }
    }
    public function editrole(Role $role)
    {
        $this->roletitle = "Edit role";
        $this->role = $role;
    }
    public function saverole()
    {
        $this->validate([
            'role.name'=>'required|unique:roles,name,'.$this->role->id,
            'role.slug'=>'required|unique:roles,slug,'.$this->role->id,
        ]);
        $this->resetErrorBag();
        $this->role->save();
        session()->flash('message', 'Role successfully saved.');
        $this->resetInputs();
    }
    public function updatedPermission($value, $property)
    {
        if ($property == 'name') {
            $this->permission->slug = Str::slug($value);
        }
    }
    public function editpermission(Permission $permission)
    {
        $this->permissiontitle = "Edit permission";
        $this->permission = $permission;
    }
    public function savepermission()
    {
        $this->validate([
            'permission.name'=>'required|unique:permissions,name,'.$this->permission->id,
            'permission.slug'=>'required|unique:permissions,slug,'.$this->permission->id,
            'permission.description'=>'nullable|max:500',
        ]);
        $this->resetErrorBag();
        $this->permission->save();
        session()->flash('message', 'Permission successfully saved.');
        $this->resetInputs();
    }
}
