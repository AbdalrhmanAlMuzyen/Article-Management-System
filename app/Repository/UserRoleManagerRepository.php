<?php 

namespace App\Repository;

use App\Models\User;

class UserRoleManagerRepository{

    public function assignRoles(User $user,$role)
    {
        return $user->assignRole($role);
    }
}