<?php

namespace App\Http\Controllers;

use App\DTO\Search\SearchDTO;
use App\Http\Requests\Search\SearchRequest;
use App\Http\Resources\ApiResponse;
use App\Service\SearchService;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService=$searchService;
    }

    public function search(SearchRequest $request)
    {
        $result=$this->searchService->search(SearchDTO::FormRequest($request));
        return new ApiResponse($result["data"],$result["success"],$result["message"],$result["code"]);             
    }
}
