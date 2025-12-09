<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AuthorRequestController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\FollowerStatisticsController;
use App\Http\Controllers\HomeFeedController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostStatisticsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post("/register",[AuthenticationController::class,"register"]);
Route::post("/login",[AuthenticationController::class,"login"])->middleware('throttle:login');
Route::post("/logout",[AuthenticationController::class,"logout"]);


Route::get("/get/roles",[RolesAndPermissionsController::class,"getRoles"]);
Route::get("/get/permissions",[RolesAndPermissionsController::class,"getPermissions"]);


Route::post("/create/user",[UserManagementController::class,"createUser"]);
Route::get("/get/users",[UserManagementController::class,"getUsers"]);
Route::post("/delete/user",[UserManagementController::class,"deleteUser"]);


Route::post("/create/category",[CategoryController::class,"createCategory"]);
Route::post("/update/category",[CategoryController::class,"updateCategory"]);
Route::post("/delete/category",[CategoryController::class,"deleteCategory"]);
Route::get("/get/category",[CategoryController::class,"getCategory"]);

Route::post("/create/author/request",[AuthorRequestController::class,"createAuthorRequest"]);
Route::get("/get/my/author/requests",[AuthorRequestController::class,"getMyAuthorRequests"]);
Route::get("/get/author/requests",[AuthorRequestController::class,"getAuthorRequests"]);
Route::post("/handle/author/request",[AuthorRequestController::class,"handleAuthorRequest"]);

Route::post("/create/post",[PostController::class,"createPost"]);
Route::get("/get/my/posts",[PostController::class,"getMyPosts"]);
Route::post("/publish/request",[PostController::class,"publishRequest"]);
Route::post("/update/post",[PostController::class,"updatePost"]);
Route::post("/delete/post",[PostController::class,"deletePost"]);
Route::get("/get/pending/post",[PostController::class,"getPendingPost"]);
Route::post("/handle/post/approval",[PostController::class,"handlePostApproval"]);

Route::get("/search",[SearchController::class,"search"]);

Route::post("/toggle/follow",[FollowerController::class,"toggleFollow"]);

Route::post("/get/user/profile/data",[UserProfileController::class,"getUserProfileData"]);
Route::get("/get/my/profile",[UserProfileController::class,"getMyProfile"]);
Route::post("/update/profile",[UserProfileController::class,"updateProfile"]);


Route::post("/home/feed",[HomeFeedController::class,"homeFeed"]);

Route::get("/get/followers/growth",[FollowerStatisticsController::class,"getFollowersGrowth"]);
Route::get("/get/top/posts/by/followers/gain",[FollowerStatisticsController::class,"getTopPostsByFollowersGain"]);
Route::get("/get/followers/by/account/age",[FollowerStatisticsController::class,"getFollowersByAccountAge"]);
Route::get("/get/monthly/followers/comparison",[FollowerStatisticsController::class,"getMonthlyFollowersComparison"]);


Route::get("/get/top/five/posts/by/likes",[PostStatisticsController::class,"getTopFivePostsByLikes"]);
Route::get("/calculate/post/engagement/rate",[PostStatisticsController::class,"calculatePostEngagementRate"]);
Route::get("/get/best/posting/times",[PostStatisticsController::class,"getBestPostingTimes"]);
Route::get("/get/average/likes/per/post",[PostStatisticsController::class,"getAverageLikesPerPost"]);
Route::get("/get/most/viral/post",[PostStatisticsController::class,"getMostViralPost"]);
Route::get("/get/followers/retention/rate",[PostStatisticsController::class,"getFollowersRetentionRate"]);

Route::post("/toggle/like",[LikeController::class,"toggleLike"]);
Route::post("/get/post/likers",[LikeController::class,"getPostLikers"]);


Route::prefix('dashboard')->group(function () {
    Route::get('/total/users', [DashboardController::class, 'getTotalUsers']);
    Route::get('/new/users/last/30/days', [DashboardController::class, 'getNewUsersLast30Days']);
    Route::get('/top/users/by/followers', [DashboardController::class, 'getTopUsersByFollowers']);
    Route::get('/total/posts', [DashboardController::class, 'getTotalPosts']);
    Route::get('/top/categories/by/posts', [DashboardController::class, 'getTopCategoriesByPosts']);
    Route::get('/top/posts/by/likes', [DashboardController::class, 'getTopPostsByLikes']);
    Route::get('/top/users/by/posts', [DashboardController::class, 'getTopUsersByPosts']);
    Route::get('/posts/count/by/period', [DashboardController::class, 'getPostsCountByPeriod']);
    Route::get('/top/hours/by/likes', [DashboardController::class, 'getTopHoursByLikes']);
    Route::get('/top/days/by/likes', [DashboardController::class, 'getTopDaysByLikes']);
    Route::get('/monthly/user/growth/rate', [DashboardController::class, 'getMonthlyUserGrowthRate']);
    Route::get('/weekly/user/growth/rate', [DashboardController::class, 'getWeeklyUserGrowthRate']);
});

Route::get("/get/my/notifications",[NotificationController::class,"getMynotifications"]);
Route::post("/show/notification",[NotificationController::class,"showNotification"]);