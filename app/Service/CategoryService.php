<?php 

namespace App\Service;

use App\DTO\Cateogry\CreateCategoryDTO;
use App\DTO\Cateogry\DeleteCategoryDTO;
use App\DTO\Cateogry\UpdateCategoryDTO;
use App\Repository\CateogryRepository;
use App\ReturnTrait;

class CategoryService{
    use ReturnTrait;

    protected $categoryRepository;

    public function __construct(CateogryRepository $cateogryRepository)
    {
        $this->categoryRepository=$cateogryRepository;
    }

    public function createCategory(CreateCategoryDTO $dto)
    {
        try{
            $category=$this->categoryRepository->createCategory($dto);
            
            return $this->success(true,"category created successfully",$category,201);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function updateCategory(UpdateCategoryDTO $dto)
    {
        try{
            $category=$this->categoryRepository->findCategoryByID($dto->category_id);
            
            if(!$category)
            {
                return $this->error(false,"category not found",null,404);          
            }

            $this->categoryRepository->updateCategory($category,$dto);

            return $this->success(true,"category updated successfully",$category->fresh(),200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function deleteCategory(DeleteCategoryDTO $dto)
    {
        try{
            $category=$this->categoryRepository->findCategoryByID($dto->category_id);

            if(!$category)
            {
                return $this->error(false,"category not found",null,404);          
            }

            $this->categoryRepository->deleteCategory($category);

            return $this->success(true,"category deleted successfully",null,200);
        }
        catch(\Exception $e)
        {
            return $this->error(false,"An error has occurred : ".$e->getMessage());          
        }
    }

    public function getCategory()
    {
        try {
            $categories = $this->categoryRepository->getCategory();

            if ($categories->isEmpty()) {
                return $this->error(false,"No categories found",null,404);
            }

            return $this->success(true,"Categories retrieved successfully",$categories,200);

        } 
        catch (\Exception $e) {
            return $this->error(false,"An error has occurred : " . $e->getMessage(),null,500);
        }
    }



}