{{-- resources/views/messages/partials/message.blade.php --}}
@php
    $isSent = $message->sender_id === auth()->id();
@endphp

<div class="message-item {{ $isSent ? 'sent' : 'received' }}" style="margin-bottom: 12px;">
    @if(!$isSent)
        <img src="{{ $message->sender->profile_picture 
            ? asset('uploads/profile_pictures/' . $message->sender->profile_picture) 
            : asset('images/default.png') }}" 
             alt="Profile" class="message-avatar">
    @endif

    <div class="message-content">
        <div class="message-bubble">
            {{ $message->message }}
        </div>
        
        <div class="message-time">
            {{ $message->created_at->format('g:i A') }}
            @if($isSent && $message->isRead())
                <i class="fas fa-check-circle" style="color: #42a5f5; margin-left: 2px;" title="Read"></i>
            @endif
        </div>
    </div>
</div>