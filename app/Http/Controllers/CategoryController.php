<?php

namespace App\Http\Controllers;

use App\DTO\Cateogry\CreateCategoryDTO;
use App\DTO\Cateogry\DeleteCategoryDTO;
use App\DTO\Cateogry\UpdateCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\DeleteCategoryRequest;
use App\Http\Requests\Category\updateCategoryRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Category;

use App\Service\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService=$categoryService;
    }

    public function createCategory(CreateCategoryRequest $request)
    {
        $this->authorize('createCategory',Category::class);
        $result=$this->categoryService->createCategory(CreateCategoryDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);         
    }

    public function updateCategory(updateCategoryRequest $request)
    {
        $this->authorize('updateCategory',Category::class);
        $result=$this->categoryService->updateCategory(UpdateCategoryDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);           
    }

    public function deleteCategory(DeleteCategoryRequest $request)
    {
        $this->authorize('deleteCategory',Category::class);
        $result=$this->categoryService->deleteCategory(DeleteCategoryDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }

    public function getCategory()
    {
        $result=$this->categoryService->getCategory();
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);        
    }
}
