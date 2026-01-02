<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\RolesService;

class RolesController extends Controller
{
    protected $rolesService;

    public function __construct(RolesService $rolesService)
    {
        $this->rolesService=$rolesService;
    }    
    
    public function getRoles()
    {
        $this->authorize("viewRoles",User::class);
        $result=$this->rolesService->getRoles();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }
}