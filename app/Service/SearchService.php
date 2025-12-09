<?php
namespace App\Service;

use App\DTO\Search\SearchDTO;
use App\Repository\SearchRepository;
use App\ReturnTrait;

class SearchService{
    use ReturnTrait;
    protected $searchRepository;

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository=$searchRepository;
    }

    public function search(SearchDTO $dto)
    {
        try {
            $search = $this->searchRepository->search($dto);

            if ($search->isEmpty()) {
                return $this->error(false, "No results found", null, 404);
            }

            return $this->success(true, "Search results retrieved successfully", $search, 200);

        } catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage(), null, 500);
        }
    }

    

}