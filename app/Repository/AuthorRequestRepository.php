<?php 

namespace App\Repository;

use App\DTO\AuthorRequest\CreateAuthorRequestDTO;
use App\DTO\AuthorRequest\HandleAuthorRequestDTO;
use App\Models\AuthorRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AuthorRequestRepository{

    public function hasRecentPendingAuthorRequests($user)
    {
        return $user->authorRequests()->where("status", "pending")->where("created_at", ">=", Carbon::now()->subDays(25))->exists();
    }

    public function createAuthorRequest(CreateAuthorRequestDTO $dto,$user)
    {
        return $user->authorRequests()->create([
            "user_id"=>Auth::guard("user")->user()->id,
            "sample_text"=>$dto->sample_text
        ]);
    }

    public function getMyAuthorRequests($user)
    {
        return $user->authorRequests()->orderBy("created_at","DESC")->get();
    }

    public function getAuthorRequests()
    {
        return AuthorRequest::where("status","pending")->where("created_at",">=",Carbon::now()->subDays(25))->orderByRaw("created_at ASC , (SELECT COUNT(*) FROM likes WHERE author_requests.user_id = likes.user_id) DESC")->get();
    }

    public function findAuthorRequestByID(HandleAuthorRequestDTO $dto)
    {
        return AuthorRequest::find($dto->author_request_id);
    }

    public function handleAuthorRequest($authorRequest,HandleAuthorRequestDTO $dto)
    {
        return $authorRequest->update([
            "status"=>$dto->status,
            "note"=>$dto->note
        ]);
    }


}