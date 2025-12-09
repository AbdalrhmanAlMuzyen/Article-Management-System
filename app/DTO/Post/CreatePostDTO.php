<?php 

namespace App\DTO\Post;
use Illuminate\Http\UploadedFile;

class CreatePostDTO{
    public int $category_id;
    public string $title;   
    public string $content;
    public string $cover;

    public function __construct(int $category_id,string $title,string $content,string $cover)
    {
        $this->category_id=$category_id;
        $this->title=$title;
        $this->content=$content;
        $this->cover=$cover;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("category_id"),$request->input("title"),$request->input("content"),$request->file("cover"));
    }
}