<?php 

namespace App\Repository;

use App\DTO\UserManagement\CreateUserDTO;
use App\DTO\UserManagement\GetUsersDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagementRepository{
    
    public function createUser(CreateUserDTO $dto)
    {
        return User::create([
            "first_name"=>$dto->first_name,
            "last_name"=>$dto->last_name,
            "email"=>$dto->email,
            "password"=>Hash::make($dto->password)
        ]);
    }

    public function findUserById($user_id)
    {
        return User::find($user_id);
    }

    public function getUsers(GetUsersDTO $dto)
    {
        switch($dto->role)
        {
            case "admin" :
                return User::whereNot("id",Auth::guard("user")->user())->whereHas("roles",function($query) use ($dto){
                    $query->where("name",$dto->role);
                })->get();
            break;

            case "editor" :
                return User::whereHas("roles",function($query) use ($dto){
                    $query->where("name",$dto->role);
                })->get();
            break;

            case "writer" :
                return User::whereHas("roles",function($query) use ($dto){
                    $query->where("name",$dto->role);
                })->get();
            break;

            default :
                return User::whereHas("roles",function($query) use ($dto){
                    $query->where("name",$dto->role);
                })->get();        
        }
    }

    public function deleteUser($user)
    {
        return $user->delete();
    }
}