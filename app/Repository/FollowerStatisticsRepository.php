<?php

namespace App\Repository;

use App\DTO\FollowerStatistics\GetFollowersGrowthDTO;

class FollowerStatisticsRepository{

    public function getFollowersGrowth(GetFollowersGrowthDTO $dto ,$user)
    {
        switch($dto->groupBy)
        {
            case "yearly" :
                return $user->followers()->selectRaw("DATE_FORMAT(created_at,'%Y') AS year , COUNT(*) AS followers_count")->groupBy("year")->orderBy("year")->get();
            break;
            
            case "monthly" :
                return $user->followers()->selectRaw("DATE_FORMAT(created_at,'%Y-%m') AS month , COUNT(*) AS followers_count")->groupBy("month")->orderBy("month")->get();
            break;

            default :
                return $user->followers()->selectRaw("DATE_FORMAT(created_at,'%Y-%m-%d') AS day , COUNT(*) AS followers_count")->groupBy("day")->orderBy("day")->get();
            break;   
        }
    }

    public function getTopPostsByFollowersGain($user)
    {
        return $user->posts()->where("status","published")->selectRaw("* , (SELECT COUNT(followers.follower_id) FROM followers WHERE followers.user_id = posts.user_id AND followers.created_at BETWEEN posts.created_at AND DATE_ADD(NOW(),INTERVAL 48 HOUR) ) AS followers_gain")->orderBy("followers_gain","DESC")->get();
    }

    public function getFollowersByAccountAge($user)
    {
        return $user->followers()->selectRaw("
            COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) AS last_30_days,
            COUNT(CASE WHEN DATEDIFF(NOW(), created_at) > 365 THEN 1 END) AS more_than_year,
            COUNT(CASE WHEN DATEDIFF(NOW(), created_at) BETWEEN 31 AND 364 THEN 1 END) AS from_1_month_to_1_year
        ")->first();
    }

    public function getTopEngagedFollowers($user)
    { 
        return $user->posts()->selectRaw("users.first_name,users.last_name , COUNT(*) AS likes_count")->join("likes","likes.post_id","posts.id")->join("users","users.id","likes.user_id")->groupBy("users.first_name","users.last_name")->get();
    }

    public function getMonthlyFollowersComparison($user)
    {
        return $user->followers()
            ->selectRaw("
                COUNT(
                    CASE 
                        WHEN MONTH(created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
                        AND YEAR(created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))
                        THEN 1 
                    END
                ) AS last_month,
                
                COUNT(
                    CASE 
                        WHEN MONTH(created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 2 MONTH))
                        AND YEAR(created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 2 MONTH))
                        THEN 1 
                    END
                ) AS previous_month
            ")
            ->first();
    }

}