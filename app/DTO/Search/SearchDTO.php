<?php

namespace App\DTO\Search;

class SearchDTO{
    public string $search;
    public string $type;

    public function __construct(string $search,string $type)
    {
        $this->search=$search;
        $this->type=$type;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("search"),$request->input("type"));
    }
}