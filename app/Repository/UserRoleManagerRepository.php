<?php 

namespace App\Repository;

use App\Models\User;

class UserRoleManagerRepository{

    public function assignRoles(User $user,$role)
    {
        return $user->assignRole($role);
    }

    public function givePermissions(User $user,$permissions)
    {
        return $user->givePermissionTo($permissions);
    }

    public function syncPermissions(User $user,$permissions)
    {
        return $user->syncPermissions($permissions);
    }

}