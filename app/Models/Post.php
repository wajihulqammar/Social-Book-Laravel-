<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'body',
    'image_path',
    'feeling_activity', // add this
];

public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    // likes (Interaction rows where type = 'like')
    public function likes()
    {
        return $this->interactions()->where('type', 'like');
    }

    // comments (Interaction rows where type = 'comment')
    public function comments()
    {
        return $this->interactions()->where('type', 'comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   public function getImageUrlAttribute()
{
    if (!$this->image_path) {
        return null;
    }
    
    // Since you're storing directly in public/uploads/posts/
    return asset($this->image_path);
}
}
