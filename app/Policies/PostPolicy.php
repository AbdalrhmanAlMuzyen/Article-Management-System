<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function createPost(User $user)
    {
        return $user->hasRole("writer") && $user->can("post.create");
    }

    public function viewMyPosts(User $user)
    {
        return $user->hasRole("writer") && $user->can("post.viewMyPosts");
    }

    public function publishRequest(User $user,Post $post)
    {
        return $user->hasRole("writer") && $user->can("post.publishRequest") && $post->user_id === $user->id;
    }

    public function updatePost(User $user , Post $post)
    {
        return $post->user_id === $user->id || ( $user->hasAnyRole(["admin","editor"]) && $user->can("post.update") );
    }

    public function deletePost(User $user,Post $post)
    {
        return $post->user_id === $user->id || ( $user->hasAnyRole(["admin","editor"]) && $user->can("post.delete") );
    }

    public function publishPost(User $user)
    {
        return $user->hasAnyRole(["admin","editor"]) && $user->can("post.publish");
    }

    public function getPendingPost(User $user)
    {
        return $user->hasAnyRole(["admin","editor"]) && $user->can("post.viewPendingPost");
    }

}
