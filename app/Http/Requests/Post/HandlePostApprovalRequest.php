<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class HandlePostApprovalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "post_id"=>"required|integer|exists:posts,id",
            "status"=>"required|string|in:published,rejected"
        ];
    }
}