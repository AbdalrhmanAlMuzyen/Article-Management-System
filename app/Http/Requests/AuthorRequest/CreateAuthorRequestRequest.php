<?php

namespace App\Http\Requests\AuthorRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateAuthorRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "sample_text"=>"required|string|min:30"
        ];
    }
}
