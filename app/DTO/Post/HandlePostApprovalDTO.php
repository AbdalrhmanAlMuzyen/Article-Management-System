<?php

namespace App\DTO\Post;

class HandlePostApprovalDTO{
    public int $post_id;
    public string $status;

    public function __construct(int $post_id,string $status)
    {
        $this->post_id=$post_id;
        $this->status=$status;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("post_id"),$request->input("status"));
    }
}