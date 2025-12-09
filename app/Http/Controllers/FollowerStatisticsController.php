<?php

namespace App\Http\Controllers;

use App\DTO\FollowerStatistics\GetFollowersGrowthDTO;
use App\Http\Requests\FollowerStatistics\GetFollowersGrowthRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\FollowerStatisticsService;

class FollowerStatisticsController extends Controller
{
    protected $followerStatisticsService;

    public function __construct(FollowerStatisticsService $followerStatisticsService)
    {
        $this->followerStatisticsService=$followerStatisticsService;
    }

    public function getFollowersGrowth(GetFollowersGrowthRequest $request)
    {
        $this->authorize("viewFollowerStatistics" ,User::class);        
        $result=$this->followerStatisticsService->getFollowersGrowth(GetFollowersGrowthDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }

    public function getTopPostsByFollowersGain()
    {
        $this->authorize("viewFollowerStatistics" ,User::class);        
        $result=$this->followerStatisticsService->getTopPostsByFollowersGain();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getFollowersByAccountAge()
    {
        $this->authorize("viewFollowerStatistics" ,User::class);        
        $result=$this->followerStatisticsService->getFollowersByAccountAge();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getMonthlyFollowersComparison()
    {
        $this->authorize("viewFollowerStatistics" ,User::class);        
        $result=$this->followerStatisticsService->getMonthlyFollowersComparison();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);          
    }



}
