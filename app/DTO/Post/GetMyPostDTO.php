<?php
namespace App\DTO\Post;

class GetMyPostDTO{
    public string $status;

    public function __construct(string $status)
    {
        $this->status=$status;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("status"));
    }
}