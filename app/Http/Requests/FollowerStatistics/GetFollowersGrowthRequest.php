<?php

namespace App\Http\Requests\FollowerStatistics;

use Illuminate\Foundation\Http\FormRequest;

class GetFollowersGrowthRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "groupBy"=>"required|in:daily,monthly,annually",
        ];
    }
}
