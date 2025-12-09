<?php

namespace App\DTO\Post;

class DeletePostDTO{
    public int $post_id;
    public ?string $body;

    public function __construct(int $post_id,string $body)
    {
        $this->post_id=$post_id;
        $this->body=$body;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("post_id"),$request->input("body"));
    }
}