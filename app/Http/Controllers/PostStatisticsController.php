<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\PostStatisticsService;

class PostStatisticsController extends Controller
{
    protected $postStatisticsService;

    public function __construct(PostStatisticsService $postStatisticsService)
    {
        $this->postStatisticsService=$postStatisticsService;
    }

    public function getTopFivePostsByLikes()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->getTopFivePostsByLikes();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function calculatePostEngagementRate()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->calculatePostEngagementRate();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getBestPostingTimes()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->getBestPostingTimes();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getAverageLikesPerPost()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->getAverageLikesPerPost();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getMostViralPost()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->getMostViralPost();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);
    }

    public function getFollowersRetentionRate()
    {
        $this->authorize("viewPostStatistics",User::class);        
        $result = $this->postStatisticsService->getFollowersRetentionRate();
        return new ApiResponse($result["data"], $result["success"], $result["message"], $result["code"]);       
    }
}
