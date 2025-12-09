<?php

namespace App\Service;

use App\DTO\UserProfileData\GetUserProfileDTO;
use App\DTO\UserProfileData\UpdateProfileDTO;
use App\Repository\UserManagementRepository;
use App\Repository\UserProfileRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;

class UserProfileService{
    use ReturnTrait; 
    protected $userProfileRepository;
    protected $userManagementRepository;

    public function __construct(UserProfileRepository $userProfileRepository,UserManagementRepository $userManagementRepository)
    {
        $this->userProfileRepository=$userProfileRepository;
        $this->userManagementRepository=$userManagementRepository;
    }

    public function getUserProfileData(GetUserProfileDTO $dto)
    {
        try{
            $user=$this->userManagementRepository->findUserById($dto->user_id);
            $userProfileData=$this->userProfileRepository->getUserProfileData($user);

            return $this->success(true, "User profile data retrieved successfully", $userProfileData, 200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());
        }
    }

    public function getMyProfile()
    {
        try{
            $user=Auth::guard("user")->user();
            $userProfileData=$this->userProfileRepository->getUserProfileData($user);

            return $this->success(true, "User profile data retrieved successfully",$userProfileData  , 200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());
        }
    }

    public function updateProfile(UpdateProfileDTO $dto)
    {
        try {

            $data = collect([
                "first_name" => $dto->first_name,
                "last_name"  => $dto->last_name
            ])->filter(function ($value) {
                return !is_null($value);
            })->toArray();

            if (empty($data)) {
                return $this->error(false, "No data provided to update", null, 400);
            }

            $this->userProfileRepository->updateProfile(Auth::guard("user")->user(), $data);

            return $this->success(true, "Profile updated successfully", $data, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false,"An error has occurred : ".$e->getMessage());
        }
    }


    

}