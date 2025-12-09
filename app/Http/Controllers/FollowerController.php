<?php

namespace App\Http\Controllers;

use App\DTO\Follower\ToggleFollowDTO;
use App\Http\Requests\Follower\ToggleFollowRequest;
use App\Http\Resources\ApiResponse;
use App\Service\FollowerService;

class FollowerController extends Controller
{
    protected $followerService;

    public function __construct(FollowerService $followerService)
    {
        $this->followerService=$followerService;
    }

    public function toggleFollow(ToggleFollowRequest $request)
    {
        $result=$this->followerService->toggleFollow(ToggleFollowDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }

    public function getMyFollowers()
    {
        $result=$this->followerService->getMyFollowers();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

}
