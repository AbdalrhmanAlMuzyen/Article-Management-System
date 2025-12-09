<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        Permission::firstOrCreate(['name' => 'user.create']);
        Permission::firstOrCreate(['name' => 'user.update']);
        Permission::firstOrCreate(['name' => 'user.delete']);
        Permission::firstOrCreate(['name' => 'user.viewUsers']);
        
        //followers
        Permission::firstOrCreate(['name' => 'user.viewFollowerStatistics']);

        // Posts
        Permission::firstOrCreate(['name' => 'post.create']);
        Permission::firstOrCreate(['name' => 'post.update']);
        Permission::firstOrCreate(['name' => 'post.delete']);
        Permission::firstOrCreate(['name' => 'post.publish']);
        Permission::firstOrCreate(['name' => 'post.viewMyPosts']);
        Permission::firstOrCreate(['name' => 'post.publishRequest']);
        Permission::firstOrCreate(['name' => 'post.viewPendingPost']);
        Permission::firstOrCreate(['name' => 'post.handlePostApproval']);
        Permission::firstOrCreate(['name' => 'user.viewPostStatistics']);

        // Author Requests
        Permission::firstOrCreate(['name' => 'authorRequest.view']);
        Permission::firstOrCreate(['name' => 'authorRequest.update']);

        //Category
        Permission::firstOrCreate(['name' => 'category.create']);
        Permission::firstOrCreate(["name" => 'category.update']);
        Permission::firstOrCreate(["name" => 'category.delete']);

        //dashboard
        Permission::firstOrCreate(["name" => 'viewDashboard']);        

        //likes
        Permission::firstOrCreate(["name" => 'like.toggleLike']);  

        //homeFeed
        Permission::firstOrCreate(["name" => 'homeFeed']);  

        //notification
        Permission::firstOrCreate(["name"=>"notification.viewMyNotifications"]);
        Permission::firstOrCreate(["name"=>"notification.showNotification"]);

        Permission::firstOrCreate(["name"=>"viewRoles"]);
        Permission::firstOrCreate(["name"=>"viewPermissions"]);

    }
}