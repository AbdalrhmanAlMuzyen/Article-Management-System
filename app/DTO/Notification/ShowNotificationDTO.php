<?php

namespace App\DTO\Notification;

class ShowNotificationDTO{
    public int $notification_id;

    public function __construct(int $notification_id)
    {
        $this->notification_id=$notification_id;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("notification_id"));
    }
}