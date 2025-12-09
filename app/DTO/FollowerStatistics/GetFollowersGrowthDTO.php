<?php

namespace App\DTO\FollowerStatistics;

class GetFollowersGrowthDTO{

    public string $groupBy;

    public function __construct(string $groupBy)
    {
        $this->groupBy=$groupBy;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("groupBy"));
    }
}