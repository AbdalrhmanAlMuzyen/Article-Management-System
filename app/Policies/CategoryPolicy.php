<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function createCategory(User $user)
    {
        return  $user->hasRole("admin");
    }

    public function updateCategory(User $user)
    {
        return  $user->hasRole("admin") ;
    }

    public function deleteCategory(User $user)
    {
        return  $user->hasRole("admin") ;
    }    
    
}
