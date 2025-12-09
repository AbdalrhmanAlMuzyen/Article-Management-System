<?php
namespace App\Repository;

use App\Models\User;

class LikeRepository{
    
    public function hasUserLiked($post,$user)
    {
        return $post->likes()->where("user_id",$user->id)->exists();
    }

    public function toggleLike($post,$user)
    {
        return $post->likes()->create([
            "user_id"=>$user->id
        ]);
    }

    public function updateLikesCount($post,$status)
    {
        switch($status)
        {
            case false :
                return $post->update([
                    "likes_count"=>$post->likes_count +1
                ]);
            break; 
            
            default :
                return $post->update([
                    "likes_count"=>$post->likes_count -1
                ]);
        }
    }

    public function deleteLike($post,$user)
    {
        return $post->likes()->where("user_id",$user->id)->delete();
    }

    public function getPostLikers($post)
    {
        return User::whereHas("likes",function($query) use ($post){
            $query->where("post_id",$post->id);
        })->get();
    }
   
    
}