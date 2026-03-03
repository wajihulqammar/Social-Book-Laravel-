<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of the message
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if message is read
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Get conversation between two users
     */
    public static function getConversation($user1, $user2)
    {
        return self::where(function($query) use ($user1, $user2) {
            $query->where('sender_id', $user1)
                  ->where('receiver_id', $user2);
        })->orWhere(function($query) use ($user1, $user2) {
            $query->where('sender_id', $user2)
                  ->where('receiver_id', $user1);
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();
    }

    /**
     * Get latest message between two users
     */
    public static function getLatestMessage($user1, $user2)
    {
        return self::where(function($query) use ($user1, $user2) {
            $query->where('sender_id', $user1)
                  ->where('receiver_id', $user2);
        })->orWhere(function($query) use ($user1, $user2) {
            $query->where('sender_id', $user2)
                  ->where('receiver_id', $user1);
        })->latest()->first();
    }
}