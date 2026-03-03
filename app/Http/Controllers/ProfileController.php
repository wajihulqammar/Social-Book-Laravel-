<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Friendship;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /**
     * Show user profile
     */
    public function show(User $user)
    {
        // User posts with proper counts
        $posts = Post::where('user_id', $user->id)
            ->with('user')
            ->withCount([
                'interactions as likes_count' => function ($q) {
                    $q->where('type', 'like');
                },
                'interactions as comments_count' => function ($q) {
                    $q->where('type', 'comment');
                },
            ])
            ->latest()
            ->paginate(10);

        // User suggestions (exclude current user)
        $suggestions = User::where('id', '!=', auth()->id() ?? 0)
            ->latest()->take(6)->get();

        // Fetch friends
        $friends = Friendship::where(function($q) use ($user) {
            $q->where('sender_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->get()->map(function($friendship) use ($user) {
            return $friendship->sender_id === $user->id 
                ? User::find($friendship->receiver_id) 
                : User::find($friendship->sender_id);
        });

        return view('profile.show', compact('user', 'posts', 'suggestions', 'friends'));
    }

    /**
     * Show edit profile form (only owner)
     */
    public function edit(User $user)
    {
        abort_if(auth()->id() !== $user->id, 403);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile (bio + profile picture)
     * UPDATED: Better handling of default image replacement
     */
   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    
    // Ensure user can only update their own profile
    abort_if(auth()->id() !== $user->id, 403);

    // Validation
    $validated = $request->validate([
        'bio' => 'nullable|string|max:500',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update bio
    if (isset($validated['bio'])) {
        $user->bio = $validated['bio'];
    }

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old picture if exists (but don't delete default images)
        if ($user->profile_picture && 
            !str_contains($user->profile_picture, 'default') && 
            file_exists(public_path('uploads/profile_pictures/' . $user->profile_picture))) {
            unlink(public_path('uploads/profile_pictures/' . $user->profile_picture));
        }

        $filename = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('uploads/profile_pictures'), $filename);
        $user->profile_picture = $filename;
    }

    $user->save();

    // Redirect to profile page instead of back to edit page
    return redirect()->route('profile.show', $user->id)
                    ->with('success', 'Profile updated successfully!');
}

    public function like(Post $post)
    {
        $userId = auth()->id();

        // find existing like
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

        // latest count
        $likesCount = $post->interactions()->where('type', 'like')->count();

        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount,
        ]);
    }

    // Add comment (AJAX)
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

        // load user to return author info
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

    public function updateField(Request $request, $id)
    {
        $user = User::findOrFail($id);
        abort_if(auth()->id() !== $user->id, 403);

        // parse JSON payload
        $data = $request->json()->all();
        $field = $data['field'] ?? null;
        $value = $data['value'] ?? null;

        if (!in_array($field, ['bio', 'education', 'work'])) {
            return response()->json(['success' => false, 'message' => 'Invalid field']);
        }

        $maxLength = $field === 'bio' ? 500 : 300;
        if (strlen($value) > $maxLength) {
            return response()->json(['success' => false, 'message' => 'Text too long']);
        }

        $user->update([$field => $value]);

        return response()->json(['success' => true]);
    }
}