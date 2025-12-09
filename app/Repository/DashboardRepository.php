<?php
namespace App\Repository;

use App\Models\Category;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class DashboardRepository {

    public function getTotalUsers() {
        return User::whereDoesntHave("roles",function($query){
            $query->where("name","admin")->orWhere("name","editor");
        })->count();
    }

    public function getNewUsersLast30Days() {
        return User::whereDoesntHave("roles",function($query){
            $query->where("name","admin")->orWhere("name","editor");
        })->where("created_at", ">=", now()->subDays(30))->count();
    }

    public function getTopUsersByFollowers() {
        return User::withCount("followers AS followers_count")
                    ->orderBy("followers_count", "DESC")
                    ->limit(3)
                    ->get();
    }

    public function getTotalPosts() {
        return Post::count();
    }

    public function getTopCategoriesByPosts() {
        return Category::withCount("posts AS posts_count")
                       ->orderBy("posts_count", "DESC")
                       ->limit(3)
                       ->get();
    }

    public function getTopPostsByLikes() {
        return Post::withCount("likes AS likes_count")
                   ->orderBy("likes_count", "DESC")
                   ->having("likes_count",">",0)
                   ->limit(10)
                   ->get();
    }

    public function getTopUsersByPosts() {
        return User::withCount("posts AS posts_count")
                   ->orderBy("posts_count", "DESC")
                   ->having("posts_count",">",0)
                   ->limit(3)
                   ->get();
    }

    public function getPostsCountByPeriod() {
        return [
            "today" => Post::whereDate("created_at", today())->count(),
            "this_week" => Post::where("created_at", ">=", now()->subDays(7))->count(),
            "this_month" => Post::where("created_at", ">=", now()->subDays(30))->count(),
        ];
    }

    public function getTopHoursByLikes() {
        return Like::selectRaw("HOUR(created_at) AS hour, COUNT(*) AS likes_count")
                   ->havingRaw("likes_count > 0 AND hour IS NOT NULL")
                   ->orderBy("likes_count", "DESC")
                   ->groupBy("hour")
                   ->get();
    }

    public function getTopDaysByLikes() {
        return Like::selectRaw("DAYNAME(created_at) AS day, COUNT(*) AS likes_count")
                   ->havingRaw("likes_count > 0 AND day IS NOT NULL")
                   ->orderBy("likes_count", "DESC")
                   ->groupBy("day")
                   ->get();
    }

    public function getMonthlyUserGrowthRate() {
        return User::selectRaw("
            IFNULL
            (
                (
                    (
                        COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 END)
                        -
                        COUNT(CASE WHEN MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)
                    )
                    /
                    NULLIF(COUNT(CASE WHEN MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END),0)
                )
            ,0) * 100 AS growth_rate   
        ")->first();
    }

    public function getWeeklyUserGrowthRate() {
        return User::selectRaw("
            IFNULL 
            (
                        (
                            (
                                COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) 
                                -
                                COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND created_at < DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END)
                            )
                            /
                            NULLIF(COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND created_at < DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END),0)
                        )
            ,0) * 100 AS growth_rate
        ")->first();
    }

    public function getMonthlyPostGrowthRate() {
        return Post::selectRaw("
            IFNULL
            (
                (
                    (
                        COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN 1 END)
                        -
                        COUNT(CASE WHEN MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END)
                    )
                    /
                    NULLIF(COUNT(CASE WHEN MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) THEN 1 END),0)
                )
            ,0) * 100 AS growth_rate
        ")->first();
    }

    public function getWeeklyPostGrowthRate() {
        return Post::selectRaw("
            IFNULL 
            (
                        (
                            (
                                COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END) 
                                -
                                COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND created_at < DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END)
                            )
                            /
                            NULLIF(COUNT(CASE WHEN created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND created_at < DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 END),0)
                        )
            ,0) * 100 AS growth_rate
        ")->first();
    }
}
