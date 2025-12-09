<?php
namespace App\DTO\UserProfileData;

class UpdateProfileDTO{
    public string $first_name;
    public string $last_name;

    public function __construct(string $first_name,string $last_name)
    {
        $this->first_name=$first_name;
        $this->last_name=$last_name;
    }

    public function FormRequest($request)
    {
        return new self($request->input("first_name"),$request->input("last_name"));
    }
}