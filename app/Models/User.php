<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    protected $table="users";

    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password"
    ];

    protected $hidden = [
        "password"
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function authorRequests()
    {
        return $this->hasMany(AuthorRequest::class);
    }

    //المتابعين
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    // يلي بتابعون
    public function followings()
    {
        return $this->hasMany(Follower::class,"follower_id");
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}