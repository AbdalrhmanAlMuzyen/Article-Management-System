<?php 

namespace App\Repository;

use App\DTO\Authentication\LoginDTO;
use App\DTO\Authentication\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationRepository{

    public function register(RegisterDTO $dto)
    {
        return User::create([
            "first_name"=>$dto->first_name,
            "last_name"=>$dto->last_name,
            "email"=>$dto->email,
            "password"=>Hash::make($dto->password)
        ]);
    }

    public function findUserByEmail(LoginDTO $dto)
    {
        return User::where("email",$dto->email)->first();
    }


}