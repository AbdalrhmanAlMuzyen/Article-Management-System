<?php

namespace App\Http\Controllers;

use App\DTO\Authentication\LoginDTO;
use App\DTO\Authentication\RegisterDTO;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Post;
use App\Models\User;
use App\Service\AuthenticationService;
use Carbon\Carbon;


class AuthenticationController extends Controller
{
    protected $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService=$authenticationService;
    }

    public function register(RegisterRequest $request)
    {
        $result=$this->authenticationService->register(RegisterDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);
    }
    
    public function login(LoginRequest $request)
    {
        $result=$this->authenticationService->login(LoginDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }

    public function logout()
    {
        $result=$this->authenticationService->logout();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }
    
}
