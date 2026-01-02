<?php 

namespace App\Service;

use App\Repository\RolesRepository;
use App\ReturnTrait;

class RolesService{
    use ReturnTrait;
    protected $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository=$rolesRepository;
    }

    public function getRoles()
    {
        try {
            $roles = $this->rolesRepository->getRoles();

            if ($roles->isEmpty()) {
                return $this->error(false, "No roles found",[],404);
            }

            return $this->success(true, "Roles fetched successfully", $roles);
        } catch (\Exception $e) {
            return $this->error(false, "Failed to fetch roles: " . $e->getMessage());
        }
    }    
}