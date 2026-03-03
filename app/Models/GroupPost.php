<?php
// GroupPost.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\GroupJoinRequest;
use App\Models\GroupPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id', 
        'content',
        'image',
        'likes_count',
        'comments_count'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// GroupJoinRequest.php  
