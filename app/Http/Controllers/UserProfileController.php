<?php

namespace App\Http\Controllers;

use App\DTO\UserProfileData\GetUserProfileDTO;
use App\Http\Requests\UserProfileData\GetUserProfileDataRequest;
use App\Http\Resources\ApiResponse;
use App\Service\UserProfileService;

class UserProfileController extends Controller
{
    protected $userProfileService;

    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService=$userProfileService;
    }

    public function getUserProfileData(GetUserProfileDataRequest $request)
    {
        $result=$this->userProfileService->getUserProfileData(GetUserProfileDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getMyProfile()
    {
        $result=$this->userProfileService->getMyProfile();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }    
}
