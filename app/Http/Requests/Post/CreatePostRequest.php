<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "category_id"=>"required|integer|exists:categories,id",
            "title"=>"required|string",
            "content"=>"required|string",
            "cover"=>"required|image|mimes:png,jpg"
        ];
    }

}