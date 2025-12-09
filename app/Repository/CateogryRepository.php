<?php 
namespace App\Repository;

use App\DTO\Cateogry\CreateCategoryDTO;
use App\DTO\Cateogry\UpdateCategoryDTO;
use App\Models\Category;

class CateogryRepository{
    
    public function findCategoryByID($category_id)
    {
        return Category::find($category_id);
    }

    public function createCategory(CreateCategoryDTO $dto)
    {
        return Category::create([
            "name"=>$dto->name
        ]);
    }

    public function updateCategory($category,UpdateCategoryDTO $dto)
    {
        return $category->update([
            "name"=>$dto->name
        ]);
    }

    public function deleteCategory($category)
    {
        return $category->delete();
    }

    public function getCategory()
    {
        return Category::withCount("posts AS c")
            ->withSum("posts AS s", "likes_count")
            ->orderBy("c", "DESC")
             ->orderBy("s", "DESC")
            ->get();         
    }

}