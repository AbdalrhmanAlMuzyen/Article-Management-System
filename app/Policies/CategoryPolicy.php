<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function createCategory(User $user)
    {
        return  $user->hasRole("admin") && $user->can("category.create");
    }

    public function updateCategory(User $user)
    {
        return  $user->hasRole("admin") && $user->can("category.update");
    }

    public function deleteCategory(User $user)
    {
        return  $user->hasRole("admin") && $user->can("category.delete");
    }    
    
}
