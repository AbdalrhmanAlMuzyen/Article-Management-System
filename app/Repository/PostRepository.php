<?php 

namespace App\Repository;

use App\DTO\Post\CreatePostDTO;
use App\DTO\Post\HandlePostApprovalDTO;
use App\Models\Post;

class PostRepository{

    public function createPost(CreatePostDTO $dto,$user)
    {
        $image=request()->file("cover");
        $image_url=$image->store("CoverPictures","public");

        return $user->posts()->create([
            "category_id"=>$dto->category_id,
            "title"=>$dto->title,
            "content"=>$dto->content,
            "cover"=>$image_url
        ]);
    }

    public function findPostByID($post_id)
    {
        return Post::find($post_id);
    }

    public function getMyPosts($user,$dto)
    {
        return $user->posts()->where("status",$dto->status)->orderBy("created_at","DESC")->get();
    }

    public function updatePost($post,$data)
    {
        return $post->update($data);
    }

    public function deletePost($post)
    {
        return $post->delete();
    }

    public function publishRequest($post)
    {
        return $post->update([
            "status"=>"pending"
        ]);
    }

    public function getPendingPost()
    {
        return Post::where("status","pending")->orderByRaw("created_at DESC,(SELECT COUNT(*) FROM posts AS p WHERE posts.user_id=p.user_id) DESC , (SELECT COUNT(*) FROM likes WHERE likes.user_id = posts.user_id) DESC")->get();
    }

    public function handlePostApproval($post,HandlePostApprovalDTO $dto)
    {
        return $post->update([
            "status"=>$dto->status
        ]);
    }

}