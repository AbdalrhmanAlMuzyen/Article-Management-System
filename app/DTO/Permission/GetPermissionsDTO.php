<?php

namespace App\DTO\Permission;

class GetPermissionsDTO{
    public string $name;

    public function __construct(string $name)
    {
        $this->name=$name;
    }

    public  static function FormRequest($request)
    {
        return new self($request->input("name"));
    }
}