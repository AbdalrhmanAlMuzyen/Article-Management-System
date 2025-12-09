<?php 

namespace App\Service;

use App\DTO\Permission\GetPermissionsDTO;
use App\Repository\RolesAndPermissionsRepository;
use App\ReturnTrait;

class RolesAndPermissionsService{
    use ReturnTrait;
    protected $rolesAndPermissionsRepository;

    public function __construct(RolesAndPermissionsRepository $rolesAndPermissionsRepository)
    {
        $this->rolesAndPermissionsRepository=$rolesAndPermissionsRepository;
    }

    public function getRoles()
    {
        try {
            $roles = $this->rolesAndPermissionsRepository->getRoles();

            if ($roles->isEmpty()) {
                return $this->error(false, "No roles found",[],404);
            }

            return $this->success(true, "Roles fetched successfully", $roles);
        } catch (\Exception $e) {
            return $this->error(false, "Failed to fetch roles: " . $e->getMessage());
        }
    }

    public function getPermissions(GetPermissionsDTO $dto)
    {
        try {
            $role=$this->rolesAndPermissionsRepository->findRoleByName($dto->name);
            $permissions = $this->rolesAndPermissionsRepository->getPermissions($role);

            if ($permissions->isEmpty()) {
                return $this->error(false, "No permissions found",[],404);
            }

            return $this->success(true, "Permissions fetched successfully", $permissions);
        } catch (\Exception $e) {
            return $this->error(false, "Failed to fetch permissions: " . $e->getMessage());
        }
    }    

    

}