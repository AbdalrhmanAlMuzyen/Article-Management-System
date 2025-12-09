<?php 

namespace App\Service;

use App\DTO\Authentication\LoginDTO;
use App\DTO\Authentication\RegisterDTO;
use App\Repository\AuthenticationRepository;
use App\Repository\RolesAndPermissionsRepository;
use App\Repository\UserRoleManagerRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationService{

    use ReturnTrait;
    protected $authenticationRepository;
    protected $userRoleManagerRepository;
    protected $rolesAndPermissionsRepository;
    public function __construct(AuthenticationRepository $authenticationRepository,UserRoleManagerRepository $userRoleManagerRepository,RolesAndPermissionsRepository $rolesAndPermissionsRepository)
    {
        $this->authenticationRepository=$authenticationRepository;
        $this->userRoleManagerRepository=$userRoleManagerRepository;
        $this->rolesAndPermissionsRepository=$rolesAndPermissionsRepository;
    }

    public function register(RegisterDTO $dto)
    {
        try{
            $role=$this->rolesAndPermissionsRepository->findRoleByName("reader");
            $permisssions=$this->rolesAndPermissionsRepository->getPermissions($role);

            DB::beginTransaction();
                $user=$this->authenticationRepository->register($dto);

                $this->userRoleManagerRepository->assignRoles($user,["reader"]);

                $this->userRoleManagerRepository->givePermissions($user,$permisssions);
            DB::commit();

            $user->token=JWTAuth::fromUser($user);
            return $this->success(true,"account created successfully",$user->load("roles","permissions"),201);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return $this->error(false,"An error has occurred : ".$e->getMessage());
        }
    }

    public function login(LoginDTO $dto)
    {
        try{
            $user=$this->authenticationRepository->findUserByEmail($dto);

            if($user && Hash::check($dto->password,$user->password))
            {
                $user->token=JWTAuth::fromUser($user);
                return $this->success(true,"login successfully",$user->load("roles","permissions"));
            }
            else{
                return $this->error(false,"wrong email or password",401);
            }
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function logout()
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->success(true,"logout successfully",null,200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }



    

}