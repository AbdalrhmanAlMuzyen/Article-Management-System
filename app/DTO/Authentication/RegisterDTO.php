<?php 

namespace App\DTO\Authentication;

class RegisterDTO
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;

    public function __construct($first_name,$last_name,$email,$password)
    {
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->email=$email;
        $this->password=$password;
    }

    public static function FormRequest($request)
    {
        return new self(
            $request->input("first_name"),
            $request->input("last_name"),
            $request->input("email"),
            $request->input("password")
        );
    }
}