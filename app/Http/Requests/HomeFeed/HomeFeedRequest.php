<?php

namespace App\Http\Requests\HomeFeed;

use Illuminate\Foundation\Http\FormRequest;

class HomeFeedRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "category_id"=>"required|integer|exists:categories,id"
        ];
    }
}
