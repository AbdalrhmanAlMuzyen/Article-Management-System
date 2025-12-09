<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user=User::create([
            "first_name"=>"abdalrhman",
            "last_name"=>"almuzyen",
            "email"=>"abdalrhman@gmail.com",
            "password"=>Hash::make("123456")
        ]);

        $user->assignRole("admin");
        $admin=Role::findByName("admin");
        $permissions=$admin->getPermissionNames();
        $user->givePermissionTo($permissions);
    }
}
