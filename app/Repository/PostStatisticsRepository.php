<?php
namespace App\Repository;

use App\Models\Like;

class PostStatisticsRepository{

    public function getTopFivePostsByLikes($user)
    {
        return $user->posts()->where("likes_count","!=",0)->orderBy("likes_count","DESC")->limit(5)->get();
    }

    public function calculatePostEngagementRate($user)
    {
        return $user->posts()
            ->selectRaw("
                posts.*,
                (
                    (likes_count / NULLIF((SELECT COUNT(*) FROM followers WHERE followers.user_id = posts.user_id), 0))
                ) * 100 AS engagement_rate
            ")
            ->havingRaw("engagement_rate IS NOT NULL AND engagement_rate > 0")
            ->get();
    }

    public function getBestPostingTimes($user)
    {
        return $user->posts()->selectRaw("HOUR(likes.created_at) AS hour, COUNT(likes.user_id) AS likes_count")->havingRaw("hour IS NOT NULL")->join("likes","likes.post_id","posts.id")->groupBy("hour")->get();
    }

    public function getAverageLikesPerPost($user)
    {
        return $user->posts()
            ->join("likes", "likes.post_id", "posts.id")
            ->selectRaw("
                IFNULL ( COUNT(likes.id) / NULLIF(COUNT(DISTINCT posts.id), 0) ,0) AS avg_likes_per_post
            ")
            ->first();
    }

    public function getMostViralPost($user)
    {
        return $user->posts()->selectRaw("
            posts.*,
            (
                SELECT COUNT(*) 
                FROM likes 
                WHERE likes.post_id = posts.id
                AND likes.created_at BETWEEN posts.created_at 
                AND DATE_ADD(posts.created_at, INTERVAL 24 HOUR)
            ) AS likes_in_24h
        ")->orderBy("likes_in_24h")->get();
    }
    
    public function getFollowersRetentionRate($user)
    {
        $newFollowersCount=$user->followers()->where("created_at",">=",now()->subDays(30))->count();

        if($newFollowersCount==0)
        {
            return 0;
        }

        $newFollowersID=$user->followers()->pluck("follower_id");
        
        
        return Like::join("posts", "posts.id", "likes.post_id")
            ->where("posts.user_id", $user->id)
            ->selectRaw("
                (COUNT(CASE WHEN likes.user_id IN (".$newFollowersID->implode(',').") THEN 1 END) / ?) * 100 AS retention_rate
            ", [$newFollowersCount])
            ->first();
    }
    
    
}