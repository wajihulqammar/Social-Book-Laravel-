{{-- resources/views/friends/index.blade.php --}}
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

/* Include the same topbar and shell styles from the main dashboard */
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
}

.menu {
    list-style: none;
    padding: 0;
    margin: 0;
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
}

.menu li.active a {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);
}

.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 16px;
}

.friends-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 20px;
}

.friends-tabs {
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e4e6ea;
}

.friends-tab {
    padding: 12px 16px;
    color: #65676b;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}

.friends-tab.active {
    color: #1877f2;
    border-bottom-color: #1877f2;
}

.friends-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 20px;
}

.friend-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 16px;
    text-align: center;
    transition: all 0.2s;
}

.friend-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.friend-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 12px;
    border: 3px solid #e4e6ea;
}

.friend-name {
    font-weight: 600;
    font-size: 16px;
    color: #1c1e21;
    margin-bottom: 4px;
}

.friend-info {
    font-size: 13px;
    color: #65676b;
    margin-bottom: 12px;
}

.friend-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-primary {
    background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
    color: #fff;
    box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);
}

.btn-secondary {
    background: #e4e6ea;
    color: #1c1e21;
}

.btn:hover {
    transform: translateY(-1px);
}

.right-sidebar {
    position: sticky;
    top: 80px;
    height: fit-content;
}

@media screen and (max-width: 1024px) {
    .shell {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .left-sidebar, .right-sidebar {
        position: relative;
        top: 0;
    }
    
    .friends-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}
</style>

<!-- Include the same topbar from dashboard -->
<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="search">
        <input type="text" placeholder="Search SocialBook..." autocomplete="off">
    </div>
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

<div class="shell">
    <!-- Left Sidebar (same as dashboard) -->
   {{-- Replace the menu in your left sidebars with this updated version --}}
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

    <!-- Main Content -->
    <div class="content-area">
        <div class="card">
            <div class="friends-header">
                <h2 style="margin: 0; color: #1c1e21; font-size: 24px;">Friends</h2>
            </div>

            <!-- Friends Navigation Tabs -->
            <div class="friends-tabs">
                <a href="{{ route('friends.index') }}" class="friends-tab {{ request()->routeIs('friends.index') ? 'active' : '' }}">
                    All Friends ({{ $friends->total() }})
                </a>
                <a href="{{ route('friends.requests') }}" class="friends-tab {{ request()->routeIs('friends.requests') ? 'active' : '' }}">
                    Friend Requests ({{ $friendRequests->count() }})
                </a>
                <a href="{{ route('friends.suggestions') }}" class="friends-tab {{ request()->routeIs('friends.suggestions') ? 'active' : '' }}">
                    Suggestions
                </a>
            </div>

            <!-- Friends Grid -->
            <div class="friends-grid">
                @forelse($friends as $friend)
                    <div class="friend-card">
                        <img src="{{ $friend->profile_picture 
                            ? asset('uploads/profile_pictures/' . $friend->profile_picture) 
                            : asset('images/default.png') }}" 
                             alt="Profile" class="friend-avatar">
                        
                        <div class="friend-name">
                            <a href="{{ route('profile.show', $friend->id) }}" style="color: #1c1e21; text-decoration: none;">
                                {{ $friend->first_name }} {{ $friend->last_name }}
                            </a>
                        </div>
                        
                        <div class="friend-info">
                            {{ $friend->posts_count }} {{ Str::plural('post', $friend->posts_count) }} • 
                            {{ $friend->sent_friendships_count }} {{ Str::plural('friend', $friend->sent_friendships_count) }}
                        </div>
                        
                       <div class="friend-actions">
    {{-- View Profile Button --}}
    <button class="btn btn-primary"
            onclick="window.location.href='{{ route('profile.show', $friend->id) }}'">
        <i class="fas fa-user"></i> View Profile
    </button>

    {{-- Messages Button --}}
    <button class="btn btn-secondary"
            onclick="window.location.href='{{ route('messages.index') }}'">
        <i class="fas fa-comments"></i> Messages
    </button>
