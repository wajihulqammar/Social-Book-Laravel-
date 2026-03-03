<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = ['post_id', 'user_id', 'type', 'content'];

    // relation to post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
