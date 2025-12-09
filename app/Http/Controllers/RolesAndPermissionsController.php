<?php

namespace App\Http\Controllers;

use App\DTO\Permission\GetPermissionsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\GetPermissionsRequest;
use App\Http\Resources\ApiResponse;
use App\Models\User;
use App\Service\RolesAndPermissionsService;

class RolesAndPermissionsController extends Controller
{
    
    protected $rolesAndPermissionsService;

    public function __construct(RolesAndPermissionsService $rolesAndPermissionsService)
    {
        $this->rolesAndPermissionsService=$rolesAndPermissionsService;
    }    
    
    public function getRoles()
    {
        $this->authorize("viewRoles",User::class);
        $result=$this->rolesAndPermissionsService->getRoles();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function getPermissions(GetPermissionsRequest $request)
    {
        $this->authorize("viewPermissions",User::class);
        $result=$this->rolesAndPermissionsService->getPermissions(GetPermissionsDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);
    }
}
