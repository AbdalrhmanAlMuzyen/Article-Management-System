<?php
namespace App\Service;

use App\DTO\Notification\ShowNotificationDTO;
use App\Repository\NotificationRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;

class NotificationService{
    protected $notificationRepository;
    use ReturnTrait;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository=$notificationRepository;
    }

    public function getNotificationMessage($type, $status)
    {
        switch ($type) {

            case "authorRequest":

                if ($status === 'approved') {
                    return [
                        "title" => "Your author request has been approved",
                        "body"  => "Congratulations! Your request to become a writer has been approved. You now have access to writer features.",
                    ];
                } else { 
                    return [
                        "title" => "Your author request has been rejected",
                        "body"  => "Your request to become a writer has been rejected. You may submit a new request after improving your writing sample.",
                    ];
                }

            break;
        }
    }

    public function getPostNotificationMessage($status, $postTitle)
    {
        if ($status === 'published') {
            return [
                "title" => "Your post has been approved",
                "body"  => "Congratulations! Your post titled '{$postTitle}' has been approved and published.",
            ];
        } else {
            return [
                "title" => "Your post has been rejected",
                "body"  => "Your post titled '{$postTitle}' has been rejected by moderators. You can edit it and submit again.",
            ];
        }
    }

    public function getMynotifications()
    {
        try {
            $user = Auth::guard("user")->user();

            $notifications = $this->notificationRepository->getMynotifications($user);

            if ($notifications->isEmpty()) {
                return $this->error(false, "No notifications found", null, 404);
            }

            return $this->success(true, "Notifications retrieved successfully", $notifications, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function showNotification(ShowNotificationDTO $dto)
    {
        try {
            $user = Auth::guard("user")->user();
            $notification = $this->notificationRepository->findNotificationByID($user, $dto);

            if (!$notification) {
                return $this->error(false, "Notification not found", null, 404);
            }

            $this->notificationRepository->updateNotification($notification);

            return $this->success(true, "Notification retrieved successfully", $notification, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }



}