<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Interaction;

class DashboardController extends Controller
{
    // Show dashboard
    public function index()
{
    $user = auth()->user();
    
    // Load ALL posts with proper counts and user liked status
    $posts = Post::with('user')
        ->withCount([
            'interactions as likes_count' => function ($q) {
                $q->where('type', 'like');
            },
            'interactions as comments_count' => function ($q) {
                $q->where('type', 'comment');
            },
        ])
        ->latest()
        ->get(); // Changed from paginate(10) to get() - this loads ALL posts

    // Add user's like status for each post
    foreach ($posts as $post) {
        $post->user_has_liked = $post->interactions()
            ->where('user_id', auth()->id())
            ->where('type', 'like')
            ->exists();
    }

    // Suggestions for right sidebar
    $suggestions = User::where('id', '!=', $user->id)
        ->latest()->take(6)->get();

    return view('dashboard.index', compact('user', 'posts', 'suggestions'));
}

    // Handle post likes - FIXED VERSION
    public function like(Post $post)
    {
        $userId = auth()->id();

        // Find existing like
        $existing = $post->interactions()
            ->where('user_id', $userId)
            ->where('type', 'like')
            ->first();

        if ($existing) {
            // Unlike
            $existing->delete();
            $liked = false;
        } else {
            // Create like
            $post->interactions()->create([
                'user_id' => $userId,
                'type' => 'like',
            ]);
            $liked = true;
        }

        // Get latest count
        $likesCount = $post->interactions()->where('type', 'like')->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount,
        ]);
    }

    // Handle post comments - FIXED VERSION
    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment = $post->interactions()->create([
            'user_id' => auth()->id(),
            'type' => 'comment',
            'content' => $request->input('content'),
        ]);

        // Load user to return author info
        $comment->load('user');

        $commentsCount = $post->interactions()->where('type', 'comment')->count();

        return response()->json([
            'comment' => [
                'id' => $comment->id,
                'user' => [
                    'id' => $comment->user->id,
                    'first_name' => $comment->user->first_name ?? $comment->user->name ?? '',
                    'last_name' => $comment->user->last_name ?? '',
                    'profile_picture' => $comment->user->profile_picture ?? null,
                ],
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ],
            'commentsCount' => $commentsCount,
        ]);
    }

    // UPDATED: Search users function with default male image integration
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen(trim($query)) < 2) {
            return response()->json(['users' => []]);
        }

        $users = User::where('id', '!=', auth()->id()) // Exclude current user
            ->where(function($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                  ->orWhere('last_name', 'LIKE', "%{$query}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"]);
            })
            ->select('id', 'first_name', 'last_name', 'profile_picture')
            ->limit(8)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'profile_picture' => $user->profile_picture,
                    'profile_picture_url' => $user->profile_picture_url, // Uses the model's accessor
                    'full_name' => $user->first_name . ' ' . $user->last_name,
                ];
            });

        return response()->json(['users' => $users]);
    }

    // Search users
    public function search(Request $request)
    {
        $query = $request->input('q');

        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();

        return view('dashboard.index', [
            'users' => $users,
            'query' => $query
        ]);
    }
}