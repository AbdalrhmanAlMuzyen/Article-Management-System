<?php 

namespace App\Repository;

use App\DTO\Notification\ShowNotificationDTO;
use App\Models\Notification;

class NotificationRepository{

    public function createNotification($user_id,$title,$body)
    {
        return Notification::create([
            "user_id"=>$user_id,
            "title"=>$title,
            "body"=>$body
        ]);
    }

    public function getMynotifications($user)
    {
        return $user->notifications()->orderBy("created_at","DESC")->get();
    }

    public function findNotificationByID($user,ShowNotificationDTO $dto) 
    {
        return $user->notifications()->find($dto->notification_id);
    }

    public function updateNotification($notification)
    {
        return $notification->update([
            "read_at"=>now()
        ]);
    }
}