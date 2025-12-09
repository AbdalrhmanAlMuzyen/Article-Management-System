<?php

namespace App\Http\Requests\Follower;

use Illuminate\Foundation\Http\FormRequest;

class ToggleFollowRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "user_id"=>"required|integer|exists:users,id"
        ];
    }
}
