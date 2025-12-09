<?php 
namespace App\DTO\AuthorRequest;

class HandleAuthorRequestDTO{
    public int $author_request_id;
    public string $status;
    public ?string $note;

    public function __construct(int $author_request_id,string $status,?string $note=null)
    {
        $this->author_request_id=$author_request_id;
        $this->status=$status;
        $this->note=$note;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("author_request_id"),$request->input("status"),$request->input("note"));
    }
}