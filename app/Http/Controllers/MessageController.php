<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Friendship;

class MessageController extends Controller
{
    /**
     * Display the messages page
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get all conversation partners (friends who have messaged or been messaged)
        $conversations = collect();
        
        // Get all friends
        $friendIds = collect();
        $sentFriends = Friendship::where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id');
        $receivedFriends = Friendship::where('receiver_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('sender_id');
        $friendIds = $sentFriends->merge($receivedFriends);

        // For each friend, get the latest message and unread count
        foreach ($friendIds as $friendId) {
            $friend = User::find($friendId);
            if ($friend) {
                $latestMessage = Message::getLatestMessage($user->id, $friendId);
                $unreadCount = $user->getUnreadCountFrom($friendId);
                
                $conversations->push((object)[
                    'friend' => $friend,
                    'latest_message' => $latestMessage,
                    'unread_count' => $unreadCount,
                    'updated_at' => $latestMessage ? $latestMessage->created_at : $friend->created_at
                ]);
            }
        }

        // Sort conversations by latest activity
        $conversations = $conversations->sortByDesc('updated_at');

        return view('messages.index', compact('conversations'));
    }

    /**
     * Display conversation with specific user
     */
    public function show($userId)
    {
        $user = auth()->user();
        $friend = User::findOrFail($userId);
        
        // Check if they are friends
        $friendship = Friendship::where(function($q) use ($user, $userId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($user, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $user->id);
        })->where('status', 'accepted')->first();

        if (!$friendship) {
            return redirect()->route('messages.index')->with('error', 'You can only message friends.');
        }

        // Get conversation messages
        $messages = Message::getConversation($user->id, $userId);
        
        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Get conversation list for sidebar
        $conversations = $this->getConversationList($user);

        return view('messages.show', compact('friend', 'messages', 'conversations'));
    }

    /**
     * Send a message
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $user = auth()->user();
        $receiverId = $request->receiver_id;

        // Check if they are friends
        $friendship = Friendship::where(function($q) use ($user, $receiverId) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiverId);
        })->orWhere(function($q) use ($user, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $user->id);
        })->where('status', 'accepted')->first();

        if (!$friendship) {
            return response()->json(['error' => 'You can only message friends.'], 403);
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $request->message
        ]);

        $message->load('sender', 'receiver');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('messages.partials.message', compact('message'))->render()
            ]);
        }

        return redirect()->route('messages.show', $receiverId);
    }

    /**
     * Get conversation list for AJAX
     */
    public function conversations()
    {
        $user = auth()->user();
        $conversations = $this->getConversationList($user);

        return response()->json($conversations);
    }

    /**
     * Get messages for a conversation (AJAX)
     */
    public function getMessages($userId)
    {
        $user = auth()->user();
        $messages = Message::getConversation($user->id, $userId);
        
        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages,
            'html' => view('messages.partials.messages', compact('messages'))->render()
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead($userId)
    {
        $user = auth()->user();
        
        Message::where('sender_id', $userId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Get conversation list helper
     */
    private function getConversationList($user)
    {
        $conversations = collect();
        
        // Get all friends
        $friendIds = collect();
        $sentFriends = Friendship::where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id');
        $receivedFriends = Friendship::where('receiver_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('sender_id');
        $friendIds = $sentFriends->merge($receivedFriends);

        // For each friend, get the latest message and unread count
        foreach ($friendIds as $friendId) {
            $friend = User::find($friendId);
            if ($friend) {
                $latestMessage = Message::getLatestMessage($user->id, $friendId);
                $unreadCount = $user->getUnreadCountFrom($friendId);
                
                $conversations->push([
                    'friend' => $friend,
                    'latest_message' => $latestMessage,
                    'unread_count' => $unreadCount,
                    'updated_at' => $latestMessage ? $latestMessage->created_at : $friend->created_at
                ]);
            }
        }

        return $conversations->sortByDesc('updated_at')->values();
    }
}