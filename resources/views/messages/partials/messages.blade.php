{{-- resources/views/messages/partials/messages.blade.php --}}
@php
    $currentUser = auth()->user();
    $groupedMessages = $messages->groupBy(function($message) {
        return $message->created_at->format('Y-m-d');
    });
@endphp

@foreach($groupedMessages as $date => $dayMessages)
    <!-- Date separator -->
    <div style="text-align: center; margin: 20px 0;">
        <span style="background: #e4e6ea; padding: 4px 12px; border-radius: 12px; font-size: 12px; color: #65676b; font-weight: 500;">
            @if($date === now()->format('Y-m-d'))
                Today
            @elseif($date === now()->subDay()->format('Y-m-d'))
                Yesterday
            @else
                {{ \Carbon\Carbon::parse($date)->format('M j, Y') }}
            @endif
        </span>
    </div>

    @php
        $lastSenderId = null;
        $lastTime = null;
    @endphp

    @foreach($dayMessages as $message)
        @php
            $isSent = $message->sender_id === $currentUser->id;
            $showAvatar = $lastSenderId !== $message->sender_id;
            $showTime = !$lastTime || $lastTime->diffInMinutes($message->created_at) >= 5;
            $lastSenderId = $message->sender_id;
            $lastTime = $message->created_at;
        @endphp

        <div class="message-item {{ $isSent ? 'sent' : 'received' }}" style="margin-bottom: {{ $showTime ? '12px' : '2px' }};">
            @if(!$isSent && $showAvatar)
                <img src="{{ $message->sender->profile_picture 
                    ? asset('uploads/profile_pictures/' . $message->sender->profile_picture) 
                    : asset('images/default.png') }}" 
                     alt="Profile" class="message-avatar">
            @elseif(!$isSent)
                <div style="width: 28px;"></div>
            @endif

            <div class="message-content">
                <div class="message-bubble">
                    {{ $message->message }}
                </div>
                
                @if($showTime)
                    <div class="message-time">
                        {{ $message->created_at->format('g:i A') }}
                        @if($isSent && $message->isRead())
                            <i class="fas fa-check-circle" style="color: #42a5f5; margin-left: 2px;" title="Read"></i>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endforeach
@endforeach