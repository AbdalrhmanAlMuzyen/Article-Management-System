<?php

namespace App\Service;

use App\Repository\DashboardRepository;
use App\ReturnTrait;

class DashboardService
{
    protected $dashboardRepository;
    use ReturnTrait;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getTotalUsers()
    {
        try {
            $totalUsers = $this->dashboardRepository->getTotalUsers();

            if (!$totalUsers) {
                return $this->error(false, "No users found", null, 404);
            }

            return $this->success(true, "Total users retrieved successfully", $totalUsers, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getNewUsersLast30Days()
    {
        try {
            $count = $this->dashboardRepository->getNewUsersLast30Days();

            return $this->success(true, "New users in the last 30 days retrieved successfully", $count, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getTopUsersByFollowers()
    {
        try {
            $users = $this->dashboardRepository->getTopUsersByFollowers();

            if ($users->isEmpty()) {
                return $this->error(false, "No users with followers found", null, 404);
            }

            return $this->success(true, "Top users by followers retrieved successfully", $users, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getTotalPosts()
    {
        try {
            $totalPosts = $this->dashboardRepository->getTotalPosts();

            return $this->success(true, "Total posts retrieved successfully", $totalPosts, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getTopCategoriesByPosts()
    {
        try {
            $categories = $this->dashboardRepository->getTopCategoriesByPosts();

            if ($categories->isEmpty()) {
                return $this->error(false, "No categories found", null, 404);
            }

            return $this->success(true, "Top categories by posts retrieved successfully", $categories, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getTopPostsByLikes()
    {
        try {
            $posts = $this->dashboardRepository->getTopPostsByLikes();

            if ($posts->isEmpty()) {
                return $this->error(false, "No posts found", null, 404);
            }

            return $this->success(true, "Top posts by likes retrieved successfully", $posts, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }

    public function getTopUsersByPosts()
    {
        try {
            $users = $this->dashboardRepository->getTopUsersByPosts();

            if ($users->isEmpty()) {
                return $this->error(false, "No users found", null, 404);
            }

            return $this->success(true, "Top users by posts retrieved successfully", $users, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getPostsCountByPeriod()
    {
        try {
            $counts = $this->dashboardRepository->getPostsCountByPeriod();

            return $this->success(true, "Posts count by period retrieved successfully", $counts, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getTopHoursByLikes()
    {
        try {
            $hours = $this->dashboardRepository->getTopHoursByLikes();

            if ($hours->isEmpty()) {
                return $this->error(false, "No like data found", null, 404);
            }

            return $this->success(true, "Top hours by likes retrieved successfully", $hours, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getTopDaysByLikes()
    {
        try {
            $days = $this->dashboardRepository->getTopDaysByLikes();

            if ($days->isEmpty()) {
                return $this->error(false, "No like data found", null, 404);
            }

            return $this->success(true, "Top days by likes retrieved successfully", $days, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getMonthlyUserGrowthRate()
    {
        try {
            $rate = $this->dashboardRepository->getMonthlyUserGrowthRate();

            return $this->success(true, "Monthly user growth rate retrieved successfully", $rate, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getWeeklyUserGrowthRate()
    {
        try {
            $rate = $this->dashboardRepository->getWeeklyUserGrowthRate();

            return $this->success(true, "Weekly user growth rate retrieved successfully", $rate, 200);
        } catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }

    public function getMonthlyPostGrowthRate() {
        try{
            $rate = $this->dashboardRepository->getMonthlyPostGrowthRate();

            return $this->success(true, "Monthly post growth rate retrieved successfully", $rate, 200);
        }
        catch(\Exception $e)
        {
            return $this->error(false, "An error occurred: ".$e->getMessage());            
        }

    }

    public function getWeeklyPostGrowthRate() {
        try{
            $rate = $this->dashboardRepository->getWeeklyPostGrowthRate();

            return $this->success(true, "Weekly post growth rate retrieved successfully", $rate, 200);
        }
        catch(\Exception $e)
        {
            return $this->error(false, "An error occurred: ".$e->getMessage());
        }
    }
}
