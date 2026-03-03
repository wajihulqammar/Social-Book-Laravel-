<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'feeling_activity' => 'nullable|string|max:100',
        ]);

        if (!$request->filled('body') && !$request->hasFile('image')) {
            return back()->withErrors(['body' => 'Write something or add an image.'])->withInput();
        }

       $path = null;
    if ($request->hasFile('image')) {
        // Store directly in public/uploads/posts
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/posts'), $filename);
        $path = 'uploads/posts/' . $filename;
    }

    Post::create([
        'user_id' => auth()->id(),
        'body' => $request->body,
        'image_path' => $path,
        'feeling_activity' => $request->feeling_activity,
    ]);

    return back()->with('success', 'Post published successfully!');
}


    public function destroy(Post $post)
    {
        // Check if user owns this post
        abort_if($post->user_id !== auth()->id(), 403, 'Unauthorized action.');

        // Delete image file if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Delete the post (this will cascade delete interactions due to foreign key)
        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }

    public function index()
    {
        $posts = Post::with(['user', 'interactions.user'])
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

        return view('posts.index', compact('posts'));
    }
}