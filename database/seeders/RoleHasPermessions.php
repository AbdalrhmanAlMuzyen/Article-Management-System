<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermessions extends Seeder
{
    public function run(): void
    {
        $reader=Role::where("name","reader")->first();
        $writer=Role::where("name","writer")->first();
        $editor=Role::where("name","editor")->first();
        $admin=Role::where("name","admin")->first();

        $reader->givePermissionTo([
            'user.viewFollowerStatistics',
            'like.toggleLike',
            'homeFeed',
            'notification.viewMyNotifications',
            'notification.showNotification'

        ]);

        $writer->givePermissionTo([
            'post.create',
            'post.update',
            'post.delete',
            'post.viewMyPosts',
            'post.publishRequest',

            'user.viewFollowerStatistics',
            'user.viewPostStatistics',

            'like.toggleLike',

            'homeFeed',
            
            'notification.viewMyNotifications',
            'notification.showNotification'
        ]);
        
        $editor->givePermissionTo([
            'post.update',
            'post.delete',
            'post.publish',
            'post.viewPendingPost',
            'post.handlePostApproval',

            'authorRequest.view',
            'authorRequest.update'
        ]);
        
        $admin->givePermissionTo([
            'user.create',
            'user.update',
            'user.delete',
            'user.viewUsers',
            
            'post.update',
            'post.delete',
            'post.publish',
            'post.viewPendingPost',
            'post.handlePostApproval',
            
            'authorRequest.view',
            'authorRequest.update',
            
            'category.create',
            'category.update',
            'category.delete',
            
            'viewDashboard',
            
            'viewRoles',
            'viewPermissions'
        ]);
    }
}