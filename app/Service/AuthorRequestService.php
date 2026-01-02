<?php 

namespace App\Service;

use App\DTO\AuthorRequest\CreateAuthorRequestDTO;
use App\DTO\AuthorRequest\HandleAuthorRequestDTO;
use App\Repository\AuthorRequestRepository;
use App\Repository\NotificationRepository;
use App\Repository\RolesAndPermissionsRepository;
use App\Repository\RolesRepository;
use App\Repository\UserManagementRepository;
use App\Repository\UserRoleManagerRepository;
use App\ReturnTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorRequestService{

    use ReturnTrait;
    protected $authorRequestRepository;
    protected $userRoleManagerRepository;
    protected $userManagementRepository;
    protected $notificationRepository;
    protected $notificationService;
    protected $rolesRepository;

    public function __construct(AuthorRequestRepository $authorRequestRepository, UserRoleManagerRepository $userRoleManagerRepository,UserManagementRepository $userManagementRepository,NotificationRepository $notificationRepository,NotificationService $notificationService,RolesRepository $rolesRepository)
    {
        $this->authorRequestRepository=$authorRequestRepository;
        $this->userRoleManagerRepository=$userRoleManagerRepository;
        $this->userManagementRepository=$userManagementRepository;
        $this->notificationRepository=$notificationRepository;
        $this->notificationService=$notificationService;
        $this->rolesRepository=$rolesRepository;
    }

    public function createAuthorRequest(CreateAuthorRequestDTO $dto)
    {
        try {
            $user=Auth::guard("user")->user();

            if($this->authorRequestRepository->hasRecentPendingAuthorRequests($user))
            {
                return $this->error(false,"You already have a pending author request in the last 25 days",null,400);            
            }

            $authorRequest = $this->authorRequestRepository->createAuthorRequest($dto,$user);

            return $this->success(true,"Author request submitted successfully",$authorRequest,201);

        } catch (\Exception $e) {
            return $this->error(false,"An error has occurred : " . $e->getMessage());
        }
    }

    public function getMyAuthorRequests()
    {
        try {
            $user = Auth::guard("user")->user();

            $requests = $this->authorRequestRepository->getMyAuthorRequests($user);

            if ($requests->isEmpty()) {
                return $this->error(false, "No author requests found.", null, 404);
            }

            return $this->success(true, "Author requests retrieved successfully.", $requests, 200);
        } 
        catch (\Exception $e) {
            return $this->error(false, "An error has occurred: " . $e->getMessage());
        }
    }

    public function getAuthorRequests()
    {
        try {
            $requests = $this->authorRequestRepository->getAuthorRequests();

            if ($requests->isEmpty()) {
                return $this->error(false,"No author requests found",null,404);
            }

            return $this->success(true,"Author requests fetched successfully",$requests,200);

        } catch (\Exception $e) {
            return $this->error(false,"An error has occurred: " . $e->getMessage());
        }
    }

    public function handleAuthorRequest(HandleAuthorRequestDTO $dto)
    {
        try {
            $authorRequest = $this->authorRequestRepository->findAuthorRequestByID($dto);
            $user= $this->userManagementRepository->findUserById($authorRequest->user_id);
            if (!$authorRequest) {
                return $this->error(false, "Author request not found.", null, 404);
            }
            $notificationMessage=$this->notificationService->getNotificationMessage("authorRequest",$dto->status);
            
            DB::beginTransaction();
                $this->authorRequestRepository->handleAuthorRequest($authorRequest, $dto);
                if($dto->status==='approved')
                {
                    $this->userRoleManagerRepository->assignRoles($user,["writer"]);
                }
                $this->notificationRepository->createNotification($user->id,$notificationMessage["title"],$notificationMessage["body"]);
            DB::commit();
            return $this->success(true,"Author request has been " . $dto->status . " successfully.",$authorRequest,200);
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return $this->error(false,"An error has occurred: " . $e->getMessage());
        }
    }






}