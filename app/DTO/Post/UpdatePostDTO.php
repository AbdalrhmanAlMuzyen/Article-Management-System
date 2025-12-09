<?php 
namespace App\DTO\Post;

class UpdatePostDTO{
    public int $post_id;
    public ?string $title;
    public ?string $content;
    public ?string $body;
    public function __construct(int $post_id,?string $title=null,?string $content=null,?string $body=null)
    {
        $this->post_id=$post_id;
        $this->title=$title;
        $this->content=$content;
        $this->body=$body;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("post_id"),$request->input("title"),$request->input("content"),$request->input("body"));
    }
}