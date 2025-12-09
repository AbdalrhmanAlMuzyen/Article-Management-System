<?php

namespace App\Http\Controllers;

use App\DTO\Like\GetPostLikersDTO;
use App\DTO\Like\ToggleLikeDTO;
use App\Http\Requests\Like\GetPostLikersRequest;
use App\Http\Requests\Like\ToggleLikeRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\LikeService;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService=$likeService;
    }

    public function toggleLike(ToggleLikeRequest $request)
    {
        $this->authorize("toggleLike",User::class);
        $result=$this->likeService->toggleLike(ToggleLikeDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }

    public function getPostLikers(GetPostLikersRequest $request)
    {
        $result=$this->likeService->getPostLikers(GetPostLikersDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }


}