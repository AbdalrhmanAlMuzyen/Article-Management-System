<?php 

namespace App\Service;

use App\DTO\Post\CreatePostDTO;
use App\DTO\Post\DeletePostDTO;
use App\DTO\Post\GetMyPostDTO;
use App\DTO\Post\HandlePostApprovalDTO;
use App\DTO\Post\PublishRequestDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostService
{
    use ReturnTrait;

    protected  $postRepository;
    protected $notificationRepository;
    protected $notificationService;

    public function __construct(PostRepository $postRepository,NotificationRepository $notificationRepository,NotificationService $notificationService)
    {
        $this->postRepository=$postRepository;
        $this->notificationRepository=$notificationRepository;
        $this->notificationService=$notificationService;
    }

    public function createPost(CreatePostDTO $dto)
    {
        try{
            $post = $this->postRepository->createPost($dto,Auth::guard("user")->user());

            return $this->success(true, "Post created successfully", $post, 201);
        }
        catch(\Exception $e)
        {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getMyPosts(GetMyPostDTO $dto)
    {
        try {
            $user = Auth::guard("user")->user();

            $posts = $this->postRepository->getMyPosts($user,$dto);
            if($posts->isEmpty())
            {
                return $this->error(false, "No posts found .", null, 404);
            }

            return $this->success(true,"posts retrieved successfully.",$posts,200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function updatePost(UpdatePostDTO $dto)
    {
        try {
            $post = $this->postRepository->findPostById($dto->post_id);

            if (!$post) {
                return $this->error(false, "Post not found", null, 404);
            }

            $data=collect(["title"=>$dto->title,"content"=>$dto->content
            ])->filter(function($value){
                return !is_null($value);
            })->toArray();

            if (empty($data)) {
                return $this->error(false, "No data provided to update.", null, 422);
            }

            DB::beginTransaction();
                $this->postRepository->updatePost($post,$data);

                if($dto->body)
                {
                    $this->notificationRepository->createNotification($post->user_id,"your post that title ".$post->title." was updated by moderators",$dto->body);   
                }
            DB::commit();

            return $this->success(true,"Post updated successfully",$post->fresh(),200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function deletePost(DeletePostDTO $dto)
    {
        try{    
            $post=$this->postRepository->findPostByID($dto->post_id);

            if (!$post) {
                return $this->error(false, "Post not found", null, 404);
            }
            DB::beginTransaction();
                $this->postRepository->deletePost($post);
                if($dto->body)
                {
                    $this->notificationRepository->createNotification($post->user_id,"your post that title ".$post->title." was deleted by moderators",$dto->body);   
                }
            DB::commit();
            return $this->success(true,"post deleted successfully",null,200);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }   

    public function publishRequest(PublishRequestDTO $dto)
    {
        try {
            $post = $this->postRepository->findPostByID($dto->post_id);

            if (!$post) {
                return $this->error(false, "Post not found.", null, 404);
            }

            $this->postRepository->publishRequest($post);

            return $this->success(true, "Post submitted for review successfully.", $post->fresh(), 200);

        } catch (\Exception $e) {

            DB::rollBack();
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getPendingPost()
    {
        try {
            $posts = $this->postRepository->getPendingPost();

            if ($posts->isEmpty()) {
                return $this->success(true, "No pending posts found.", [], 200);
            }

            return $this->success(true, "Pending posts retrieved successfully.", $posts, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage(), null, 500);
        }
    }

    public function handlePostApproval(HandlePostApprovalDTO $dto)
    {
        try {
            $post = $this->postRepository->findPostByID($dto->post_id);
            if (!$post) {
                return $this->error(false, "Post not found.", null, 404);
            }

            $message = $this->notificationService->getPostNotificationMessage($dto->status, $post->title);

            DB::beginTransaction();

                $this->postRepository->handlePostApproval($post, $dto);

                $this->notificationRepository->createNotification($post->user_id, $message["title"], $message["body"]);

            DB::commit();

            return $this->success(true, "Post has been " . $dto->status . " successfully.", $post->fresh(), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    














}