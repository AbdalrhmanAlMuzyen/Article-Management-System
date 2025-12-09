<?php
namespace App\Service;

use App\Repository\PostStatisticsRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;

class PostStatisticsService{
    use ReturnTrait;
    
    protected $postStatisticsRepository;

    public function __construct(PostStatisticsRepository $postStatisticsRepository)
    {
        $this->postStatisticsRepository=$postStatisticsRepository;
    }


    public function getTopFivePostsByLikes()
    {
        try {
            $user = Auth::guard("user")->user();
            $posts = $this->postStatisticsRepository->getTopFivePostsByLikes($user);

            if ($posts->isEmpty()) {
                return $this->error(false, "No posts found", null, 404);
            }

            return $this->success(true, "Top 5 posts retrieved successfully", $posts, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function calculatePostEngagementRate()
    {
        try {
            $user=Auth::guard("user")->user();
            $data = $this->postStatisticsRepository->calculatePostEngagementRate($user);

            if ($data->isEmpty()) {
                return $this->error(false, "No posts available to calculate engagement rate.", null, 404);
            }

            return $this->success(true, "Post engagement rates retrieved successfully.", $data, 200);

        } catch (\Exception $e) {

            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }


    public function getBestPostingTimes()
    {
        try {
            $user = Auth::guard("user")->user();
            $data = $this->postStatisticsRepository->getBestPostingTimes($user);
            if ($data->isEmpty()) {
                return $this->error(false, "No engagement data available to analyze posting times.", null, 404);
            }
            return $this->success(true, "Best posting times retrieved successfully", $data, 200);
        }
        catch (\Exception $e) {
            return $this->error(false,"An error occurred: ".$e->getMessage());
        }
    }

    public function getAverageLikesPerPost()
    {
        try {
            $user = Auth::guard("user")->user();
            $avg = $this->postStatisticsRepository->getAverageLikesPerPost($user);

            return $this->success(true, "Average likes per post calculated successfully", $avg, 200);
        }
        catch (\Exception $e) {
            return $this->error(false,"An error occurred: ".$e->getMessage());
        }
    }

    public function getMostViralPost()
    {
        try {
            $user = Auth::guard("user")->user();
            $posts = $this->postStatisticsRepository->getMostViralPost($user);

            if ($posts->isEmpty()) {
                return $this->error(false,"No posts found", null, 404);
            }

            return $this->success(true, "Most viral posts retrieved successfully", $posts, 200);
        }
        catch (\Exception $e) {
            return $this->error(false,"An error occurred: ".$e->getMessage());
        }
    }

    public function getFollowersRetentionRate()
    {
        try {
            $user = Auth::guard("user")->user();

            $rate = $this->postStatisticsRepository->getFollowersRetentionRate($user);

            if ($rate === 0) {
                return $this->success(true,"No new followers in the last 30 days.",["retention_rate" => 0],200);
            }

            return $this->success(true,"Followers retention rate retrieved successfully.",$rate,200);
        }
        catch (\Exception $e) {
            return $this->error(false,"An error occurred: ".$e->getMessage());
        }
    }

}