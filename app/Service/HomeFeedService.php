<?php

namespace App\Service;

use App\DTO\HomeFeed\HomeFeedDTO;
use App\Repository\CateogryRepository;
use App\Repository\HomeFeedRepository;
use App\ReturnTrait;

class HomeFeedService{
    use ReturnTrait;
    protected $homeFeedRepository;
    protected $categoryRepository;
    public function __construct(HomeFeedRepository $homeFeedRepository,CateogryRepository $cateogryRepository)
    {
        $this->homeFeedRepository=$homeFeedRepository;
        $this->categoryRepository=$cateogryRepository;
    }

    public function homeFeed(HomeFeedDTO $dto)
    {
        try {
            $category=$this->categoryRepository->findCategoryByID($dto->category_id);

            if(!$category)
            {
                return $this->error(false,"category not found",null,404);
            }
            $feed = $this->homeFeedRepository->homeFeed($category->id);

            return $this->success(true,"Home feed retrieved successfully.",$feed,200);
        } 
        catch (\Exception $e) {
            return $this->error(false,"An error has occurred: " . $e->getMessage());
        }
    }



}