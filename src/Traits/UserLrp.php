<?php

namespace NovatoPro\Lrp\Traits;
use NovatoPro\Lrp\Models\Role;

trait UserLrp
{
    public function roles()
    {
        return $this->belongsToMany(Role::class)->with('permissions');
    }

    public function hasPermissions($permissions)
    {
        return $this->roles()->whereHas('permissions',fn($p)=>$p->whereIn('slug',$permissions))->count();
    }
}
