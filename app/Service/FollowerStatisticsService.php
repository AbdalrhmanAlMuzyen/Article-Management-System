<?php

namespace App\Service;

use App\DTO\FollowerStatistics\GetFollowersGrowthDTO;
use App\Repository\FollowerStatisticsRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;

class FollowerStatisticsService{
    use ReturnTrait;

    protected $followerStatisticsRepository;

    public function __construct(FollowerStatisticsRepository $followerStatisticsRepository)
    {
        $this->followerStatisticsRepository=$followerStatisticsRepository;
    }

    public function getFollowersGrowth(GetFollowersGrowthDTO $dto)
    {
        try {
            $user = Auth::guard("user")->user();

            $growthData = $this->followerStatisticsRepository->getFollowersGrowth($dto, $user);

            return $this->success(true, "Followers growth retrieved successfully",$growthData,200);

        } catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage(), 500);
        }
    }

    public function getTopPostsByFollowersGain()
    {
        try {
            $topPosts = $this->followerStatisticsRepository->getTopPostsByFollowersGain(Auth::guard("user")->user());

            if ($topPosts->isEmpty()) {
                return $this->error(false, "No posts found.", null, 404);
            }

            return $this->success(true, "Top posts retrieved successfully.", $topPosts, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getFollowersByAccountAge()
    {
        try {
            $user = Auth::guard("user")->user();

            $stats = $this->followerStatisticsRepository->getFollowersByAccountAge($user);

            return $this->success(true, "Followers age distribution retrieved successfully.", $stats, 200);
        }
        catch (\Exception $e) {

            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getMonthlyFollowersComparison()
    {
        try {
            $user = Auth::guard("user")->user();

            $stats = $this->followerStatisticsRepository->getMonthlyFollowersComparison($user);

            return $this->success(true, "Monthly followers comparison retrieved successfully.", $stats, 200);
        }
        catch (\Exception $e) {

            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }        
    }


}