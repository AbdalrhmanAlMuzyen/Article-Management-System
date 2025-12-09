<?php

namespace App\DTO\Like;

class ToggleLikeDTO{
    public int $post_id;

    public function __construct(int $post_id)
    {
        $this->post_id=$post_id;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("post_id"));
    }
}