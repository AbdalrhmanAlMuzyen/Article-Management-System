<?php 
namespace App\DTO\Cateogry;

class UpdateCategoryDTO{

    public int $category_id;
    public string $name;

    public function __construct(int $category_id,string $name)
    {
        $this->category_id=$category_id;
        $this->name=$name;
    }

    public static function FormRequest($request)
    {
        return new self($request->input("category_id"),$request->input("name"));
    }
}