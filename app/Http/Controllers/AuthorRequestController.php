<?php

namespace App\Http\Controllers;

use App\DTO\AuthorRequest\CreateAuthorRequestDTO;
use App\DTO\AuthorRequest\HandleAuthorRequestDTO;
use App\Http\Requests\AuthorRequest\CreateAuthorRequestRequest;
use App\Http\Requests\AuthorRequest\HandleAuthorRequestRequest;
use App\Http\Resources\ApiResponse;
use App\Models\AuthorRequest;
use App\Service\AuthorRequestService;
use Illuminate\Http\Request;

class AuthorRequestController extends Controller
{
    protected $authorRequestService;
    
    public function __construct(AuthorRequestService $authorRequestService)
    {
        $this->authorRequestService=$authorRequestService;
    }

    public function createAuthorRequest(CreateAuthorRequestRequest $request)
    {
        $this->authorize("createAuthorRequest",AuthorRequest::class);
        $result=$this->authorRequestService->createAuthorRequest(CreateAuthorRequestDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);          
    }

    public function getMyAuthorRequests()
    {
        $this->authorize("viewMyAuthorRequests",AuthorRequest::class);
        $result=$this->authorRequestService->getMyAuthorRequests();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }

    public function getAuthorRequests()
    {
        $this->authorize("viewAuthorRequests",AuthorRequest::class);
        $result=$this->authorRequestService->getAuthorRequests();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);                    
    }

    public function handleAuthorRequest(HandleAuthorRequestRequest $request)
    {
        $this->authorize("authorRequest.update",AuthorRequest::class);
        $result=$this->authorRequestService->handleAuthorRequest(HandleAuthorRequestDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);                    
    }
}