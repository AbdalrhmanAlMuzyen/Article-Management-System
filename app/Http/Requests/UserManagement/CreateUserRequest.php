<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "first_name"=>"required|string",
            "last_name"=>"required|string",
            "email"=>"required|string|email|ends_with:@gmail.com|unique:users",
            "password"=>"required|string|min:6",
            "role"=>"required|string|in:editor,admin",
        ];
    }
}