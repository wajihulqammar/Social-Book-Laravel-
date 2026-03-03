{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/socialbook.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<style>
    
body {
    background: #f0f2f5;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Enhanced Topbar */
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

/* Main Layout */
.shell {
    max-width: 1200px;
    margin: 20px auto;
    display: grid;
    grid-template-columns: 280px 1fr 320px;
    gap: 20px;
    align-items: start;
    padding: 0 16px;
}

.left-sidebar {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px 0;
    position: sticky;
    top: 80px;
    height: fit-content;
    max-height: calc(100vh - 100px); /* Prevent it from being too tall */
    overflow-y: auto; /* Allow internal scrolling if content is too long */
}

.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu li {
    position: relative;
    margin: 2px 0;
}

.menu li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #1c1e21;
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
    border-radius: 8px;
    margin: 0 8px;
    transition: all 0.2s ease;
    position: relative;
}

.menu li a:hover {
    background: #f0f2f5;
    transform: translateX(2px);
}

.menu li.active a {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);
}

.menu li.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #1877f2;
    border-radius: 0 4px 4px 0;
}

.menu li i {
    width: 20px;
    text-align: center;
    font-size: 16px;
}

.menu li.active i {
    color: #fff;
}

/* Content Area */
.content-area {
    background: transparent;
}

/* Enhanced Post Creation */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 16px;
    margin-bottom: 16px;
}

.create-post {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.create-post-top {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.create-post-top img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
}

.create-post-top textarea {
    flex: 1;
    border: none;
    background: #f0f2f5;
    border-radius: 50px;
    padding: 12px 16px;
    font-size: 16px;
    resize: none;
    outline: none;
    transition: all 0.2s;
    font-family: inherit;
}

.create-post-top textarea:focus {
    background: #e4e6ea;
    transform: scale(1.01);
}

.create-post-actions {
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid #e4e6ea;
    padding-top: 12px;
    margin-top: 12px;
}

.create-post-actions label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #65676b;
    font-weight: 500;
    font-size: 15px;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.2s;
}

.create-post-actions label:hover {
    background: #f0f2f5;
    transform: translateY(-1px);
}

.create-post-actions button {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 24px;
    font-weight: 600;
    cursor: pointer;
    font-size: 15px;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);
}

.create-post-actions button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
}

/* Enhanced Posts */
.post {
    margin-bottom: 20px;
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s;
}
.like-btn.liked {
    color: #1877f2 !important;
    font-weight: bold;
}

.comment-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f2f5;
    font-size: 14px;
}
html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* prevent horizontal scroll */
        overflow-y: auto;   /* enable vertical scrolling */
    }

.comment-item:last-child {
    border-bottom: none;
}

.comment-form {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    align-items: center;
}

.post:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.post .head {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
}

.post .head img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
}

.post .body {
    padding: 0 16px 16px;
    font-size: 15px;
    line-height: 1.6;
    color: #1c1e21;
}

.post img {
    width: 100%;
    display: block;
    max-height: 500px;
    object-fit: cover;
}

.post-footer {
    display: flex;
    justify-content: space-around;
    font-size: 15px;
    color: #65676b;
    border-top: 1px solid #e4e6ea;
    margin-top: 12px;
}

.post-footer button {
    flex: 1;
    background: none;
    border: none;
    color: #65676b;
    cursor: pointer;
    font-size: 15px;
    padding: 12px 0;
    font-weight: 600;
    transition: all 0.2s;
    border-radius: 8px;
    margin: 4px;
}

.post-footer button:hover {
    background: #f0f2f5;
    color: #1877f2;
    transform: translateY(-1px);
}

/* Enhanced Right Sidebar */
.right-sidebar {
    position: sticky;
    top: 80px;
    height: fit-content;
}

.right-sidebar .card {
    padding: 20px;
}

.right-sidebar h3 {
    margin: 0 0 16px 0;
    font-size: 17px;
    font-weight: 600;
    color: #1c1e21;
}

.sugg {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sugg li {
    padding: 12px 0;
    border-bottom: 1px solid #e4e6ea;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s;
}

.sugg li:hover {
    background: #f8f9fa;
    margin: 0 -20px;
    padding: 12px 20px;
    border-radius: 8px;
}

.sugg li:last-child {
    border-bottom: none;
}

.sugg a {
    text-decoration: none;
    color: #1c1e21;
    font-weight: 500;
    font-size: 14px;
}

/* Enhanced Buttons */
.btn, .btn-add {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);
}

