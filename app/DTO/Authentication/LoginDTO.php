<?php 

namespace App\DTO\Authentication;

class LoginDTO{
    public string $email;
    public string $password;

    public function __construct(string $email,string $password)
    {
        $this->email=$email;
        $this->password=$password;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("email"),$request->input("password"));
    }
}