<?php 
namespace App\DTO\UserManagement;

class CreateUserDTO{

    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public string $role;

    public function __construct(string $first_name,string $last_name,string $email,string $password,string $role)
    {
        $this->first_name=$first_name;
        $this->last_name=$last_name;
        $this->email=$email;
        $this->password=$password;
        $this->role=$role;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("first_name"),$request->input("last_name"),$request->input("email"),$request->input("password"),$request->input("role"));
    }
    
}