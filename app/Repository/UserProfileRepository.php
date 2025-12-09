<?php

namespace App\Repository;


class UserProfileRepository{

    public function getUserProfileData($user)
    {
        return $user->load(["posts"=>function($query){
            $query->where("status","published")
                ->orderByRaw("created_at DESC , likes_count DESC");
        }])->loadCount("followers","followings")->load("roles");
    }

    public function updateProfile($user,array $data)
    {
        return $user->update($data);
    }

    

}