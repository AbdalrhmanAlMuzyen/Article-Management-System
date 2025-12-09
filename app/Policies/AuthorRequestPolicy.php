<?php

namespace App\Policies;

use App\Models\AuthorRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuthorRequestPolicy
{
    public function viewMyAuthorRequests(User $user)
    {
        return $user->hasRole("reader");
    }

    public function createAuthorRequest(User $user)
    {
        return $user->hasRole("reader");
    }

    public function viewAuthorRequests(User $user)
    {
        return $user->hasAnyRole(["admin","editor"]) && $user->can("authorRequest.view");
    }

    public function handleAuthorRequest(User $user)
    {
        return $user->hasAnyRole(["admin","editor"]) && ($user->can("authorRequest.update"));
    }

}
