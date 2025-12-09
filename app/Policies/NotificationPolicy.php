<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function viewMyNotifications(User $user)
    {
        return $user->hasAnyRole(["writer","reader"]);
    }

    public function showNotification(User $user)
    {
        return $user->hasAnyRole(["writer","reader"]);
    }
}
