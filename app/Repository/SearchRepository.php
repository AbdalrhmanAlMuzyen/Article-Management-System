<?php
namespace App\Repository;

use App\DTO\Search\SearchDTO;
use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SearchRepository{

    public function search(SearchDTO $dto)
    {
        switch($dto->type)
        {
            case "user" :
                $excludedRoles=Role::whereNotIn("name",["writer","reader"])->pluck("id");

                return User::whereDoesntHave("roles",function($query) use ($excludedRoles){
                    $query->whereIn("role_id",$excludedRoles);
                })
                ->whereRaw("CONCAT(first_name,' ',last_name) LIKE ? ",["%{$dto->search}%"])->withCount("posts AS count")->orderBy("count","DESC")->orderBy("first_name","ASC")->orderBy("last_name","ASC")->get();
            break;

            case "title" :
                return Post::where("title","LIKE","%{$dto->search}%")->inRandomOrder()->get();
            break; 
            
            default :
                return Post::where("content","LIKE","%{$dto->search}%")->inRandomOrder()->get();
            break;
        }
    }
}