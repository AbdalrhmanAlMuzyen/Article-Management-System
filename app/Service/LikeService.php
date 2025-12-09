<?php
namespace App\Service;

use App\DTO\Like\GetPostLikersDTO;
use App\DTO\Like\ToggleLikeDTO;
use App\Repository\PostRepository;
use App\Repository\LikeRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeService{
    use ReturnTrait;

    protected $likeRepository;
    protected $postRepository;

    public function __construct(LikeRepository $likeRepository,PostRepository $postRepository)
    {
        $this->likeRepository=$likeRepository;
        $this->postRepository=$postRepository;
    }

    public function toggleLike(ToggleLikeDTO $dto)
    {
        try{
            $post=$this->postRepository->findPostByID($dto->post_id);
            if(!$post)
            {
                return $this->error(false,"post not found",null,404);
            }
            $user=Auth::guard("user")->user();
            $isLiked=$this->likeRepository->hasUserLiked($post,$user);
            DB::beginTransaction();
                $this->likeRepository->toggleLike($post,$user);
                $this->likeRepository->updateLikesCount($post,$isLiked);
                if($isLiked)
                {
                    $this->likeRepository->deleteLike($post,$user);
                }
            DB::commit();    
            return $this->success(true,$isLiked ? "Post unliked successfully." : "Post liked successfully.",null,200);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getPostLikers(GetPostLikersDTO $dto)
    {
        try {
            $post = $this->postRepository->findPostByID($dto->post_id);

            if (!$post) {
                return $this->error(false, "Post not found", null, 404);
            }

            $postLikers = $this->likeRepository->getPostLikers($post);

            if ($postLikers->isEmpty()) {
                return $this->success(true, "No likes found for this post", [], 200);
            }

            return $this->success(true, "Post likers retrieved successfully", $postLikers, 200);
        }
        catch (\Exception $e) {
            return $this->error(false, "An error occurred: ".$e->getMessage(), null, 500);
        }
    }
    



    

}