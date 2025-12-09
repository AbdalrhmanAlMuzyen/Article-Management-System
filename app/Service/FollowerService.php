<?php
namespace App\Service;

use App\DTO\Follower\ToggleFollowDTO;
use App\Repository\FollowerRepository;
use App\Repository\UserManagementRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;

class FollowerService{
    use ReturnTrait;
    protected $followerRepository;
    protected $userManagementRepository;

    public function __construct(FollowerRepository $followerRepository,UserManagementRepository $userManagementRepository)
    {
        $this->followerRepository=$followerRepository;
        $this->userManagementRepository=$userManagementRepository;
    }

    public function toggleFollow(ToggleFollowDTO $dto)
    {
        try{
            $user=$this->userManagementRepository->findUserById($dto->user_id);
            $isFollowing=$this->followerRepository->isFollowing($user);

            $this->followerRepository->toggleFollow($user,$isFollowing);
            
            return $this->success(true, $isFollowing ? "Unfollowed successfully" : "Followed successfully");
        }
        catch(\Exception $e)
        {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getMyFollowers()
    {
        try {
            $user = Auth::guard("user")->user();
            $followers = $this->followerRepository->getMyFollowers($user);

            if ($followers->isEmpty()) {
                return $this->error(false, "No followers found.", null, 404);
            }

            return $this->success(true, "Followers retrieved successfully.", $followers, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error occurred: " . $e->getMessage());
        }
    }

    
}