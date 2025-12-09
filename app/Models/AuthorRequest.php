<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorRequest extends Model
{
    protected $table="author_requests";

    protected $fillable = [
        "user_id",
        "sample_text",
        "status",
        "note"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}