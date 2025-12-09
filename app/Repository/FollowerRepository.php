<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerRepository{

   public function toggleFollow($user, $isFollowing)
    {
        if (!$isFollowing) {
            return $user->followers()->create([
                "follower_id" => Auth::guard("user")->user()->id,
            ]);
        } else {
            return $user->followers()
                        ->where("follower_id", Auth::guard("user")->user()->id)
                        ->delete();
        }
    }

    public function isFollowing($user)
    {
        return $user->followers()
                    ->where("follower_id", Auth::guard("user")->user()->id)
                    ->exists();
    }

    public function getMyFollowers($user)
    {
        return User::whereHas("followings",function($query) use ($user){
            $query->where("user_id",$user->id);
        })->orderBy("first_name","ASC")->orderBy("last_name","ASC")->get();
    }

    

}