<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'profile_picture',
        'bio',
        'location',
        'website',
        'phone',
        'birth_date',
        'dob',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'dob' => 'date',
    ];

    // Get profile picture with default male placeholder
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('uploads/profile_pictures/' . $this->profile_picture);
        }
        
        // Return default male placeholder for all users
        return asset('images/default-male.png');
    }

    // Helper method to check if user has custom profile picture
    public function hasCustomProfilePicture()
    {
        return !empty($this->profile_picture);
    }

    // Get user initials for avatar fallback
    public function getInitialsAttribute()
    {
        $firstInitial = $this->first_name ? strtoupper($this->first_name[0]) : '';
        $lastInitial = $this->last_name ? strtoupper($this->last_name[0]) : '';
        return $firstInitial . $lastInitial;
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Posts relationship
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Marketplace listings relationship
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    // Active listings
    public function activeListings()
    {
        return $this->listings()->where('status', 'active');
    }

    // Count of sold listings
    public function soldListingsCount()
    {
        return $this->listings()->where('status', 'sold')->count();
    }

    // Groups relationships
    public function adminGroups()
    {
        return $this->hasMany(Group::class, 'admin_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    public function groupJoinRequests()
    {
        return $this->hasMany(GroupJoinRequest::class);
    }

    public function groupPosts()
    {
        return $this->hasMany(GroupPost::class);
    }

    // Group helper methods
    public function isGroupMember($groupId)
    {
        return $this->groups()->where('group_id', $groupId)->exists();
    }

    public function isGroupAdmin($groupId)
    {
        return $this->adminGroups()->where('id', $groupId)->exists();
    }

    public function getGroupRole($groupId)
    {
        $membership = $this->groups()->where('group_id', $groupId)->first();
        return $membership ? $membership->pivot->role : null;
    }

    // Friend relationships
    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted')
            ->union(
                $this->belongsToMany(User::class, 'friendships', 'receiver_id', 'sender_id')
                    ->wherePivot('status', 'accepted')
            );
    }

    // Check if user is friends with another user
    public function isFriendsWith($userId)
    {
        return $this->sentFriendships()->where('receiver_id', $userId)->where('status', 'accepted')->exists() ||
               $this->receivedFriendships()->where('sender_id', $userId)->where('status', 'accepted')->exists();
    }

    // Check if user has pending request with another user
    public function hasPendingRequestWith($userId)
    {
        return $this->sentFriendships()->where('receiver_id', $userId)->where('status', 'pending')->exists() ||
               $this->receivedFriendships()->where('sender_id', $userId)->where('status', 'pending')->exists();
    }

    // Get pending received friend requests
    public function pendingReceivedRequests()
    {
        return $this->receivedFriendships()->where('status', 'pending')->with('sender');
    }

    // Get pending sent friend requests
    public function pendingSentRequests()
    {
        return $this->sentFriendships()->where('status', 'pending')->with('receiver');
    }

    // Message relationships
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Get conversation partners
    public function getConversationPartners()
    {
        $sentTo = $this->sentMessages()->pluck('receiver_id');
        $receivedFrom = $this->receivedMessages()->pluck('sender_id');
        
        $partnerIds = $sentTo->merge($receivedFrom)->unique();
        
        return User::whereIn('id', $partnerIds)->get();
    }

    // Get unread message count from specific user
    public function getUnreadCountFrom($userId)
    {
        return $this->receivedMessages()
            ->where('sender_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    // Get total unread message count
    public function getTotalUnreadCount()
    {
        return $this->receivedMessages()->whereNull('read_at')->count();
    }

}