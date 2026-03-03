{{-- resources/views/groups/show.blade.php --}}
@extends('layouts.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<style>
body {
    background: #f0f2f5;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Enhanced Topbar - FIXED: Profile section moved to extreme right */
.topbar {
    background: #fff;
    color: #1c1e21;
    display: flex;
    align-items: center;
    padding: 8px 16px;
    border-bottom: 1px solid #e4e6ea;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.topbar .brand {
    font-weight: 800;
    font-size: 24px;
    margin-right: 20px;
    cursor: pointer;
    background: linear-gradient(45deg, #1877f2, #42a5f5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.topbar .search {
    position: relative;
    max-width: 320px;
    margin-right: auto; /* This pushes everything after it to the right */
}

.topbar .search input {
    width: 100%;
    min-width: 300px;
    border: none;
    border-radius: 50px;
    padding: 10px 16px 10px 40px;
    background: #f0f2f5;
    font-size: 15px;
    outline: none;
    transition: box-shadow 0.2s;
}

.topbar .search input:focus {
    box-shadow: 0 0 0 2px #1877f2;
}

.topbar .search::before {
    content: '\f002';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #65676b;
    font-size: 14px;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-left: auto; /* Ensures it stays on the far right */
}

.topbar-right .profile-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #1c1e21;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    padding: 8px 12px;
    border-radius: 50px;
    transition: background 0.2s;
}

.topbar-right .profile-link:hover {
    background: #f0f2f5;
    text-decoration: none;
}

.topbar-right .profile-link img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #1877f2;
}

.topbar-right button {
    background: #1877f2;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.topbar-right button:hover {
    background: #166fe5;
    transform: translateY(-1px);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
}

.group-cover-section {
    background: #fff;
    margin: 20px 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.group-cover {
    height: 300px;
    background: linear-gradient(45deg, #1877f2, #42a5f5);
    position: relative;
    overflow: hidden;
}

.group-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.group-info {
    padding: 20px;
}

.group-header {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
}

.group-details {
    flex: 1;
}

.group-name {
    font-size: 32px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0 0 8px 0;
}

.group-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.privacy-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
}

.privacy-public { background: #d4edda; color: #155724; }
.privacy-closed { background: #fff3cd; color: #856404; }
.privacy-secret { background: #f8d7da; color: #721c24; }

.group-stats {
    font-size: 15px;
    color: #65676b;
}

.group-description {
    font-size: 16px;
    color: #1c1e21;
    line-height: 1.5;
    margin-bottom: 16px;
}

.group-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-primary {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
}

.btn-secondary {
    background: #f0f2f5;
    color: #1c1e21;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary:hover {
    background: #e4e6ea;
    transform: translateY(-1px);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.2s;
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.main-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.posts-section {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
}

.sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1c1e21;
    margin: 0 0 16px 0;
}

.create-post-form {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    border: 2px solid #e4e6ea;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 15px;
    font-family: inherit;
    resize: vertical;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #1877f2;
}

.post {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 16px;
    overflow: hidden;
}

.post-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-bottom: 1px solid #e4e6ea;
}

.post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.post-author {
    flex: 1;
}

.post-author-name {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 2px;
}

.post-time {
    font-size: 13px;
    color: #65676b;
}

.post-content {
    padding: 16px;
}

.post-text {
    font-size: 15px;
    color: #1c1e21;
    line-height: 1.4;
    margin-bottom: 12px;
}

.post-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 8px;
}

.member-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.member-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px;
    border-radius: 8px;
    transition: background 0.2s;
    cursor: pointer;
}

.member-item:hover {
    background: #f8f9fa;
}

.member-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.member-info {
    flex: 1;
    min-width: 0;
}

.member-name {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.member-role {
    font-size: 12px;
    color: #65676b;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #65676b;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    color: #e4e6ea;
}

.pending-message {
    background: #fff3cd;
    color: #856404;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 500;
}

@media screen and (max-width: 768px) {
    .main-content {
        grid-template-columns: 1fr;
    }
    
    .group-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .group-actions {
        width: 100%;
    }
    
    .group-name {
        font-size: 24px;
    }
}
</style>

<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="topbar-right">
        <a href="{{ route('profile.show', auth()->user()->id) }}" class="profile-link">
            <img src="{{ auth()->user()->profile_picture_url }}" alt="DP">
            <span>{{ auth()->user()->first_name }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <!-- Group Cover Section -->
    <div class="group-cover-section">
        <div class="group-cover">
            @if($group->cover_image)
                <img src="{{ $group->cover_image_url }}" alt="Group Cover">
            @else
                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);">
                    <i class="fas fa-users" style="font-size: 64px; color: white;"></i>
                </div>
            @endif
        </div>
        
        <div class="group-info">
            <div class="group-header">
                <div class="group-details">
                    <h1 class="group-name">{{ $group->name }}</h1>
                    
                    <div class="group-meta">
                        <span class="privacy-badge privacy-{{ $group->privacy }}">
                            <i class="fas fa-{{ $group->privacy === 'public' ? 'globe' : ($group->privacy === 'closed' ? 'lock' : 'eye-slash') }}"></i>
                            {{ $group->privacy_label }} Group
                        </span>
                        
                        <div class="group-stats">
                            <i class="fas fa-users"></i>
                            <strong>{{ number_format($group->member_count) }}</strong> members
                        </div>
                        
                        @if($group->category)
                        <div class="group-stats">
                            <i class="fas fa-tag"></i>
                            {{ ucfirst(str_replace('_', ' ', $group->category)) }}
                        </div>
                        @endif
                        
                        @if($group->location)
                        <div class="group-stats">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $group->location }}
                        </div>
                        @endif
                    </div>
                    
                    @if($group->description)
                    <div class="group-description">
                        {{ $group->description }}
                    </div>
                    @endif
                </div>
            <div class="group-actions">
    @if($isAdmin)
        <a href="{{ route('groups.edit', $group) }}" class="btn-secondary">
            <i class="fas fa-edit"></i> Edit Group
        </a>
        <a href="{{ route('groups.requests', $group) }}" class="btn-secondary">
            <i class="fas fa-user-clock"></i> Join Requests
        </a>
        <a href="{{ route('groups.members', $group) }}" class="btn-secondary">
            <i class="fas fa-users"></i> View Members
        </a>
        <button class="btn-danger" onclick="confirmDeleteGroup()">
            <i class="fas fa-trash"></i> Delete Group
        </button>
    @elseif($isMember)
        <button class="btn-danger" onclick="confirmLeaveGroup()">
            <i class="fas fa-sign-out-alt"></i> Leave Group
        </button>
        <a href="{{ route('groups.members', $group) }}" class="btn-secondary">
            <i class="fas fa-users"></i> View Members
        </a>
    @elseif($hasPendingRequest)
        <button class="btn-secondary" disabled>
            <i class="fas fa-clock"></i> Request Pending
        </button>
        <a href="{{ route('groups.members', $group) }}" class="btn-secondary">
            <i class="fas fa-users"></i> View Members
        </a>
    @else
        <button class="btn-primary" id="join-group-btn">
            <i class="fas fa-plus"></i> Join Group
        </button>
        <a href="{{ route('groups.members', $group) }}" class="btn-secondary">
            <i class="fas fa-users"></i> View Members
        </a>
    @endif
</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Posts Section -->
        <div class="posts-section">
            @if($isMember || $isAdmin || $group->privacy === 'public')
                <!-- Create Post Form -->
                @if($isMember || $isAdmin)
                <div class="create-post-form">
                    <h3 style="margin: 0 0 16px 0; font-size: 18px; color: #1c1e21;">Share with the group</h3>
                    
                    <form id="create-post-form" enctype="multipart/form-data">
                        @csrf
                        <textarea name="content" class="form-control" rows="3" placeholder="What's on your mind?" required></textarea>
                        
                        <div style="margin-top: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <label for="post-image" style="cursor: pointer; color: #1877f2; font-weight: 600;">
                                <i class="fas fa-camera"></i> Add Photo
                            </label>
                            <input type="file" id="post-image" name="image" accept="image/*" style="display: none;">
                            
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-paper-plane"></i> Post
                            </button>
                        </div>
                        
                        <div id="image-preview" style="margin-top: 12px; display: none;">
                            <img id="preview-img" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                            <button type="button" onclick="removeImage()" style="margin-left: 8px; background: none; border: none; color: #dc3545; cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Posts List -->
                <div id="posts-container">
                    @if($posts && $posts->count() > 0)
                        @foreach($posts as $post)
                        <div class="post" id="post-{{ $post->id }}">
                            <div class="post-header">
                                <img src="{{ $post->user->profile_picture_url }}" alt="Profile" class="post-avatar">
                                <div class="post-author">
                                    <div class="post-author-name">{{ $post->user->first_name }} {{ $post->user->last_name }}</div>
                                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                                </div>
                                @if($post->user_id === auth()->id() || $isAdmin)
                                <button onclick="deletePost({{ $post->id }})" style="background: none; border: none; color: #65676b; cursor: pointer; padding: 8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                            
                            <div class="post-content">
                                <div class="post-text">{{ $post->content }}</div>
                                @if($post->image)
                                <img src="{{ asset('uploads/group_posts/' . $post->image) }}" alt="Post Image" class="post-image">
                                @endif
                            </div>
                        </div>
                        @endforeach

                        @if($posts->hasPages())
                        <div style="margin-top: 20px; text-align: center;">
                            {{ $posts->links() }}
                        </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 20px;">No posts yet</h3>
                            <p style="margin: 0; font-size: 15px;">Be the first to share something with the group!</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="pending-message">
                    <i class="fas fa-lock"></i>
                    You must be a member to view group posts.
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Group Info Card -->
            <div class="card">
                <h3 class="section-title">About</h3>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-users" style="color: #1877f2; width: 16px;"></i>
                        <span><strong>{{ number_format($group->member_count) }}</strong> members</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calendar" style="color: #1877f2; width: 16px;"></i>
                        <span>Created {{ $group->created_at->format('F Y') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-user-tie" style="color: #1877f2; width: 16px;"></i>
                        <span>Admin: <strong>{{ $group->admin->first_name }} {{ $group->admin->last_name }}</strong></span>
                    </div>
                    @if($group->location)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-map-marker-alt" style="color: #1877f2; width: 16px;"></i>
                        <span>{{ $group->location }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Recent Members -->
            @if($recentMembers && $recentMembers->count() > 0)
            <div class="card">
                <h3 class="section-title">Recent Members</h3>
                <div class="member-list">
                    @foreach($recentMembers as $member)
                    <div class="member-item" onclick="location.href='{{ route('profile.show', $member->id) }}'">
                        <img src="{{ $member->profile_picture_url }}" alt="Profile" class="member-avatar">
                        <div class="member-info">
                            <div class="member-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                            <div class="member-role">
                                @if($member->pivot->role === 'admin')
                                    <i class="fas fa-crown" style="color: #ffd700;"></i> Admin
                                @elseif($member->pivot->role === 'moderator')
                                    <i class="fas fa-shield-alt" style="color: #28a745;"></i> Moderator
                                @else
                                    <i class="fas fa-user" style="color: #6c757d;"></i> Member
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div style="margin-top: 16px; text-align: center;">
                    <a href="{{ route('groups.members', $group) }}" style="color: #1877f2; text-decoration: none; font-weight: 600;">
                        See All Members
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Join Group functionality
    const joinBtn = document.getElementById('join-group-btn');
    if (joinBtn) {
        joinBtn.addEventListener('click', function() {
            const originalText = this.innerHTML;
            
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Joining...';
            
            fetch(`/groups/{{ $group->id }}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    this.disabled = false;
                    this.innerHTML = originalText;
                    showNotification(data.message || 'Error joining group', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
                this.innerHTML = originalText;
                showNotification('Error joining group. Please try again.', 'error');
            });
        });
    }

    // Create Post functionality
    const createPostForm = document.getElementById('create-post-form');
    if (createPostForm) {
        createPostForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
            
            fetch(`/groups/{{ $group->id }}/posts`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    this.reset();
                    document.getElementById('image-preview').style.display = 'none';
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Error creating post', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error creating post. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }

    // Image preview
    const imageInput = document.getElementById('post-image');
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

function removeImage() {
    document.getElementById('post-image').value = '';
    document.getElementById('image-preview').style.display = 'none';
}

function confirmLeaveGroup() {
    if (confirm('Are you sure you want to leave this group?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/groups/{{ $group->id }}/leave`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    location.href = '{{ route("groups.index") }}';
                }, 1000);
            } else {
                showNotification(data.message || 'Error leaving group', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error leaving group. Please try again.', 'error');
        });
    }
}

function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/group-posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`post-${postId}`).remove();
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Error deleting post', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error deleting post. Please try again.', 'error');
        });
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 20px;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        z-index: 10000;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        transform: translateX(400px);
        transition: transform 0.3s ease;
    `;

    const colors = {
        success: 'linear-gradient(135deg, #10b981 0%, #34d399 100%)',
        error: 'linear-gradient(135deg, #dc2626 0%, #ef4444 100%)',
        info: 'linear-gradient(135deg, #1877f2 0%, #42a5f5 100%)'
    };

    notification.style.background = colors[type] || colors.info;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
function confirmDeleteGroup() {
    const groupName = '{{ $group->name }}';
    
    // Create a more sophisticated confirmation dialog
    const confirmed = confirm(
        `Are you sure you want to delete the group "${groupName}"?\n\n` +
        `This action cannot be undone and will:\n` +
        `• Delete all group posts and content\n` +
        `• Remove all members from the group\n` +
        `• Delete all join requests\n\n` +
        `Type the group name to confirm deletion.`
    );
    
    if (confirmed) {
        // Additional confirmation by asking user to type group name
        const userInput = prompt(`Please type "${groupName}" to confirm deletion:`);
        
        if (userInput === groupName) {
            deleteGroup();
        } else if (userInput !== null) { // User didn't cancel
            alert('Group name does not match. Deletion cancelled.');
        }
    }
}

function deleteGroup() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Show loading state
    const deleteBtn = event.target;
    const originalText = deleteBtn.innerHTML;
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
    
    fetch(`/groups/{{ $group->id }}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json().catch(() => {
            // Handle case where response is not JSON (redirect response)
            return { success: true, message: 'Group deleted successfully!' };
        });
    })
    .then(data => {
        showNotification('Group deleted successfully!', 'success');
        setTimeout(() => {
            window.location.href = '/groups';
        }, 1500);
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting group. Please try again.', 'error');
        
        // Restore button state
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = originalText;
    });
}

</script>

@endsection