{{-- resources/views/groups/requests.blade.php --}}
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
    max-width: 800px;
    margin: 40px auto;
    padding: 0 16px;
}

.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 24px;
    margin-bottom: 20px;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
    font-size: 14px;
    color: #65676b;
}

.breadcrumb a {
    color: #1877f2;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.page-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.group-avatar {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(45deg, #1877f2, #42a5f5);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.group-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
}

.page-info h1 {
    margin: 0;
    font-size: 24px;
    color: #1c1e21;
    font-weight: 700;
}

.page-info p {
    margin: 4px 0 0 0;
    color: #65676b;
    font-size: 15px;
}

.request-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    border: 1px solid #e4e6ea;
    border-radius: 12px;
    margin-bottom: 16px;
    transition: all 0.2s;
}

.request-item:hover {
    border-color: #1877f2;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.1);
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 4px;
    font-size: 16px;
}

.user-name a {
    color: #1c1e21;
    text-decoration: none;
}

.user-name a:hover {
    color: #1877f2;
    text-decoration: underline;
}

.request-time {
    font-size: 13px;
    color: #65676b;
    margin-bottom: 8px;
}

.request-message {
    font-size: 14px;
    color: #1c1e21;
    line-height: 1.4;
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 8px;
    border-left: 3px solid #1877f2;
}

.request-actions {
    display: flex;
    gap: 8px;
}

.btn-approve {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-approve:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.btn-reject {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.btn-reject:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
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
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #e4e6ea;
    transform: translateY(-1px);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #65676b;
}

.empty-state i {
    font-size: 64px;
    margin-bottom: 16px;
    color: #e4e6ea;
}

.stats-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8f9fa;
    padding: 16px 20px;
    border-radius: 8px;
    margin-bottom: 24px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: #1c1e21;
    display: block;
}

.stat-label {
    font-size: 12px;
    color: #65676b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

@media screen and (max-width: 768px) {
    .request-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .request-actions {
        width: 100%;
        justify-content: space-between;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        text-align: center;
    }
    
    .stats-bar {
        flex-direction: column;
        gap: 16px;
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
    <div class="breadcrumb">
        <a href="{{ route('groups.index') }}">Groups</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a>
        <i class="fas fa-chevron-right"></i>
        <span>Join Requests</span>
    </div>

    <div class="card">
        <div class="page-header">
            <div class="group-avatar">
                @if($group->cover_image)
                    <img src="{{ $group->cover_image_url }}" alt="Group">
                @else
                    <i class="fas fa-users"></i>
                @endif
            </div>
            <div class="page-info">
                <h1>Join Requests</h1>
                <p>Manage membership requests for {{ $group->name }}</p>
            </div>
        </div>

        @if($requests->count() > 0)
            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-number">{{ $requests->total() }}</span>
                    <span class="stat-label">Pending Requests</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ number_format($group->member_count) }}</span>
                    <span class="stat-label">Current Members</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $group->privacy_label }}</span>
                    <span class="stat-label">Group Type</span>
                </div>
            </div>

            <div class="requests-list">
                @foreach($requests as $request)
                <div class="request-item" id="request-{{ $request->id }}">
                    <img src="{{ $request->user->profile_picture_url }}" alt="Profile" class="user-avatar">
                    
                    <div class="user-info">
                        <div class="user-name">
                            <a href="{{ route('profile.show', $request->user) }}">
                                {{ $request->user->first_name }} {{ $request->user->last_name }}
                            </a>
                        </div>
                        <div class="request-time">
                            <i class="fas fa-clock"></i>
                            Requested {{ $request->requested_at->diffForHumans() }}
                        </div>
                        @if($request->message)
                        <div class="request-message">
                            {{ $request->message }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="request-actions">
                        <button class="btn-approve" onclick="approveRequest({{ $request->id }})">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button class="btn-reject" onclick="rejectRequest({{ $request->id }})">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @if($requests->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: center;">
                {{ $requests->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-user-check"></i>
                <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 20px;">No Pending Requests</h3>
                <p style="margin: 0 0 24px 0; font-size: 15px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    There are currently no pending join requests for this group. New requests will appear here for your review.
                </p>
                <a href="{{ route('groups.show', $group) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Group
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    window.approveRequest = function(requestId) {
        if (confirm('Are you sure you want to approve this request?')) {
            const button = document.querySelector(`#request-${requestId} .btn-approve`);
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving...';
            
            fetch(`/groups/{{ $group->id }}/approve-request/${requestId}`, {
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
                    // Remove the request item from the list
                    document.getElementById(`request-${requestId}`).style.opacity = '0.5';
                    setTimeout(() => {
                        document.getElementById(`request-${requestId}`).remove();
                        checkEmptyState();
                    }, 1000);
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                    showNotification(data.message || 'Error approving request', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = originalText;
                showNotification('Error approving request. Please try again.', 'error');
            });
        }
    };
    
    window.rejectRequest = function(requestId) {
        if (confirm('Are you sure you want to reject this request?')) {
            const button = document.querySelector(`#request-${requestId} .btn-reject`);
            const originalText = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
            
            fetch(`/groups/{{ $group->id }}/reject-request/${requestId}`, {
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
                    // Remove the request item from the list
                    document.getElementById(`request-${requestId}`).style.opacity = '0.5';
                    setTimeout(() => {
                        document.getElementById(`request-${requestId}`).remove();
                        checkEmptyState();
                    }, 1000);
                } else {
                    button.disabled = false;
                    button.innerHTML = originalText;
                    showNotification(data.message || 'Error rejecting request', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                button.innerHTML = originalText;
                showNotification('Error rejecting request. Please try again.', 'error');
            });
        }
    };
    
    function checkEmptyState() {
        const requestsList = document.querySelector('.requests-list');
        if (requestsList && requestsList.children.length === 0) {
            location.reload(); // Reload to show empty state
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
});
</script>

@endsection