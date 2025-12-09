<?php

namespace App\Http\Requests\AuthorRequest;

use Illuminate\Foundation\Http\FormRequest;

class HandleAuthorRequestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "author_request_id"=>"required|integer|exists:author_requests,id",
            "status"=>"required|in:approved,rejected",
            "note"=>"nullable|string"
        ];
    }
}
