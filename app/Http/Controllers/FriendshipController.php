<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;


class FriendshipController extends Controller
{

    
    // Send request
// Send request
public function sendRequest($receiverId)
{
    $senderId = auth()->id();

    if ($senderId == $receiverId) {
        return response()->json(['success' => false, 'message' => 'Cannot send request to yourself.']);
    }

    $friendship = \App\Models\Friendship::firstOrCreate([
        'sender_id' => $senderId,
        'receiver_id' => $receiverId,
    ]);

    return response()->json([
        'success' => true,
        'status' => 'pending',
        'friendship_id' => $friendship->id,
        'message' => 'Friend request sent!'
    ]);
}

// Accept request
public function acceptRequest($id)
{
    $friendship = \App\Models\Friendship::findOrFail($id);
    $friendship->status = 'accepted';
    $friendship->save();

    return response()->json([
        'success' => true,
        'status' => 'accepted',
        'friendship_id' => $friendship->id,
        'message' => 'Friend request accepted!'
    ]);
}

// Decline request
public function declineRequest($id)
{
    $friendship = \App\Models\Friendship::findOrFail($id);
    $friendship->status = 'declined';
    $friendship->save();

    return response()->json([
        'success' => true,
        'status' => 'declined',
        'friendship_id' => $friendship->id,
        'message' => 'Friend request declined!'
    ]);
}

    public function remove($friendId)
    {
        $userId = Auth::id();

        $friendship = Friendship::where(function($q) use($userId, $friendId){
            $q->where('sender_id', $userId)->where('receiver_id', $friendId);
        })->orWhere(function($q) use($userId, $friendId){
            $q->where('sender_id', $friendId)->where('receiver_id', $userId);
        })->first();

        if ($friendship) {
            $friendship->delete();
            return back()->with('success', 'Friend removed successfully.');
        }

        return back()->with('error', 'Friendship not found.');
    }
}
