<?php
namespace App\DTO\UserManagement;

class GetUsersDTO{
    public string $role;

    public function __construct(string $role)
    {
        $this->role=$role;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("role"));
    }
}