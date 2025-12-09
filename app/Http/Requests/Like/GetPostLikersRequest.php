<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;

class GetPostLikersRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "post_id"=>"required|integer|exists:posts,id"
        ];
    }
}
