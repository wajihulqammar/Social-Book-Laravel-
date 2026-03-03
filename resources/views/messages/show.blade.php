{{-- resources/views/messages/show.blade.php --}}
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

/* Same topbar styles as index */
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

/* Messages chat layout */
.messages-container {
    max-width: 1200px;
    margin: 20px auto;
    display: grid;
    grid-template-columns: 300px 1fr;
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
    width: 44px;
    height: 44px;
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
    font-size: 14px;
    color: #1c1e21;
    margin-bottom: 2px;
}

.conversation-preview {
    font-size: 12px;
    color: #65676b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.unread-badge {
    background: #1877f2;
    color: #fff;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 600;
    margin-left: auto;
}

/* Chat area */
.chat-area {
    background: #fff;
    display: flex;
    flex-direction: column;
}

.chat-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid #e4e6ea;
    background: #fff;
}

.chat-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
}

.chat-user-info h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #1c1e21;
}

.chat-user-info .status {
    font-size: 12px;
    color: #65676b;
    margin-top: 2px;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #f8f9fa;
    scroll-behavior: smooth;
}

.message-group {
    margin-bottom: 16px;
}

.message-item {
    display: flex;
    margin-bottom: 4px;
    align-items: flex-end;
    gap: 8px;
}

.message-item.sent {
    flex-direction: row-reverse;
}

.message-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
}

.message-content {
    max-width: 70%;
    word-wrap: break-word;
}

.message-bubble {
    padding: 8px 12px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.4;
    position: relative;
}

.message-item.received .message-bubble {
    background: #e4e6ea;
    color: #1c1e21;
}

.message-item.sent .message-bubble {
    background: #1877f2;
    color: #fff;
}

.message-time {
    font-size: 11px;
    color: #65676b;
    margin-top: 2px;
    text-align: center;
}

.message-item.sent .message-time {
    text-align: right;
}

.message-item.received .message-time {
    text-align: left;
}

/* Message input */
.message-input-area {
    padding: 16px 20px;
    border-top: 1px solid #e4e6ea;
    background: #fff;
}

.message-input-form {
    display: flex;
    align-items: flex-end;
    gap: 12px;
}

.message-input {
    flex: 1;
    min-height: 36px;
    max-height: 120px;
    padding: 8px 12px;
    border: 1px solid #ccd0d5;
    border-radius: 20px;
    font-size: 14px;
    resize: none;
    outline: none;
    font-family: inherit;
    overflow-y: auto;
}

.message-input:focus {
    border-color: #1877f2;
    box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
}

.send-button {
    background: #1877f2;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 14px;
}

.send-button:hover {
    background: #166fe5;
    transform: scale(1.05);
}

.send-button:disabled {
    background: #ccd0d5;
    cursor: not-allowed;
    transform: none;
}

.typing-indicator {
    display: none;
    padding: 8px 16px;
    color: #65676b;
    font-size: 13px;
    font-style: italic;
}

@media screen and (max-width: 768px) {
    .messages-container {
        grid-template-columns: 1fr;
        margin: 10px;
    }
    
    .messages-sidebar {
        display: none;
    }
}

/* Scrollbar styling */
.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #ccd0d5;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #8a8d91;
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
            <button class="back-button" onclick="window.location.href='{{ route('messages.index') }}'">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2><i class="fas fa-comments"></i> Chats</h2>
        </div>
        
        <div class="conversations-list">
            @foreach($conversations as $conversation)
                <a href="{{ route('messages.show', $conversation['friend']->id) }}" 
                   class="conversation-item {{ $conversation['friend']->id == $friend->id ? 'active' : '' }}">
                    <img src="{{ $conversation['friend']->profile_picture 
                        ? asset('uploads/profile_pictures/' . $conversation['friend']->profile_picture) 
                        : asset('images/default.png') }}" 
                         alt="Profile" class="conversation-avatar">
                    
                    <div class="conversation-info">
                        <div class="conversation-name">
                            {{ $conversation['friend']->first_name }} {{ $conversation['friend']->last_name }}
                        </div>
                        
                        @if($conversation['latest_message'])
                            <div class="conversation-preview">
                                @if($conversation['latest_message']->sender_id === auth()->id())
                                    You: {{ Str::limit($conversation['latest_message']->message, 25) }}
                                @else
                                    {{ Str::limit($conversation['latest_message']->message, 25) }}
                                @endif
                            </div>
                        @else
                            <div class="conversation-preview">No messages yet</div>
                        @endif
                    </div>
                    
                    @if($conversation['unread_count'] > 0)
                        <div class="unread-badge">{{ $conversation['unread_count'] }}</div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="chat-area">
        <!-- Chat Header -->
        <div class="chat-header">
            <img src="{{ $friend->profile_picture 
                ? asset('uploads/profile_pictures/' . $friend->profile_picture) 
                : asset('images/default.png') }}" 
                 alt="Profile" class="chat-avatar">
            
            <div class="chat-user-info">
                <h3>{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                <div class="status">Active now</div>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="chat-messages" id="chatMessages">
            @include('messages.partials.messages', compact('messages'))
        </div>

        <!-- Typing Indicator -->
        <div class="typing-indicator" id="typingIndicator">
            <span id="typingUser"></span> is typing...
        </div>

        <!-- Message Input -->
        <div class="message-input-area">
            <form id="messageForm" class="message-input-form">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $friend->id }}">
                <textarea 
                    name="message" 
                    id="messageInput" 
                    class="message-input" 
                    placeholder="Type a message..." 
                    rows="1"
                    required></textarea>
                <button type="submit" class="send-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const chatMessages = document.getElementById('chatMessages');
    const friendId = {{ $friend->id }};

    // Auto-resize textarea
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Handle form submission
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;

        // Disable send button
        sendButton.disabled = true;
        sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Send message via AJAX
        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                receiver_id: friendId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear input
                messageInput.value = '';
                messageInput.style.height = 'auto';
                
                // Add message to chat
                const messageHtml = data.html;
                chatMessages.insertAdjacentHTML('beforeend', messageHtml);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                alert(data.error || 'Failed to send message');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        })
        .finally(() => {
            // Re-enable send button
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
    });

    // Handle Enter key (send message)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });

    // Auto-scroll to bottom on page load
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Poll for new messages every 3 seconds
    setInterval(function() {
        fetch(`/messages/${friendId}/get`, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                const currentHeight = chatMessages.scrollHeight;
                const currentScroll = chatMessages.scrollTop;
                const isAtBottom = currentScroll + chatMessages.clientHeight >= currentHeight - 10;
                
                chatMessages.innerHTML = data.html;
                
                // Only auto-scroll if user was already at bottom
                if (isAtBottom) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
        })
        .catch(error => {
            console.error('Error polling messages:', error);
        });
    }, 3000);
});
</script>

@endsection