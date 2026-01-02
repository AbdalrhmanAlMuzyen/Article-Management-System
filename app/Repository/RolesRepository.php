<?php 

namespace App\Repository;

use Spatie\Permission\Models\Role;

class RolesRepository{
    
    public function getRoles()
    {
        return Role::all();
    }
}