</div>

                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #65676b;">
                        <i class="fas fa-user-friends" style="font-size: 48px; margin-bottom: 16px; color: #e4e6ea;"></i>
                        <h3 style="margin: 0 0 8px 0; color: #1c1e21;">No friends yet</h3>
                        <p style="margin: 0;">Connect with people to see them here!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($friends->hasPages())
                <div style="margin-top: 20px;">
                    {{ $friends->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="right-sidebar">
        <!-- Friend Requests Preview -->
        @if($friendRequests->count() > 0)
            <div class="card">
                <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                    Friend Requests
                </h3>
                @foreach($friendRequests as $request)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #e4e6ea;">
                        <img src="{{ $request->sender->profile_picture 
                            ? asset('uploads/profile_pictures/' . $request->sender->profile_picture) 
                            : asset('images/default.png') }}" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Profile">
                        
                        <div style="flex: 1;">
                            <div style="font-weight: 500; color: #1c1e21; font-size: 14px;">
                                {{ $request->sender->first_name }} {{ $request->sender->last_name }}
                            </div>
                            <div style="font-size: 12px; color: #65676b;">
                                {{ $request->created_at->diffForHumans() }}
                            </div>
                            <div style="margin-top: 8px; display: flex; gap: 8px;">
                                <button class="btn-accept" data-id="{{ $request->id }}" style="padding: 4px 12px; font-size: 12px; background: #42a5f5; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                                    Accept
                                </button>
                                <button class="btn-decline" data-id="{{ $request->id }}" style="padding: 4px 12px; font-size: 12px; background: #dc2626; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                                    Decline
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($friendRequests->count() >= 5)
                    <div style="text-align: center; margin-top: 12px;">
                        <a href="{{ route('friends.requests') }}" style="color: #1877f2; text-decoration: none; font-weight: 500;">
                            See All Requests
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- People You May Know -->
        <div class="card">
            <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                People You May Know
            </h3>
            @foreach($suggestions->take(5) as $suggestion)
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #e4e6ea;">
                    <img src="{{ $suggestion->profile_picture 
                        ? asset('uploads/profile_pictures/' . $suggestion->profile_picture) 
                        : asset('images/default.png') }}" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;" alt="Profile">
                    
                    <div style="flex: 1;">
                        <div style="font-weight: 500; color: #1c1e21; font-size: 14px;">
                            <a href="{{ route('profile.show', $suggestion->id) }}" style="color: #1c1e21; text-decoration: none;">
                                {{ $suggestion->first_name }} {{ $suggestion->last_name }}
                            </a>
                        </div>
                        <div style="margin-top: 4px;">
                            <button class="btn-add" data-id="{{ $suggestion->id }}" style="padding: 4px 12px; font-size: 12px; background: #1877f2; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                                + Add Friend
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div style="text-align: center; margin-top: 12px;">
                <a href="{{ route('friends.suggestions') }}" style="color: #1877f2; text-decoration: none; font-weight: 500;">
                    See All Suggestions
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Handle Add Friend buttons
    document.querySelectorAll('.btn-add').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const originalText = this.textContent;
            
            this.disabled = true;
            this.textContent = 'Sending...';
            
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
                    this.textContent = 'Request Sent';
                    this.style.background = '#65676b';
                    this.disabled = true;
                } else {
                    this.disabled = false;
                    this.textContent = originalText;
                    alert(data.message || 'Error sending friend request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.disabled = false;
                this.textContent = originalText;
                alert('Error sending friend request. Please try again.');
            });
        });
    });

    // Handle Accept Friend buttons
    document.querySelectorAll('.btn-accept').forEach(button => {
        button.addEventListener('click', function() {
            const friendshipId = this.getAttribute('data-id');
            const declineButton = this.nextElementSibling;
            
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
                    this.parentElement.innerHTML = '<span style="color: green; font-size: 12px; font-weight: 600;">Friends</span>';
                } else {
                    alert(data.message || 'Error accepting friend request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error accepting friend request. Please try again.');
            });
        });
    });

    // Handle Decline Friend buttons
    document.querySelectorAll('.btn-decline').forEach(button => {
        button.addEventListener('click', function() {
            const friendshipId = this.getAttribute('data-id');
            
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
                    this.parentElement.parentElement.parentElement.remove();
                } else {
                    alert(data.message || 'Error declining friend request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error declining friend request. Please try again.');
            });
        });
    });
});
</script>

@endsection