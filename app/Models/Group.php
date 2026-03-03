<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'privacy',
        'category',
        'location',
        'admin_id',
        'member_count',
        'is_active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_active' => 'boolean',
        'member_count' => 'integer'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(GroupPost::class);
    }

    public function joinRequests()
    {
        return $this->hasMany(GroupJoinRequest::class);
    }

    // Helper methods
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public function isAdmin($userId)
    {
        return $this->admin_id == $userId;
    }

    public function isModerator($userId)
    {
        return $this->members()->where('user_id', $userId)
                    ->wherePivot('role', 'moderator')->exists();
    }

    public function canPost($userId)
    {
        return $this->isMember($userId) || $this->isAdmin($userId);
    }

    public function hasPendingRequest($userId)
    {
        return $this->joinRequests()->where('user_id', $userId)
                    ->where('status', 'pending')->exists();
    }

    public function getPrivacyLabelAttribute()
    {
        return match($this->privacy) {
            'public' => 'Public',
            'closed' => 'Closed',
            'secret' => 'Secret',
            default => 'Public'
        };
    }

    // FIXED: Updated to work with public directory
    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image && file_exists(public_path('uploads/group_covers/' . $this->cover_image))) {
            return asset('uploads/group_covers/' . $this->cover_image);
        }
        return null;
    }

    // Check if cover image exists
    public function hasCoverImage()
    {
        return $this->cover_image && file_exists(public_path('uploads/group_covers/' . $this->cover_image));
    }

    // Get cover image or default
    public function getCoverImageOrDefaultAttribute()
    {
        if ($this->hasCoverImage()) {
            return $this->cover_image_url;
        }
        return asset('images/default-group-cover.jpg'); // You can create a default image
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}