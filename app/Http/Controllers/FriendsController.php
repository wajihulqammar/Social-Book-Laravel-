<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friendship;
use App\Models\Post;

class FriendsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all friends (accepted friendships) - Fixed query
        $friendIds = collect();
        
        // Get friends where current user is sender
        $sentFriends = Friendship::where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id');
        
        // Get friends where current user is receiver
        $receivedFriends = Friendship::where('receiver_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('sender_id');
        
        // Combine both collections
        $friendIds = $sentFriends->merge($receivedFriends);
        
        // Get the actual User objects with counts
        $friends = User::whereIn('id', $friendIds)
            ->withCount([
                'posts',
                'sentFriendships' => function($query) {
                    $query->where('status', 'accepted');
                },
                'receivedFriendships' => function($query) {
                    $query->where('status', 'accepted');
                }
            ])
            ->paginate(20);

        // Get friend requests (pending requests received by current user)
        $friendRequests = Friendship::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        // Get suggestions (users not already friends or with pending requests)
        $existingConnectionIds = Friendship::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })->pluck('sender_id')
          ->merge(
              Friendship::where(function($query) use ($user) {
                  $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
              })->pluck('receiver_id')
          )->unique()
          ->push($user->id); // Exclude self

        $suggestions = User::whereNotIn('id', $existingConnectionIds)
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('friends.index', compact('friends', 'friendRequests', 'suggestions'));
    }

    public function requests()
    {
        $user = auth()->user();
        
        // Get pending friend requests received
        $receivedRequests = Friendship::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender')
            ->latest()
            ->paginate(10);

        // Get pending friend requests sent
        $sentRequests = Friendship::where('sender_id', $user->id)
            ->where('status', 'pending')
            ->with('receiver')
            ->latest()
            ->paginate(10);

        return view('friends.requests', compact('receivedRequests', 'sentRequests'));
    }

    public function suggestions()
    {
        $user = auth()->user();
        
        // Get all users that current user has any relationship with
        $existingConnectionIds = Friendship::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
        })->pluck('sender_id')
          ->merge(
              Friendship::where(function($query) use ($user) {
                  $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
              })->pluck('receiver_id')
          )->unique()
          ->push($user->id); // Exclude self

        $suggestions = User::whereNotIn('id', $existingConnectionIds)
            ->withCount([
                'posts',
                'sentFriendships' => function($query) {
                    $query->where('status', 'accepted');
                },
                'receivedFriendships' => function($query) {
                    $query->where('status', 'accepted');
                }
            ])
            ->inRandomOrder()
            ->paginate(20);

        return view('friends.suggestions', compact('suggestions'));
    }
}