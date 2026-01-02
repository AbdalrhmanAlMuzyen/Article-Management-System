<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewRoles(User $user)
    {
        return $user->hasRole("admin");
    }

    public function viewPermissions(User $user)
    {
        return $user->hasRole("admin");
    }

    public function createUser(User $user): bool
    {
        return  $user->hasRole("admin");
    }

    public function deleteUser(User $user)
    {
        return $user->hasRole("admin");
    }

    public function viewFollowerStatistics(User $user)
    {
        return $user->hasAnyRole(["writer","reader"]);
    }

    public function viewPostStatistics(User $user)
    {
        return $user->hasRole("writer");
    }

    public function viewDashboard(User $user)
    {
        return $user->hasRole("admin");
    }

    public function toggleLike(User $user)
    {
        return $user->hasAnyRole(["writer","reader"]);
    }

    public function homeFeed(User $user)
    {
        return $user->hasAnyRole(["writer","reader"]);
    }

    public function getUsers(User $user)
    {
        return $user->hasRole("admin");
    }

}
