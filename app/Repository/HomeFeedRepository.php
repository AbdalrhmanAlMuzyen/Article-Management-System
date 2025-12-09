<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeFeedRepository{

    public function homeFeed($category_id)
    {
        $totalLimit = 200;

        $newCreatorsLimit    = floor($totalLimit * 0.30); 
        $followingFeedLimit  = floor($totalLimit * 0.40);
        $user_id=Auth::guard("user")->user()->id;

        $newCreatorsPosts = Post::whereHas("user", function ($query) {
                $query->where("created_at", ">=", now()->subDays(15));
            })
            ->where("category_id", $category_id)
            ->where("created_at", ">=", now()->subDays(7))
            ->inRandomOrder()
            ->take($newCreatorsLimit)
            ->get();
        
        $followingPosts = Post::whereHas("user.followers", function ($query) use ($user_id){
                $query->where("followers.follower_id",$user_id);
            })
            ->where("category_id", $category_id)
            ->where("created_at", ">=", now()->subDays(7))
            ->orderBy("created_at", "DESC")
            ->take($followingFeedLimit)
            ->get();  


        $trendingPosts = Post::whereDoesntHave("user.followers", function ($query)  use ($user_id){
                $query->where("followers.follower_id",$user_id);
            })
            ->where("category_id", $category_id)
            ->where("created_at", ">=", now()->subDays(7))
            ->orderBy("likes_count", "DESC")
            ->take(200- ($newCreatorsPosts->count() + $followingPosts->count()))
            ->get();            
        
        return [
            "trendingPosts"=>$trendingPosts,
            "newCreatorsPosts"=>$newCreatorsPosts,
            "followingPosts"=>$followingPosts
        ];
    }


}