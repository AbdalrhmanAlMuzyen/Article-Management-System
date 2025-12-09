<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "post_id"=>"required|integer|exists:posts,id",
            "title"=>"nullable|string",
            "content"=>"nullable|string",
            "body"=>"nullable|string"
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->someTimes("body","required|string",function(){
            $user=Auth::guard("user")->user();
            return $user->hasAnyRole(["admin","editor"]);
        });
    }
    
}