.btn-add:hover, .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(24, 119, 242, 0.4);
}

.btn-danger {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    padding: 6px 12px;
    font-size: 12px;
    box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 38, 38, 0.4);
}

.btn-accept, .btn-decline {
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 6px;
    margin-left: 4px;
    cursor: pointer;
    border: none;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-accept {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: #fff;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
}

.btn-accept:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
}

.btn-decline {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: #fff;
    box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
}

.btn-decline:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 38, 38, 0.4);
}

.status-label {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 4px;
    background: #f0f2f5;
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    .shell {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .left-sidebar, .right-sidebar {
        position: relative;
        top: 0;
    }
}

/* Loading Animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.loading {
    animation: pulse 1.5s infinite;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f3f4;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
    </style>


<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="search">
        <input type="text" id="user-search" placeholder="Search SocialBook..." autocomplete="off">
        <div id="search-results" style="position:absolute; background:#fff; border:1px solid #ddd; border-radius:6px; width:100%; max-width:420px; display:none; z-index:1000;"></div>
    </div>

    <div class="topbar-right">
        <!-- FIXED: Use the accessor method for consistent default image -->
        <a href="{{ route('profile.show', auth()->user()->id) }}" class="profile-link">
            <img src="{{ auth()->user()->profile_picture_url }}" alt="DP" onerror="this.src='{{ asset('images/default-male.png') }}'">
            <span>{{ auth()->user()->first_name }}</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="shell">
    <!-- Left Sidebar - Now scrollable -->
    <div class="left-sidebar">
        <ul class="menu">
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-newspaper"></i> News Feed
                </a>
            </li>
            <li class="{{ request()->routeIs('messages*') ? 'active' : '' }}">
                <a href="{{ route('messages.index') }}">
                    <i class="fas fa-comments"></i> Messages
                    @php
                        $unreadCount = auth()->user()->getTotalUnreadCount();
                    @endphp
                    @if($unreadCount > 0)
                        <span style="background: #ff4757; color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; margin-left: auto;">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="{{ request()->routeIs('friends*') ? 'active' : '' }}">
                <a href="{{ route('friends.index') }}">
                    <i class="fas fa-user-friends"></i> Friends
                </a>
            </li>
            <li class="{{ request()->routeIs('marketplace*') ? 'active' : '' }}">
                <a href="{{ route('marketplace.index') }}">
                    <i class="fas fa-store"></i> Marketplace
                </a>
            </li>
            <li class="{{ request()->routeIs('groups*') ? 'active' : '' }}">
                <a href="{{ route('groups.index') }}">
                    <i class="fas fa-users"></i> Groups
                </a>
            </li>
            <li class="{{ request()->routeIs('ai*') ? 'active' : '' }}">
                <a href="{{ route('ai.index') }}">
                    <i class="fas fa-robot"></i> SocialBook AI
                    <span style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border-radius: 4px; padding: 2px 6px; font-size: 10px; font-weight: 600; margin-left: 8px;">NEW</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Center Content -->
    <div class="content-area">
        <!-- Create Post -->
        <div class="create-post">
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="create-post-top">
                    <!-- FIXED: Use the accessor method for consistent default image -->
                    <img src="{{ auth()->user()->profile_picture_url }}" alt="Avatar" onerror="this.src='{{ asset('images/default-male.png') }}'">
                    <textarea name="body" rows="1" placeholder="What's on your mind, {{ auth()->user()->first_name }}?">{{ old('body') }}</textarea>
                </div>
                <div class="create-post-actions">
                    <label>
                        <span>📷 Photo/Video</span>
                        <input type="file" name="image" accept="image/*" hidden>
                    </label>
                    <label id="feelingBtn" style="cursor:pointer;">
                        <span>😊 Feeling/Activity</span>
                    </label>
                    <input type="hidden" name="feeling_activity" id="feelingInput">
                    <span id="feelingSelected" style="margin-left:6px;color:#65676b;"></span>
                    <button type="submit">Post</button>
                </div>
            </form>
        </div>

        <!-- Feed Posts -->
        @forelse($posts as $post)
            <div class="post card">
                <div class="head">
                    <a href="{{ route('profile.show', $post->user->id) }}">
                       <!-- FIXED: Use the accessor method for consistent default image -->
                       <img src="{{ $post->user->profile_picture_url }}" class="avatar" alt="Profile" onerror="this.src='{{ asset('images/default-male.png') }}'">
                    </a>
                    <div>
                        <a href="{{ route('profile.show', $post->user->id) }}" style="font-weight:600;color:#1c1e21;text-decoration:none;">
                            {{ $post->user->first_name }} {{ $post->user->last_name }}
                        </a>
                        <div style="font-size:13px;color:#65676b">{{ $post->created_at->diffForHumans() }}</div>
                    </div>

                    @if($post->user_id === auth()->id())
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" style="margin-left:auto">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    @endif
                </div>

                <!-- Feeling/Activity -->
                @if($post->feeling_activity)
                    <div style="font-size:14px;color:#65676b;margin-bottom:8px;padding:0 16px;">
                        {{ auth()->id() === $post->user_id ? 'You' : $post->user->first_name }} is {{ $post->feeling_activity }}
                    </div>
                @endif

                <!-- Post Body -->
                @if($post->body)
                    <div class="body">{{ $post->body }}</div>
                @endif

                <!-- Post Image -->
                @if($post->image_path)
                    <img src="{{ $post->image_url }}" alt="post image">
                @endif

               <!-- Post actions -->
                <div class="post-footer" data-post-id="{{ $post->id }}">
                    <button class="like-btn {{ $post->user_has_liked ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                        👍 Like
                        <span class="count" id="likes-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                    </button>
                    
                    <button class="comment-toggle-btn" data-post-id="{{ $post->id }}">
                        💬 Comment
                        <span class="count" id="comments-count-{{ $post->id }}">{{ $post->comments_count ?? 0 }}</span>
                    </button>
                    
                    <button class="share-btn" onclick="copyToClipboard('{{ url('/posts/'.$post->id) }}')">
                        ↗️ Share
                    </button>
                </div>

                <!-- Comments list -->
                <div class="comments-list" id="comments-list-{{ $post->id }}">
                    @php
                        $comments = $post->interactions()
                            ->where('type', 'comment')
                            ->with('user')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    @foreach($comments as $c)
                        <div class="comment-item" id="comment-{{ $c->id }}">
                            <strong>{{ $c->user->first_name ?? $c->user->name }}:</strong>
                            <span>{{ $c->content }}</span>
                            <small style="color:#65676b;">• {{ $c->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>

                <!-- Comment input (hidden by default) -->
                <div class="comment-form" id="comment-form-{{ $post->id }}" style="display:none;margin-top:8px;">
                    <input type="text" id="comment-input-{{ $post->id }}" placeholder="Write a comment..." style="width:80%;padding:8px;border:1px solid #ddd;border-radius:20px;outline:none;">
                    <button type="button" class="comment-send-btn" data-post-id="{{ $post->id }}" style="background:#1877F2;color:white;border:none;padding:8px 12px;border-radius:15px;cursor:pointer;">Send</button>
                </div>
            </div>
        @empty
            <div class="card">
                <div style="text-align:center;padding:20px;color:#65676b;">
                    <i class="fas fa-newspaper" style="font-size:48px;margin-bottom:16px;color:#e4e6ea;"></i>
                    <h3 style="margin:0 0 8px 0;color:#1c1e21;">No posts yet</h3>
                    <p style="margin:0;">Be the first to share something with your friends!</p>
                </div>
            </div>
        @endforelse

        
    </div>

    <!-- Right Sidebar -->
    <div class="right-sidebar">
        <div class="card">
            <h3>People You May Know</h3>
            <ul class="sugg">
                @forelse($suggestions as $u)
                    @if($u->id !== auth()->id())
                        @php
                            $friendship = \App\Models\Friendship::where(function($q) use ($u) {
                                $q->where('sender_id', auth()->id())
                                  ->where('receiver_id', $u->id);
                            })->orWhere(function($q) use ($u) {
                                $q->where('sender_id', $u->id)
                                  ->where('receiver_id', auth()->id());
                            })->first();
                        @endphp
                        <li>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <!-- FIXED: Use the accessor method for consistent default image -->
                                <img src="{{ $u->profile_picture_url }}" 
                                     style="width:32px;height:32px;border-radius:50%;object-fit:cover;" 
                                     alt="Profile"
                                     onerror="this.src='{{ asset('images/default-male.png') }}'">
                                <a href="{{ route('profile.show', $u->id) }}">
                                    {{ $u->first_name }} {{ $u->last_name }}
                                </a>
                            </div>

                            <div>
                                @if($friendship)
                                    @if($friendship->status === 'pending')
                                        @if($friendship->sender_id === auth()->id())
                                            <span class="status-label" style="color:#6b7280;">Pending</span>
                                        @else
                                            <button class="btn-accept" data-id="{{ $friendship->id }}">Accept</button>
                                            <button class="btn-decline" data-id="{{ $friendship->id }}">Decline</button>
                                        @endif
                                    @elseif($friendship->status === 'accepted')
                                        <span class="status-label" style="color:green;">Friends</span>
                                    @endif
                                @else
                                    <button class="btn-add" data-id="{{ $u->id }}">+ Add</button>
                                @endif
                            </div>
                        </li>
                    @endif
                @empty
                    <li style="text-align:center;color:#65676b;padding:20px 0;">
                        <i class="fas fa-user-friends" style="font-size:32px;margin-bottom:8px;color:#e4e6ea;"></i>
                        <div>No suggestions available</div>
                    </li>
                @endforelse
            </ul>
        </div>

        <!-- Groups widget - REPLACED the Pages widget -->
        <div class="card" style="margin-top:16px;">
            <h3>Your Groups</h3>
            @if(auth()->user()->groups && auth()->user()->groups->count() > 0)
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach(auth()->user()->groups->take(3) as $group)
                        <div style="display:flex;align-items:center;gap:8px;padding:8px;border-radius:8px;transition:background 0.2s;" 
                             onmouseover="this.style.background='#f0f2f5'" 
                             onmouseout="this.style.background='transparent'">
                            <div style="width:32px;height:32px;background:linear-gradient(135deg,#1877f2,#42a5f5);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:12px;">
                                {{ strtoupper(substr($group->name, 0, 2)) }}
                            </div>
                            <div>
                                <a href="{{ route('groups.show', $group->id) }}" style="text-decoration:none;color:#1c1e21;font-weight:500;font-size:14px;">
                                   <b> {{ Str::limit($group->name, 20) }}</b>
                                </a>
                               
                            </div>
                        </div>
                    @endforeach
                    @if(auth()->user()->groups->count() > 3)
                        <a href="{{ route('groups.index') }}" style="text-align:center;padding:8px;color:#1877f2;text-decoration:none;font-size:14px;font-weight:500;">
                            See all groups
                        </a>
                    @endif
                </div>
            @else
                <div style="text-align:center;padding:20px 0;color:#65676b;">
                    <i class="fas fa-users" style="font-size:32px;margin-bottom:8px;color:#e4e6ea;"></i>
                    <div style="font-size:14px;margin-bottom:8px;">No groups joined yet</div>
                    <a href="{{ route('groups.discover') }}" style="color:#1877f2;text-decoration:none;font-size:13px;font-weight:500;">
                        Discover Groups
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Enhanced JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Existing feeling/activity dropdown code - FIXED
    const feelings = [
        "😊 happy", "😢 sad", "😡 angry", "😎 cool", "😴 tired",
        "🎬 watching a movie", "🍔 eating", "🏃 running", "🎮 gaming", "📚 studying"
    ];

    const feelingBtn = document.getElementById('feelingBtn');
    const feelingInput = document.getElementById('feelingInput');
    const feelingSelected = document.getElementById('feelingSelected');

    if (feelingBtn) {
        const dropdown = document.createElement('div');
        dropdown.style.cssText = `
            position: absolute;
            background: #fff;
            border: 1px solid #e4e6ea;
            border-radius: 8px;
            padding: 8px 0;
            display: none;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            z-index: 1000;
            min-width: 200px;
        `;

        feelings.forEach(feeling => {
            const option = document.createElement('div');
            option.textContent = feeling;
            option.style.cssText = `
                padding: 8px 16px;
                cursor: pointer;
                transition: background 0.2s;
                font-size: 14px;
            `;
            option.addEventListener('click', () => {
                feelingInput.value = feeling;
                feelingSelected.textContent = `- ${feeling}`;
                feelingSelected.style.fontStyle = 'italic';
                dropdown.style.display = 'none';
            });
            option.addEventListener('mouseenter', () => option.style.background = '#f0f2f5');
            option.addEventListener('mouseleave', () => option.style.background = '#fff');
            dropdown.appendChild(option);
        });

        document.body.appendChild(dropdown);

        feelingBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const rect = feelingBtn.getBoundingClientRect();
            dropdown.style.top = rect.bottom + window.scrollY + 'px';
            dropdown.style.left = rect.left + window.scrollX + 'px';
            dropdown.style.display = 'block';
        });

        document.addEventListener('click', (e) => {
            if (!feelingBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    }
    

    // Enhanced friend request functionality
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
        || document.querySelector('input[name="_token"]')?.value;

    // Add loading states and better error handling
    function showLoading(button, text = 'Loading...') {
        button.disabled = true;
        button.style.opacity = '0.7';
        const originalText = button.textContent;
        button.textContent = text;
        return originalText;
    }

    function hideLoading(button, originalText) {
        button.disabled = false;
        button.style.opacity = '1';
        button.textContent = originalText;
    }

    // Handle Add Friend buttons with enhanced UX
    document.querySelectorAll('.btn-add').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const originalText = showLoading(this, 'Sending...');
            
            fetch(`/friend-request/send/${userId}`, {
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
                    this.outerHTML = '<span class="status-label" style="color:#6b7280;">Pending</span>';
                    showNotification('Friend request sent successfully!', 'success');
                } else {
                    hideLoading(this, originalText);
                    showNotification(data.message || 'Error sending friend request', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading(this, originalText);
                showNotification('Error sending friend request. Please try again.', 'error');
            });
        });
    });

    // Handle Accept Friend buttons
    document.querySelectorAll('.btn-accept').forEach(button => {
        button.addEventListener('click', function() {
            const friendshipId = this.getAttribute('data-id');
            const declineButton = this.nextElementSibling;
            const originalText = showLoading(this, 'Accepting...');
            
            fetch(`/friend-request/accept/${friendshipId}`, {
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
                    const friendsStatus = '<span class="status-label" style="color:green;">Friends</span>';
                    this.outerHTML = friendsStatus;
                    if (declineButton && declineButton.classList.contains('btn-decline')) {
                        declineButton.remove();
                    }
                    showNotification('Friend request accepted!', 'success');
                } else {
                    hideLoading(this, originalText);
                    showNotification(data.message || 'Error accepting friend request', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading(this, originalText);
                showNotification('Error accepting friend request. Please try again.', 'error');
            });
        });
    });

    // Handle Decline Friend buttons
    document.querySelectorAll('.btn-decline').forEach(button => {
        button.addEventListener('click', function() {
            const friendshipId = this.getAttribute('data-id');
            const acceptButton = this.previousElementSibling;
            const originalText = showLoading(this, 'Declining...');
            
            fetch(`/friend-request/decline/${friendshipId}`, {
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
                    const userId = acceptButton.getAttribute('data-user-id') || this.getAttribute('data-user-id');
                    const addButton = `<button class="btn-add" data-id="${userId}">+ Add</button>`;
                    
                    this.outerHTML = addButton;
                    if (acceptButton && acceptButton.classList.contains('btn-accept')) {
                        acceptButton.remove();
                    }
                    
                    attachAddButtonListener();
                    showNotification('Friend request declined', 'info');
                } else {
                    hideLoading(this, originalText);
                    showNotification(data.message || 'Error declining friend request', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading(this, originalText);
                showNotification('Error declining friend request. Please try again.', 'error');
            });
        });
    });

    // Function to re-attach event listeners to dynamically created Add buttons
    function attachAddButtonListener() {
        document.querySelectorAll('.btn-add:not([data-listener-attached])').forEach(button => {
            button.setAttribute('data-listener-attached', 'true');
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const originalText = showLoading(this, 'Sending...');
                
                fetch(`/friend-request/send/${userId}`, {
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
                        this.outerHTML = '<span class="status-label" style="color:#6b7280;">Pending</span>';
                        showNotification('Friend request sent successfully!', 'success');
                    } else {
                        hideLoading(this, originalText);
                        showNotification(data.message || 'Error sending friend request', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading(this, originalText);
                    showNotification('Error sending friend request. Please try again.', 'error');
                });
            });
        });
    }

    // Enhanced notification system
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

        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto remove
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Enhanced search functionality
    const searchInput = document.getElementById('user-search');
const searchResults = document.getElementById('search-results');
let searchTimeout;

if (searchInput && searchResults) {
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            searchResults.innerHTML = '<div style="padding:12px;color:#65676b;font-size:14px;">Searching...</div>';
            searchResults.style.display = 'block';

            fetch(`/search/users?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.users && data.users.length > 0) {
                    searchResults.innerHTML = data.users.map(user => `
                        <div style="padding:10px;border-bottom:1px solid #e4e6ea;cursor:pointer;display:flex;align-items:center;gap:8px;transition:background 0.2s;" 
                             onclick="window.location.href='/u/${user.id}'"
                             onmouseover="this.style.background='#f0f2f5'"
                             onmouseout="this.style.background='transparent'">
                            <img src="${user.profile_picture_url || '/images/default-male.png'}" 
                                 style="width:32px;height:32px;border-radius:50%;object-fit:cover;"
                                 onerror="this.src='/images/default-male.png'">
                            <div>
                                <div style="font-weight:500;color:#1c1e21;">${user.full_name}</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    searchResults.innerHTML = '<div style="padding:12px;color:#65676b;font-size:14px;">No users found</div>';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.innerHTML = '<div style="padding:12px;color:#dc2626;font-size:14px;">Search error occurred</div>';
            });
        }, 300);
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.style.display = 'none';
            this.blur();
        }
    });
}

    // Auto-resize textarea
    const textarea = document.querySelector('.create-post-top textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    }

    // Smooth scroll for navigation
    document.querySelectorAll('.menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add loading animation to the clicked menu item
            const menuItem = this.parentElement;
            if (!menuItem.classList.contains('active')) {
                menuItem.style.opacity = '0.7';
                setTimeout(() => {
                    menuItem.style.opacity = '1';
                }, 200);
            }
        });
    });
});
// Enhanced JavaScript functionality - FIXED VERSION
document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
        || document.querySelector('input[name="_token"]')?.value;

    // LIKE BUTTON FUNCTIONALITY - FIXED
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                const likesEl = document.getElementById('likes-count-' + postId);
                if (likesEl) likesEl.textContent = data.likesCount;
                
                // Toggle color/state
                if (data.liked) {
                    this.classList.add('liked');
                    this.style.color = '#1877F2';
                    this.style.fontWeight = 'bold';
                } else {
                    this.classList.remove('liked');
                    this.style.color = '';
                    this.style.fontWeight = '';
                }
            })
            .catch(err => {
                console.error('Like error:', err);
                showNotification('Error liking post. Please try again.', 'error');
            });
        });
    });

    // TOGGLE COMMENT INPUT
    document.querySelectorAll('.comment-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const form = document.getElementById('comment-form-' + postId);
            if (!form) return;
            
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            
            // Focus input when opening
            if (form.style.display === 'block') {
                const input = document.getElementById('comment-input-' + postId);
                if (input) input.focus();
            }
        });
    });

    // SEND COMMENT FUNCTIONALITY - FIXED
    document.querySelectorAll(".comment-send-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const postId = this.dataset.postId;
            const input = document.getElementById("comment-input-" + postId);
            const content = input.value.trim();
            
            if (!content) {
                showNotification('Please write a comment first!', 'error');
                return;
            }

            // Disable button during request
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Sending...';

            fetch(`/posts/${postId}/comment`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ 
                    content: content 
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Create new comment element
                const commentList = document.getElementById("comments-list-" + postId);
                const newComment = document.createElement("div");
                newComment.classList.add("comment-item");
                newComment.innerHTML = `
                    <strong>${data.comment.user.first_name} ${data.comment.user.last_name || ''}:</strong> 
                    <span>${data.comment.content}</span> 
                    <small style="color:#65676b;">• ${data.comment.created_at}</small>
                `;
                
                // Add to top of comments list
                if (commentList.firstChild) {
                    commentList.insertBefore(newComment, commentList.firstChild);
                } else {
                    commentList.appendChild(newComment);
                }
                
                // Clear input
                input.value = "";
                
                // Update comments counter
                const counter = document.getElementById("comments-count-" + postId);
                if (counter) {
                    counter.textContent = data.commentsCount;
                }
                
                // Hide comment form
                document.getElementById('comment-form-' + postId).style.display = 'none';
                
                showNotification('Comment posted successfully!', 'success');
            })
            .catch(error => {
                console.error("Comment error:", error);
                showNotification('Error posting comment. Please try again.', 'error');
            })
            .finally(() => {
                // Re-enable button
                btn.disabled = false;
                btn.textContent = originalText;
            });
        });
    });
    
    // Allow Enter key to submit comment
    document.querySelectorAll('[id^="comment-input-"]').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const postId = this.id.replace('comment-input-', '');
                const sendBtn = document.querySelector(`[data-post-id="${postId}"].comment-send-btn`);
                if (sendBtn) sendBtn.click();
            }
        });
    });

    // Copy to clipboard for Share
    window.copyToClipboard = function(url) {
        navigator.clipboard.writeText(url).then(() => {
            showNotification("Post link copied!", 'success');
        }).catch(err => {
            console.error('Copy failed:', err);
            showNotification('Could not copy link to clipboard', 'error');
        });
    };
});
</script>

@endsection