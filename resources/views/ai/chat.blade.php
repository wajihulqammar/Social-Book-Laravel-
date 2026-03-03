{{-- resources/views/ai/chat.blade.php --}}
@extends('layouts.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    background: #f0f2f5;
    min-height: 100vh;
    color: #1c1e21;
    overflow-x: hidden;
}

/* Topbar - Matching dashboard theme */
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

.topbar-right {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 12px;
}

.topbar-right .back-link {
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

.topbar-right .back-link:hover {
    background: #f0f2f5;
    text-decoration: none;
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

/* Main Container */
.ai-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 0 16px;
    height: calc(100vh - 120px);
    display: flex;
    flex-direction: column;
}

/* AI Header */
.ai-header {
    background: #fff;
    padding: 32px;
    border-radius: 12px 12px 0 0;
    text-align: center;
    border-bottom: 1px solid #e4e6ea;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.ai-header h1 {
    font-size: 28px;
    font-weight: 700;
    background: linear-gradient(45deg, #1877f2, #42a5f5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.ai-header p {
    color: #65676b;
    font-size: 16px;
    font-weight: 400;
}

/* Quick Actions */
.ai-quick-actions {
    background: #fff;
    padding: 20px 32px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
    border-bottom: 1px solid #e4e6ea;
}

.quick-action-btn {
    background: #f0f2f5;
    color: #1877f2;
    border: 1px solid #e4e6ea;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.quick-action-btn:hover {
    background: #1877f2;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
    border-color: #1877f2;
}

/* Chat Container */
.ai-chat-container {
    background: #fff;
    display: flex;
    flex-direction: column;
    border-radius: 0 0 12px 12px;
    flex: 1;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.chat-messages {
    flex: 1;
    padding: 24px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
    scroll-behavior: smooth;
}

.message {
    max-width: 75%;
    padding: 16px 20px;
    border-radius: 18px;
    font-size: 15px;
    line-height: 1.5;
    animation: slideIn 0.3s ease-out;
    position: relative;
}

.message.user {
    background: #1877f2;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 6px;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);
}

.message.ai {
    background: #f0f2f5;
    color: #1c1e21;
    align-self: flex-start;
    border-bottom-left-radius: 6px;
    border: 1px solid #e4e6ea;
    position: relative;
}

.message.ai::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 16px;
    width: 16px;
    height: 16px;
    background: #1877f2;
    border-radius: 50%;
    border: 2px solid white;
}

.message-time {
    font-size: 11px;
    opacity: 0.7;
    margin-top: 8px;
    font-weight: 400;
}

.welcome-message {
    text-align: center;
    color: #65676b;
    padding: 60px 20px;
}

.welcome-message .ai-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(45deg, #1877f2, #42a5f5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px;
    color: white;
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
}

.welcome-message h3 {
    font-size: 24px;
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 8px;
}

.welcome-message p {
    font-size: 16px;
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Typing Indicator */
.typing-indicator {
    display: none;
    align-items: center;
    gap: 12px;
    padding: 16px 24px;
    color: #65676b;
    font-style: italic;
    font-size: 14px;
}

.typing-dots {
    display: flex;
    gap: 4px;
}

.typing-dots div {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #1877f2;
    animation: typing 1.5s infinite;
}

.typing-dots div:nth-child(2) { animation-delay: 0.2s; }
.typing-dots div:nth-child(3) { animation-delay: 0.4s; }

/* Chat Input */
.chat-input-container {
    padding: 24px;
    border-top: 1px solid #e4e6ea;
    display: flex;
    gap: 16px;
    align-items: flex-end;
    background: #fafbfc;
}

.chat-input {
    flex: 1;
    border: 2px solid #e4e6ea;
    border-radius: 20px;
    padding: 16px 20px;
    font-size: 15px;
    resize: none;
    outline: none;
    max-height: 120px;
    font-family: inherit;
    transition: all 0.2s ease;
    background: white;
}

.chat-input:focus {
    border-color: #1877f2;
    box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
}

.chat-input::placeholder {
    color: #a0a3a7;
}

.send-button {
    background: #1877f2;
    color: white;
    border: none;
    border-radius: 50%;
    width: 52px;
    height: 52px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.3);
    flex-shrink: 0;
}

.send-button:hover:not(:disabled) {
    background: #166fe5;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 16px rgba(24, 119, 242, 0.4);
}

.send-button:disabled {
    opacity: 0.6;
    transform: none;
    cursor: not-allowed;
}

.send-button i {
    font-size: 18px;
}

/* Animations */
@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

@keyframes typing {
    0%, 60%, 100% { 
        transform: translateY(0); 
        opacity: 0.4; 
    }
    30% { 
        transform: translateY(-8px); 
        opacity: 1; 
    }
}

@keyframes pulse {
    0%, 100% { 
        opacity: 1; 
    }
    50% { 
        opacity: 0.7; 
    }
}

/* Scrollbar Styling */
.chat-messages::-webkit-scrollbar {
    width: 8px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f3f4;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .ai-container {
        margin: 16px auto;
        padding: 0 16px;
        height: calc(100vh - 90px);
    }
    
    .ai-header {
        padding: 24px 20px;
    }
    
    .ai-header h1 {
        font-size: 24px;
    }
    
    .ai-quick-actions {
        padding: 16px 20px;
        gap: 8px;
    }
    
    .quick-action-btn {
        font-size: 12px;
        padding: 10px 16px;
    }
    
    .message {
        max-width: 85%;
        padding: 14px 16px;
        font-size: 14px;
    }
    
    .chat-messages {
        padding: 20px 16px;
        gap: 12px;
    }
    
    .chat-input-container {
        padding: 20px 16px;
        gap: 12px;
    }
    
    .chat-input {
        padding: 14px 16px;
        font-size: 14px;
    }
    
    .send-button {
        width: 48px;
        height: 48px;
    }
    
    .topbar {
        padding: 12px 16px;
    }
    
    .topbar .brand {
        font-size: 20px;
    }
    
    .welcome-message {
        padding: 40px 20px;
    }
    
    .welcome-message .ai-icon {
        width: 56px;
        height: 56px;
        font-size: 24px;
    }
}

@media (max-width: 480px) {
    .ai-header h1 {
        font-size: 20px;
    }
    
    .ai-quick-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .quick-action-btn {
        text-align: center;
    }
}

/* Loading State */
.loading {
    animation: pulse 1.5s infinite;
}

/* Enhanced focus states for accessibility */
.quick-action-btn:focus,
.chat-input:focus,
.send-button:focus {
    outline: 2px solid #1877f2;
    outline-offset: 2px;
}
</style>

<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="topbar-right">
        <a href="{{ route('dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Feed
        </a>
        <a href="{{ route('profile.show', auth()->user()->id) }}" class="profile-link">
            <img src="{{ auth()->user()->profile_picture_url }}" alt="DP">
            <span>{{ auth()->user()->first_name }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="ai-container">
    <div class="ai-header">
        <h1>SocialBook AI</h1>
        <p>Your intelligent companion for creative content and conversations</p>
    </div>

    <div class="ai-quick-actions">
        <button class="quick-action-btn" onclick="quickMessage('Help me write a creative post')">
            <i class="fas fa-pen-fancy"></i> Creative Writing
        </button>
        <button class="quick-action-btn" onclick="quickMessage('Give me some conversation starters')">
            <i class="fas fa-comments"></i> Conversation Ideas
        </button>
        <button class="quick-action-btn" onclick="quickMessage('What are some trending topics today?')">
            <i class="fas fa-trending-up"></i> Trending Topics
        </button>
        <button class="quick-action-btn" onclick="quickMessage('Help me brainstorm ideas')">
            <i class="fas fa-lightbulb"></i> Brainstorm
        </button>
    </div>

    <div class="ai-chat-container">
        <div class="chat-messages" id="chatMessages">
            <div class="welcome-message">
                <div class="ai-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <h3>Hello {{ auth()->user()->first_name }}!</h3>
                <p>I'm your SocialBook AI assistant. I'm here to help with creative writing, answer questions, brainstorm ideas, and have engaging conversations. What would you like to explore today?</p>
            </div>
        </div>

        <div class="typing-indicator" id="typingIndicator">
            <span>AI is thinking</span>
            <div class="typing-dots">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="chat-input-container">
            <textarea class="chat-input" id="chatInput" placeholder="Type your message here..." rows="1"></textarea>
            <button class="send-button" id="sendButton" type="button">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('sendButton');
    const typingIndicator = document.getElementById('typingIndicator');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Auto-resize textarea
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Send message on Enter (but allow Shift+Enter for new line)
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Send button click
    sendButton.addEventListener('click', sendMessage);

    // Quick message function
    window.quickMessage = function(message) {
        chatInput.value = message;
        chatInput.focus();
        // Auto-resize after setting value
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 120) + 'px';
        sendMessage();
    };

    function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        // Clear input and disable send button
        chatInput.value = '';
        chatInput.style.height = 'auto';
        sendButton.disabled = true;

        // Remove welcome message if it exists
        const welcomeMessage = document.querySelector('.welcome-message');
        if (welcomeMessage) {
            welcomeMessage.style.opacity = '0';
            welcomeMessage.style.transform = 'translateY(-20px)';
            setTimeout(() => welcomeMessage.remove(), 300);
        }

        // Add user message
        addMessage(message, 'user');

        // Show typing indicator
        showTyping();

        // Send to AI
        fetch('/ai/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            hideTyping();
            sendButton.disabled = false;
            
            if (data.success) {
                addMessage(data.message, 'ai', data.timestamp);
            } else {
                addMessage('Sorry, I encountered an error. Please try again.', 'ai');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hideTyping();
            sendButton.disabled = false;
            addMessage('Sorry, I\'m currently unavailable. Please try again later.', 'ai');
        });
    }

    function addMessage(text, type, timestamp = null) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        
        let timeStr = timestamp || new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        messageDiv.innerHTML = `
            <div>${text}</div>
            <div class="message-time">${timeStr}</div>
        `;

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTyping() {
        typingIndicator.style.display = 'flex';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTyping() {
        typingIndicator.style.display = 'none';
    }

    // Focus input on load
    chatInput.focus();
});
</script>

@endsection