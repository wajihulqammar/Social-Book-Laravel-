{{-- resources/views/groups/members.blade.php --}}
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
    max-width: 900px;
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

.members-grid {
    display: grid;
    gap: 16px;
}

.member-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    border: 1px solid #e4e6ea;
    border-radius: 12px;
    transition: all 0.2s;
}

.member-card:hover {
    border-color: #1877f2;
    box-shadow: 0 2px 8px rgba(24, 119, 242, 0.1);
}

.member-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e4e6ea;
    flex-shrink: 0;
}

.member-info {
    flex: 1;
    min-width: 0;
}

.member-name {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 4px;
    font-size: 16px;
}

.member-name a {
    color: #1c1e21;
    text-decoration: none;
}

.member-name a:hover {
    color: #1877f2;
    text-decoration: underline;
}

.member-role {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 8px;
}

.role-admin {
    background: #fff3cd;
    color: #856404;
}

.role-moderator {
    background: #d1ecf1;
    color: #0c5460;
}

.role-member {
    background: #f8f9fa;
    color: #495057;
}

.member-joined {
    font-size: 13px;
    color: #65676b;
}

.member-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    background: #f0f2f5;
    border: none;
    border-radius: 6px;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 14px;
    color: #1c1e21;
    display: flex;
    align-items: center;
    gap: 6px;
}

.dropdown-toggle:hover {
    background: #e4e6ea;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border: 1px solid #e4e6ea;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 160px;
    z-index: 1000;
    display: none;
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 8px 16px;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
    color: #1c1e21;
    text-decoration: none;
}

.dropdown-item:hover {
    background: #f8f9fa;
}

.dropdown-item.text-danger {
    color: #dc3545;
}

.dropdown-item.text-primary {
    color: #1877f2;
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

.search-box {
    position: relative;
    margin-bottom: 24px;
}

.search-box input {
    width: 100%;
    border: 2px solid #e4e6ea;
    border-radius: 50px;
    padding: 12px 16px 12px 40px;
    font-size: 15px;
    background: #f8f9fa;
    transition: all 0.2s;
}

.search-box input:focus {
    outline: none;
    border-color: #1877f2;
    background: #fff;
}

.search-box::before {
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

@media screen and (max-width: 768px) {
    .member-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        text-align: center;
    }
    
    .member-actions {
        width: 100%;
        justify-content: center;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
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
        <span>Members</span>
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
                <h1>Group Members</h1>
                <p>{{ number_format($members->total()) }} members in {{ $group->name }}</p>
            </div>
        </div>

        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number">{{ $members->total() }}</span>
                <span class="stat-label">Total Members</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $members->where('pivot.role', 'admin')->count() }}</span>
                <span class="stat-label">Admins</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $members->where('pivot.role', 'moderator')->count() }}</span>
                <span class="stat-label">Moderators</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $members->where('pivot.role', 'member')->count() }}</span>
                <span class="stat-label">Members</span>
            </div>
        </div>

        <div class="search-box">
            <input type="text" id="member-search" placeholder="Search members..." autocomplete="off">
        </div>

        @if($members->count() > 0)
            <div class="members-grid" id="members-container">
                @foreach($members as $member)
                <div class="member-card" data-member-name="{{ strtolower($member->first_name . ' ' . $member->last_name) }}">
                    <img src="{{ $member->profile_picture_url }}" alt="Profile" class="member-avatar">
                    
                    <div class="member-info">
                        <div class="member-name">
                            <a href="{{ route('profile.show', $member) }}">
                                {{ $member->first_name }} {{ $member->last_name }}
                            </a>
                        </div>
                        
                        <div class="member-role role-{{ $member->pivot->role }}">
                            @if($member->pivot->role === 'admin' || $member->id === $group->admin_id)
                                <i class="fas fa-crown"></i> Admin
                            @elseif($member->pivot->role === 'moderator')
                                <i class="fas fa-shield-alt"></i> Moderator
                            @else
                                <i class="fas fa-user"></i> Member
                            @endif
                        </div>
                        
                        <div class="member-joined">
                            <i class="fas fa-calendar"></i>
                            Joined {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('M j, Y') : 'Unknown' }}
                        </div>
                    </div>
                    
                    @if($group->isAdmin(auth()->id()) && $member->id !== auth()->id() && $member->id !== $group->admin_id)
                    <div class="member-actions">
                        <div class="dropdown">
                            <button class="dropdown-toggle" onclick="toggleDropdown(this)">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                @if($member->pivot->role === 'member')
                                <button class="dropdown-item text-primary" onclick="promoteMember({{ $member->id }}, 'moderator')">
                                    <i class="fas fa-arrow-up"></i> Make Moderator
                                </button>
                                <button class="dropdown-item text-primary" onclick="promoteMember({{ $member->id }}, 'admin')">
                                    <i class="fas fa-crown"></i> Make Admin
                                </button>
                                @elseif($member->pivot->role === 'moderator')
                                <button class="dropdown-item text-primary" onclick="promoteMember({{ $member->id }}, 'admin')">
                                    <i class="fas fa-crown"></i> Make Admin
                                </button>
                                <button class="dropdown-item" onclick="demoteMember({{ $member->id }}, 'member')">
                                    <i class="fas fa-arrow-down"></i> Remove Moderator
                                </button>
                                @endif
                                <button class="dropdown-item text-danger" onclick="removeMember({{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')">
                                    <i class="fas fa-times"></i> Remove from Group
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            @if($members->hasPages())
            <div style="margin-top: 24px; display: flex; justify-content: center;">
                {{ $members->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 20px;">No Members Found</h3>
                <p style="margin: 0 0 24px 0; font-size: 15px;">
                    This group doesn't have any members yet.
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
    
    // Search functionality
    const searchInput = document.getElementById('member-search');
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const memberCards = document.querySelectorAll('.member-card');
        
        memberCards.forEach(card => {
            const memberName = card.getAttribute('data-member-name');
            if (memberName.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Global functions for member management
    window.toggleDropdown = function(button) {
        const dropdown = button.nextElementSibling;
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        
        // Close all other dropdowns
        allDropdowns.forEach(menu => {
            if (menu !== dropdown) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('show');
    };
    
    window.promoteMember = function(userId, role) {
        const action = role === 'admin' ? 'make-admin' : 'make-moderator';
        const message = role === 'admin' ? 'promote this member to admin' : 'promote this member to moderator';
        
        if (confirm(`Are you sure you want to ${message}?`)) {
            fetch(`/groups/{{ $group->id }}/${action}/${userId}`, {
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
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Error promoting member', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error promoting member. Please try again.', 'error');
            });
        }
    };
    
    window.demoteMember = function(userId, role) {
        if (confirm('Are you sure you want to remove moderator privileges?')) {
            // You'll need to add this route and method
            fetch(`/groups/{{ $group->id }}/demote-member/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ role: role })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Error demoting member', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error demoting member. Please try again.', 'error');
            });
        }
    };
    
    window.removeMember = function(userId, memberName) {
        if (confirm(`Are you sure you want to remove ${memberName} from the group?`)) {
            fetch(`/groups/{{ $group->id }}/remove-member/${userId}`, {
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
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(data.message || 'Error removing member', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error removing member. Please try again.', 'error');
            });
        }
    };
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
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