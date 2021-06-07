<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * hasRole
     * we’re iterating through the roles and checking by the slug field, 
     * if that specific role exists
     *
     * @param  mixed $roles
     * @return void
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * this method will check between these two conditions
     * check each permission associated with a roles and permissions table.
     *
     * @param  mixed $permission
     * @return void
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * hasPermission
     * User may have individual Permission for some actions.
     *
     * @param  mixed $permission
     * @return void
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    /**
     * hasPermissionThroughRole
     * User may have Permission through a Role
     *
     * @param  mixed $permission
     * @return void
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * give a set of permissions to a logged in user
     *
     * @param  mixed $permissions
     * @return void
     */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    /**
     * removing permissions from the user scope
     *
     * @param  mixed $permissions
     * @return void
     */
    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }
}
