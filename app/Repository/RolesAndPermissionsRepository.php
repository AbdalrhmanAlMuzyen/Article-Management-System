<?php 

namespace App\Repository;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsRepository{
    
    public function getRoles()
    {
        return Role::whereNotIn('name', ['writer', 'reader'])->get();
    }
    public function findRoleByName($name)
    {
        return Role::findByName($name);
    }
    public function getPermissions($role)
    {
        return $role->getPermissionNames();
    }
}