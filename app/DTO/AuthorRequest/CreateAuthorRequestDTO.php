<?php 

namespace App\DTO\AuthorRequest;

class CreateAuthorRequestDTO{
    public string $sample_text;

    public function __construct(string $sample_text)
    {
        $this->sample_text=$sample_text;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("sample_text"));
    }
}