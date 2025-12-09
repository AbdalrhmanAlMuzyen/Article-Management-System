<?php

namespace App\Http\Controllers;

use App\DTO\HomeFeed\HomeFeedDTO;
use App\Http\Requests\HomeFeed\HomeFeedRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\HomeFeedService;

class HomeFeedController extends Controller
{
    protected $homeFeedService;

    public function __construct(HomeFeedService $homeFeedService)
    {
        $this->homeFeedService=$homeFeedService;
    }

    public function homeFeed(HomeFeedRequest $request)
    {
        $this->authorize("homeFeed",User::class);
        $result=$this->homeFeedService->homeFeed(HomeFeedDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);   
    }
}