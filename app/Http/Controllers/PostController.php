<?php

namespace App\Http\Controllers;

use App\DTO\Post\CreatePostDTO;
use App\DTO\Post\DeletePostDTO;
use App\DTO\Post\GetMyPostDTO;
use App\DTO\Post\HandlePostApprovalDTO;
use App\DTO\Post\PublishRequestDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\DeletePostRequest;
use App\Http\Requests\Post\GetMyPostsRequest;
use App\Http\Requests\Post\HandlePostApprovalRequest;
use App\Http\Requests\Post\PublishRequestRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Post;
use App\Service\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService=$postService;
    }

    public function createPost(CreatePostRequest $request)
    {
        $this->authorize("createPost",Post::class);
        $result=$this->postService->createPost(CreatePostDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getMyPosts(GetMyPostsRequest $request)
    {
        $this->authorize("viewMyPosts",Post::class);
        $result=$this->postService->getMyPosts(GetMyPostDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function publishRequest(PublishRequestRequest $request)
    {
        $this->authorize("post.publishRequest",Post::find($request->input("post_id")));
        $result=$this->postService->publishRequest(PublishRequestDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]); 
    }

    public function updatePost(UpdatePostRequest $request)
    {
        $this->authorize("updatePost",Post::find($request->input("post_id")));
        $result=$this->postService->updatePost(UpdatePostDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function deletePost(DeletePostRequest $request)
    {
        $this->authorize("deletePost",Post::find($request->input("post_id")));
        $result=$this->postService->deletePost(DeletePostDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getPendingPost()
    {
        $this->authorize("post.viewPendingPost",Post::class);
        $result=$this->postService->getPendingPost();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function handlePostApproval(HandlePostApprovalRequest $request)
    {
        $this->authorize("post.handlePostApproval",Post::class);
        $result=$this->postService->handlePostApproval(HandlePostApprovalDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }
}
