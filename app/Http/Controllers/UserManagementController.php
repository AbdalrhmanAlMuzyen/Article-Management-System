<?php

namespace App\Http\Controllers;

use App\DTO\UserManagement\CreateUserDTO;
use App\DTO\UserManagement\DeleteUserDTO;
use App\DTO\UserManagement\GetUsersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\CreateUserRequest;
use App\Http\Requests\UserManagement\DeleteUserRequest;
use App\Http\Requests\UserManagement\GetUsersRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\UserManagementService;

class UserManagementController extends Controller
{
    protected $userManagementService;

    public function __construct(UserManagementService $userManagementService)
    {
        $this->userManagementService=$userManagementService;
    }

    public function createUser(CreateUserRequest $request)
    {
        $this->authorize("createUser",User::class);
        $result=$this->userManagementService->createUser(CreateUserDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }

    public function getUsers(GetUsersRequest $request)
    {
        $this->authorize("getUsers",User::class);
        $result=$this->userManagementService->getUsers(GetUsersDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);          
    }

    public function deleteUser(DeleteUserRequest $request)
    {
        $this->authorize("deleteUser",User::class);
        $result=$this->userManagementService->deleteUser(DeleteUserDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]); 
    }

}
