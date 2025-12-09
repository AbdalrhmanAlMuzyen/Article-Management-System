<?php 

namespace App\Service;

use App\DTO\UserManagement\CreateUserDTO;
use App\DTO\UserManagement\DeleteUserDTO;
use App\DTO\UserManagement\GetUsersDTO;
use App\Repository\RolesAndPermissionsRepository;
use App\Repository\UserManagementRepository;
use App\Repository\UserRoleManagerRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\DB;

class UserManagementService{
    use ReturnTrait;
    protected $userManagementRepository;
    protected $userRoleManagerRepository;
    protected $rolesAndPermissionsRepository;

    public function __construct(UserManagementRepository $userMangementRepository,UserRoleManagerRepository $userRoleManagerRepository,RolesAndPermissionsRepository $rolesAndPermissionsRepository)
    {
        $this->userManagementRepository=$userMangementRepository;
        $this->userRoleManagerRepository=$userRoleManagerRepository;
        $this->rolesAndPermissionsRepository=$rolesAndPermissionsRepository;
    }

    public function createUser(CreateUserDTO $dto)
    {
        try{
            $role=$this->rolesAndPermissionsRepository->findRoleByName($dto->role);
            $permissions=$this->rolesAndPermissionsRepository->getPermissions($role);
            DB::beginTransaction();
                $user=$this->userManagementRepository->createUser($dto);

                $this->userRoleManagerRepository->assignRoles($user,$dto->role);
                $this->userRoleManagerRepository->givePermissions($user,$permissions);
            DB::commit();   

            return $this->success(true,"user created successfully",$user->load("roles","permissions"),201);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function getUsers(GetUsersDTO $dto)
    {
        try{
            $users=$this->userManagementRepository->getUsers($dto);

            if ($users->isEmpty()) {
                return $this->error(false, "No users found", null, 404);
            }

            return $this->success(true,"Users retrieved successfully",$users,200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function deleteUser(DeleteUserDTO $dto)
    {
        try {
            $user = $this->userManagementRepository->findUserById($dto);

            if (!$user) {
                return $this->error(false, "User not found", null, 404);
            }

            $this->userManagementRepository->deleteUser($user);

            return $this->success(true, "User deleted successfully", null, 200);

        } catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage(), null, 500);
        }
    }

    

}