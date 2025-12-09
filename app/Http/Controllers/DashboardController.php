<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getTotalUsers()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTotalUsers();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getNewUsersLast30Days()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getNewUsersLast30Days();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopUsersByFollowers()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopUsersByFollowers();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTotalPosts()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTotalPosts();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopCategoriesByPosts()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopCategoriesByPosts();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopPostsByLikes()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopPostsByLikes();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopUsersByPosts()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopUsersByPosts();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getPostsCountByPeriod()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getPostsCountByPeriod();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopHoursByLikes()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopHoursByLikes();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getTopDaysByLikes()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getTopDaysByLikes();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getMonthlyUserGrowthRate()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getMonthlyUserGrowthRate();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getWeeklyUserGrowthRate()
    {
        $this->authorize("viewDashboard",User::class);
        $result = $this->dashboardService->getWeeklyUserGrowthRate();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }
}
