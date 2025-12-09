<?php

namespace App\Http\Controllers;

use App\DTO\Notification\ShowNotificationDTO;
use App\Http\Requests\Notification\ShowNotificationRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Notification;
use App\Service\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService=$notificationService;
    }

    public function getMynotifications()
    {
        $this->authorize("viewMyNotifications",Notification::class);
        $result=$this->notificationService->getMynotifications();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }

    public function showNotification(ShowNotificationRequest $request)
    {
        $this->authorize("showNotification",Notification::class);
        $result=$this->notificationService->showNotification(ShowNotificationDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }    
}
