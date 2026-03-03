<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\GroupPost;
use App\Models\GroupJoinRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get user's joined groups
        $myGroups = $user->belongsToMany(Group::class, 'group_members', 'user_id', 'group_id')
                        ->withPivot('role', 'joined_at')
                        ->latest('group_members.created_at')
                        ->take(6)
                        ->get();
        
        // Get suggested groups (public groups user hasn't joined)
        $suggestedGroups = Group::active()
                                ->public()
                                ->whereNotIn('id', $myGroups->pluck('id'))
                                ->where('admin_id', '!=', $user->id)
                                ->latest()
                                ->take(6)
                                ->get();
        
        // Get popular groups
        $popularGroups = Group::active()
                             ->public()
                             ->orderBy('member_count', 'desc')
                             ->take(5)
                             ->get();
        
        // Categories with counts
        $categories = [
            'Gaming' => Group::active()->byCategory('gaming')->count(),
            'Fitness & Health' => Group::active()->byCategory('fitness')->count(),
            'Education' => Group::active()->byCategory('education')->count(),
            'Music & Arts' => Group::active()->byCategory('music')->count(),
            'Professional' => Group::active()->byCategory('professional')->count(),
            'Technology' => Group::active()->byCategory('technology')->count(),
        ];

        return view('groups.index', compact('myGroups', 'suggestedGroups', 'popularGroups', 'categories'));
    }

    public function discover(Request $request)
    {
        $query = Group::active()->public()->with('admin');
        
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $groups = $query->orderBy('member_count', 'desc')->paginate(12);
        
        $categories = ['gaming', 'fitness', 'education', 'music', 'professional', 'technology'];
        
        return view('groups.discover', compact('groups', 'categories'));
    }

    public function create()
    {
        $categories = [
            'gaming' => 'Gaming',
            'fitness' => 'Fitness & Health', 
            'education' => 'Education',
            'music' => 'Music & Arts',
            'professional' => 'Professional',
            'technology' => 'Technology',
            'lifestyle' => 'Lifestyle',
            'other' => 'Other'
        ];
        
        return view('groups.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:groups',
            'description' => 'required|string|max:1000',
            'privacy' => 'required|in:public,closed,secret',
            'category' => 'required|string',
            'location' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $group = new Group($request->only([
            'name', 'description', 'privacy', 'category', 'location'
        ]));
        
        $group->admin_id = auth()->id();
        
        // FIXED: Store image directly in public/uploads directory
        if ($request->hasFile('cover_image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->cover_image->extension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/group_covers');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file to public directory
            $request->cover_image->move($uploadPath, $imageName);
            $group->cover_image = $imageName;
        }
        
        $group->save();
        
        // Add admin as first member
        $group->members()->attach(auth()->id(), [
            'role' => 'admin',
            'joined_at' => now()
        ]);

        return redirect()->route('groups.show', $group)->with('success', 'Group created successfully!');
    }

    public function show(Group $group)
    {
        $group->load(['admin', 'members' => function($query) {
            $query->latest('group_members.created_at');
        }]);
        
        $isMember = $group->isMember(auth()->id());
        $isAdmin = $group->isAdmin(auth()->id());
        $hasPendingRequest = $group->hasPendingRequest(auth()->id());
        
        // Get group posts if user is member
        $posts = [];
        if ($isMember || $isAdmin || $group->privacy === 'public') {
            $posts = $group->posts()->with('user')->latest()->paginate(10);
        }
        
        $recentMembers = $group->members()->latest('group_members.created_at')->take(6)->get();
        
        return view('groups.show', compact('group', 'isMember', 'isAdmin', 'hasPendingRequest', 'posts', 'recentMembers'));
    }

    public function join(Group $group)
    {
        $user = auth()->user();
        
        if ($group->isMember($user->id) || $group->isAdmin($user->id)) {
            return response()->json(['success' => false, 'message' => 'Already a member']);
        }
        
        if ($group->privacy === 'public') {
            // Join immediately for public groups
            $group->members()->attach($user->id, [
                'role' => 'member',
                'joined_at' => now()
            ]);
            
            $group->increment('member_count');
            
            return response()->json(['success' => true, 'message' => 'Successfully joined the group!']);
        } else {
            // Create join request for closed/secret groups
            $group->joinRequests()->create([
                'user_id' => $user->id,
                'status' => 'pending',
                'requested_at' => now()
            ]);
            
            return response()->json(['success' => true, 'message' => 'Join request sent!']);
        }
    }

    public function leave(Group $group)
    {
        $user = auth()->user();
        
        if (!$group->isMember($user->id)) {
            return response()->json(['success' => false, 'message' => 'Not a member']);
        }
        
        if ($group->isAdmin($user->id)) {
            return response()->json(['success' => false, 'message' => 'Admin cannot leave group']);
        }
        
        $group->members()->detach($user->id);
        $group->decrement('member_count');
        
        return response()->json(['success' => true, 'message' => 'Left the group successfully']);
    }

    public function edit(Group $group)
    {
        if (!$group->isAdmin(auth()->id())) {
            abort(403, 'Unauthorized');
        }
        
        $categories = [
            'gaming' => 'Gaming',
            'fitness' => 'Fitness & Health',
            'education' => 'Education', 
            'music' => 'Music & Arts',
            'professional' => 'Professional',
            'technology' => 'Technology',
            'lifestyle' => 'Lifestyle',
            'other' => 'Other'
        ];
        
        return view('groups.edit', compact('group', 'categories'));
    }

    public function update(Request $request, Group $group)
    {
        if (!$group->isAdmin(auth()->id())) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'name' => 'required|string|max:255|unique:groups,name,' . $group->id,
            'description' => 'required|string|max:1000',
            'privacy' => 'required|in:public,closed,secret',
            'category' => 'required|string',
            'location' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $group->fill($request->only([
            'name', 'description', 'privacy', 'category', 'location'
        ]));
        
        // FIXED: Handle image update with public directory
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($group->cover_image) {
                $oldImagePath = public_path('uploads/group_covers/' . $group->cover_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $imageName = time() . '_' . uniqid() . '.' . $request->cover_image->extension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/group_covers');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move new file
            $request->cover_image->move($uploadPath, $imageName);
            $group->cover_image = $imageName;
        }
        
        $group->save();
        
        return redirect()->route('groups.show', $group)->with('success', 'Group updated successfully!');
    }

    public function destroy(Group $group)
{
    if (!$group->isAdmin(auth()->id())) {
        if (request()->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        abort(403, 'Unauthorized');
    }
    
    try {
        // Delete cover image from public directory
        if ($group->cover_image) {
            $imagePath = public_path('uploads/group_covers/' . $group->cover_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Delete all post images
        $posts = $group->posts;
        foreach ($posts as $post) {
            if ($post->image) {
                $postImagePath = public_path('uploads/group_posts/' . $post->image);
                if (file_exists($postImagePath)) {
                    unlink($postImagePath);
                }
            }
        }
        
        $group->delete();
        
        // Always return JSON for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Group deleted successfully!'
            ]);
        }
        
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully!');
        
    } catch (\Exception $e) {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting group: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()->with('error', 'Error deleting group.');
    }
}
    
    public function myGroups()
    {
        $user = auth()->user();
        
        $myGroups = $user->groups()
                        ->withPivot('role', 'joined_at')
                        ->orderBy('group_members.created_at', 'desc')
                        ->paginate(12);
        
        $adminGroups = $user->adminGroups()
                          ->active()
                          ->latest()
                          ->take(6)
                          ->get();
        
        return view('groups.my-groups', compact('myGroups', 'adminGroups'));
    }

    public function members(Group $group)
    {
        if (!$group->isMember(auth()->id()) && !$group->isAdmin(auth()->id()) && $group->privacy !== 'public') {
            abort(403, 'You must be a member to view group members.');
        }
        
        $members = $group->members()
                        ->withPivot('role', 'joined_at')
                        ->orderBy('group_members.created_at', 'desc')
                        ->paginate(20);
        
        return view('groups.members', compact('group', 'members'));
    }

    public function joinRequests(Group $group)
    {
        if (!$group->isAdmin(auth()->id())) {
            abort(403, 'Only group admins can view join requests.');
        }
        
        $requests = $group->joinRequests()
                         ->with('user')
                         ->where('status', 'pending')
                         ->latest()
                         ->paginate(20);
        
        return view('groups.requests', compact('group', 'requests'));
    }

    public function approveRequest(Group $group, GroupJoinRequest $request)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        if ($request->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Request already processed']);
        }
        
        // Add user to group
        $group->members()->attach($request->user_id, [
            'role' => 'member',
            'joined_at' => now()
        ]);
        
        // Update request status
        $request->update(['status' => 'approved']);
        
        // Increment member count
        $group->increment('member_count');
        
        return response()->json(['success' => true, 'message' => 'Request approved successfully']);
    }

    public function rejectRequest(Group $group, GroupJoinRequest $request)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        $request->update(['status' => 'rejected']);
        
        return response()->json(['success' => true, 'message' => 'Request rejected']);
    }

    public function removeMember(Group $group, User $user)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        if ($group->isAdmin($user->id)) {
            return response()->json(['success' => false, 'message' => 'Cannot remove group admin']);
        }
        
        $group->members()->detach($user->id);
        $group->decrement('member_count');
        
        return response()->json(['success' => true, 'message' => 'Member removed successfully']);
    }

    public function makeAdmin(Group $group, User $user)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        if (!$group->isMember($user->id)) {
            return response()->json(['success' => false, 'message' => 'User is not a member']);
        }
        
        $group->members()->updateExistingPivot($user->id, ['role' => 'admin']);
        
        return response()->json(['success' => true, 'message' => 'User promoted to admin']);
    }

    public function makeModerator(Group $group, User $user)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        if (!$group->isMember($user->id)) {
            return response()->json(['success' => false, 'message' => 'User is not a member']);
        }
        
        $group->members()->updateExistingPivot($user->id, ['role' => 'moderator']);
        
        return response()->json(['success' => true, 'message' => 'User promoted to moderator']);
    }

    public function storePost(Request $request, Group $group)
    {
        if (!$group->canPost(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'You cannot post in this group']);
        }
        
        $request->validate([
            'content' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $post = new GroupPost([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
        
        // FIXED: Store post images in public directory too
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/group_posts');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move file to public directory
            $request->image->move($uploadPath, $imageName);
            $post->image = $imageName;
        }
        
        $post->save();
        
        return response()->json(['success' => true, 'message' => 'Post created successfully']);
    }

    public function destroyPost(GroupPost $post)
    {
        $group = $post->group;
        
        if ($post->user_id !== auth()->id() && !$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        // FIXED: Delete from public directory
        if ($post->image) {
            $imagePath = public_path('uploads/group_posts/' . $post->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $post->delete();
        
        return response()->json(['success' => true, 'message' => 'Post deleted successfully']);
    }

    public function demoteMember(Group $group, User $user, Request $request)
    {
        if (!$group->isAdmin(auth()->id())) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }
        
        if (!$group->isMember($user->id)) {
            return response()->json(['success' => false, 'message' => 'User is not a member']);
        }
        
        $role = $request->input('role', 'member');
        $group->members()->updateExistingPivot($user->id, ['role' => $role]);
        
        return response()->json(['success' => true, 'message' => 'Member role updated successfully']);
    }
}