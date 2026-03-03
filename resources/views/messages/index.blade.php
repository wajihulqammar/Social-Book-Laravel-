{{-- resources/views/messages/index.blade.php --}}
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

/* Topbar styles */
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
/* Messages layout */
.messages-container {
    max-width: 1200px;
    margin: 20px auto;
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 0;
    height: calc(100vh - 100px);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.messages-sidebar {
    background: #fff;
    border-right: 1px solid #e4e6ea;
    display: flex;
    flex-direction: column;
}

.messages-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e4e6ea;
    display: flex;
    align-items: center;
    gap: 12px;
}

.back-button {
    background: none;
    border: none;
    font-size: 18px;
    color: #1877f2;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    min-width: 36px;
}

.back-button:hover {
    background: #f0f2f5;
}

.messages-header h2 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #1c1e21;
}

.conversations-list {
    flex: 1;
    overflow-y: auto;
}

.conversation-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: background 0.2s;
    text-decoration: none;
    color: inherit;
}

.conversation-item:hover {
    background: #f0f2f5;
}

.conversation-item.active {
    background: #e7f3ff;
    border-right: 3px solid #1877f2;
}

.conversation-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
}

.conversation-info {
    flex: 1;
    min-width: 0;
}

.conversation-name {
    font-weight: 600;
    font-size: 15px;
    color: #1c1e21;
    margin-bottom: 4px;
}

.conversation-preview {
    font-size: 13px;
    color: #65676b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.conversation-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.conversation-time {
    font-size: 12px;
    color: #65676b;
}

.unread-badge {
    background: #1877f2;
    color: #fff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 600;
}

.messages-main {
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #65676b;
}

.messages-main i {
    font-size: 64px;
    color: #e4e6ea;
    margin-bottom: 16px;
}

.messages-main h3 {
    margin: 0 0 8px 0;
    color: #1c1e21;
    font-size: 20px;
}

.messages-main p {
    margin: 0;
    font-size: 16px;
}

@media screen and (max-width: 768px) {
    .messages-container {
        grid-template-columns: 1fr;
        margin: 10px;
    }
}
</style>

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

<div class="messages-container">
    <!-- Messages Sidebar -->
    <div class="messages-sidebar">
        <div class="messages-header">
            <button class="back-button" onclick="window.location.href='{{ route('dashboard') }}'" title="Back to News Feed">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2><i class="fas fa-comments"></i> Chats</h2>
        </div>
        
        <div class="conversations-list">
            @forelse($conversations as $conversation)
                <a href="{{ route('messages.show', $conversation->friend->id) }}" class="conversation-item">
                    <img src="{{ $conversation->friend->profile_picture 
                        ? asset('uploads/profile_pictures/' . $conversation->friend->profile_picture) 
                        : asset('images/default.png') }}" 
                         alt="Profile" class="conversation-avatar">
                    
                    <div class="conversation-info">
                        <div class="conversation-name">
                            {{ $conversation->friend->first_name }} {{ $conversation->friend->last_name }}
                        </div>
                        
                        @if($conversation->latest_message)
                            <div class="conversation-preview">
                                @if($conversation->latest_message->sender_id === auth()->id())
                                    You: {{ Str::limit($conversation->latest_message->message, 30) }}
                                @else
                                    {{ Str::limit($conversation->latest_message->message, 30) }}
                                @endif
                            </div>
                        @else
                            <div class="conversation-preview">No messages yet</div>
                        @endif
                    </div>
                    
                    <div class="conversation-meta">
                        @if($conversation->latest_message)
                            <div class="conversation-time">
                                {{ $conversation->latest_message->created_at->diffForHumans(null, true) }}
                            </div>
                        @endif
                        
                        @if($conversation->unread_count > 0)
                            <div class="unread-badge">{{ $conversation->unread_count }}</div>
                        @endif
                    </div>
                </a>
            @empty
                <div style="padding: 40px 20px; text-align: center; color: #65676b;">
                    <i class="fas fa-comments" style="font-size: 48px; color: #e4e6ea; margin-bottom: 16px;"></i>
                    <h3 style="margin: 0 0 8px 0; color: #1c1e21; font-size: 18px;">No conversations yet</h3>
                    <p style="margin: 0; font-size: 14px;">Start chatting with your friends!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Messages Main Content -->
    <div class="messages-main">
        <i class="fas fa-comments"></i>
        <h3>Your Messages</h3>
        <p>Send private messages to a friend.</p>
    </div>
</div>

@endsection