{{-- resources/views/groups/index.blade.php --}}
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

.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 16px;
}

.group-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    margin-top: 20px;
}

.group-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: all 0.2s;
    cursor: pointer;
}

.group-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.group-cover {
    height: 120px;
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
    padding: 16px;
}

.group-name {
    font-size: 16px;
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 4px;
}

.group-meta {
    font-size: 13px;
    color: #65676b;
    margin-bottom: 8px;
}

.group-description {
    font-size: 14px;
    color: #1c1e21;
    line-height: 1.4;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.privacy-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}

.privacy-public { background: #d4edda; color: #155724; }
.privacy-closed { background: #fff3cd; color: #856404; }
.privacy-secret { background: #f8d7da; color: #721c24; }

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
    display: inline-block;
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
    padding: 8px 16px;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary:hover {
    background: #e4e6ea;
    transform: translateY(-1px);
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

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1c1e21;
    margin: 0;
}

@media screen and (max-width: 1024px) {
    .shell {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .left-sidebar {
        position: relative;
        top: 0;
    }
    
    .group-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
}
</style>

<!-- Topbar -->
<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="search">
        <input type="text" placeholder="Search groups..." id="group-search" autocomplete="off">
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
    <!-- Left Sidebar -->
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
            <li class="{{ request()->routeIs('groups*') ? 'active' : '' }}">
                <a href="{{ route('groups.index') }}">
                    <i class="fas fa-users"></i> Groups
                </a>
            </li>
            <li class="{{ request()->routeIs('marketplace*') ? 'active' : '' }}">
                <a href="{{ route('marketplace.index') }}">
                    <i class="fas fa-store"></i> Marketplace
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

    <!-- Main Content -->
    <div class="content-area">
        <!-- Header -->
        <div class="card">
            <div class="section-header">
                <h2 style="margin: 0; color: #1c1e21; font-size: 24px;">
                    <i class="fas fa-users" style="margin-right: 12px; color: #1877f2;"></i>
                    Groups
                </h2>
                <a href="{{ route('groups.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Create Group
                </a>
            </div>
            
            <!-- Quick Actions -->
            <div style="display: flex; gap: 12px; margin-top: 16px; flex-wrap: wrap;">
                <a href="{{ route('groups.discover') }}" class="btn-secondary">
                    <i class="fas fa-search"></i> Discover Groups
                </a>
                <button class="btn-secondary" onclick="showCreateGroupModal()">
                    <i class="fas fa-plus-circle"></i> Start a Group
                </button>
            </div>
        </div>

        <!-- My Groups Section -->
       {{-- Updated group card section with proper image handling --}}

<!-- Replace your existing group card sections with this fixed version -->

<!-- My Groups Section -->
@if($myGroups->count() > 0)
<div class="card">
    <div class="section-header">
        <h3 class="section-title">Your Groups</h3>
        <a href="{{ route('groups.my-groups') }}" style="color: #1877f2; text-decoration: none; font-size: 14px;">See All</a>
    </div>
    
    <div class="group-grid">
        @foreach($myGroups as $group)
        <div class="group-card" onclick="location.href='{{ route('groups.show', $group) }}'">
            <div class="group-cover">
                @if($group->cover_image && file_exists(public_path('uploads/group_covers/' . $group->cover_image)))
                    <img src="{{ asset('uploads/group_covers/' . $group->cover_image) }}" 
                         alt="Group Cover"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);\'><i class=\'fas fa-users\' style=\'font-size: 32px; color: white;\'></i></div>';">
                @else
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);">
                        <i class="fas fa-users" style="font-size: 32px; color: white;"></i>
                    </div>
                @endif
            </div>
            <div class="group-info">
                <div class="privacy-badge privacy-{{ $group->privacy }}">
                    {{ $group->privacy_label ?? ucfirst($group->privacy) }}
                </div>
                <div class="group-name">{{ $group->name }}</div>
                <div class="group-meta">
                    <i class="fas fa-users"></i> {{ number_format($group->member_count ?? $group->members_count ?? $group->members->count()) }} members
                    @if($group->pivot && $group->pivot->role !== 'member')
                        • <span style="color: #1877f2; font-weight: 600;">{{ ucfirst($group->pivot->role) }}</span>
                    @endif
                </div>
                @if($group->description)
                <div class="group-description">{{ $group->description }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Suggested Groups Section -->
@if($suggestedGroups->count() > 0)
<div class="card">
    <div class="section-header">
        <h3 class="section-title">Suggested for You</h3>
        <a href="{{ route('groups.discover') }}" style="color: #1877f2; text-decoration: none; font-size: 14px;">See More</a>
    </div>
    
    <div class="group-grid">
        @foreach($suggestedGroups as $group)
        <div class="group-card" onclick="location.href='{{ route('groups.show', $group) }}'">
            <div class="group-cover">
               @if($group->cover_image && file_exists(public_path('uploads/group_covers/' . $group->cover_image)))
    <img src="{{ asset('uploads/group_covers/' . $group->cover_image) }}" alt="Group Cover">

                @else
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);">
                        <i class="fas fa-users" style="font-size: 32px; color: white;"></i>
                    </div>
                @endif
            </div>
            <div class="group-info">
                <div class="privacy-badge privacy-{{ $group->privacy }}">
                    {{ $group->privacy_label ?? ucfirst($group->privacy) }}
                </div>
                <div class="group-name">{{ $group->name }}</div>
                <div class="group-meta">
                    <i class="fas fa-users"></i> {{ number_format($group->member_count ?? $group->members_count ?? $group->members->count()) }} members
                    @if($group->admin)
                        • <i class="fas fa-user"></i> {{ $group->admin->first_name ?? 'Admin' }}
                    @endif
                </div>
                @if($group->description)
                <div class="group-description">{{ $group->description }}</div>
                @endif
                <div style="margin-top: 12px;">
                    <button class="btn-primary join-group-btn" data-group-id="{{ $group->id }}" onclick="event.stopPropagation();">
                        <i class="fas fa-plus"></i> Join Group
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif



<!-- Popular Groups Widget - Fixed version -->
@if($popularGroups->count() > 0)
<div class="card">
    <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
        Popular Groups
    </h3>
    <div style="display: flex; flex-direction: column; gap: 12px;">
        @foreach($popularGroups as $group)
        <div style="display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 8px; cursor: pointer; transition: background 0.2s;"
             onclick="location.href='{{ route('groups.show', $group) }}'"
             onmouseover="this.style.background='#f8f9fa'"
             onmouseout="this.style.background='transparent'">
            <div style="width: 40px; height: 40px; border-radius: 8px; background: linear-gradient(45deg, #1877f2, #42a5f5); display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                @if($group->cover_image && file_exists(public_path('uploads/group_covers/' . $group->cover_image)))
                    <img src="{{ asset('uploads/group_covers/' . $group->cover_image) }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\'fas fa-users\' style=\'color: white; font-size: 16px;\'></i>';">
                @else
                    <i class="fas fa-users" style="color: white; font-size: 16px;"></i>
                @endif
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 600; color: #1c1e21; font-size: 14px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $group->name }}
                </div>
                <div style="font-size: 12px; color: #65676b;">
                    <i class="fas fa-users"></i> {{ number_format($group->member_count ?? $group->members_count ?? $group->members->count()) }} members
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

        <!-- Suggested Groups Section -->
        @if($suggestedGroups->count() > 0)
        <div class="card">
            <div class="section-header">
                <h3 class="section-title">Suggested for You</h3>
                <a href="{{ route('groups.discover') }}" style="color: #1877f2; text-decoration: none; font-size: 14px;">See More</a>
            </div>
            
            <div class="group-grid">
                @foreach($suggestedGroups as $group)
                <div class="group-card" onclick="location.href='{{ route('groups.show', $group) }}'">
                    <div class="group-cover">
                        @if($group->cover_image)
                            <img src="{{ $group->cover_image_url }}" alt="Group Cover">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);">
                                <i class="fas fa-users" style="font-size: 32px; color: white;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="group-info">
                        <div class="privacy-badge privacy-{{ $group->privacy }}">
                            {{ $group->privacy_label }}
                        </div>
                        <div class="group-name">{{ $group->name }}</div>
                        <div class="group-meta">
                            <i class="fas fa-users"></i> {{ number_format($group->member_count) }} members
                            • <i class="fas fa-user"></i> {{ $group->admin->first_name }}
                        </div>
                        @if($group->description)
                        <div class="group-description">{{ $group->description }}</div>
                        @endif
                        <div style="margin-top: 12px;">
                            <button class="btn-primary join-group-btn" data-group-id="{{ $group->id }}" onclick="event.stopPropagation();">
                                <i class="fas fa-plus"></i> Join Group
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($myGroups->count() === 0 && $suggestedGroups->count() === 0)
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 24px;">Find Your Community</h3>
                <p style="margin: 0 0 24px 0; font-size: 16px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Connect with people who share your interests. Join existing groups or create your own community.
                </p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('groups.discover') }}" class="btn-primary">
                        <i class="fas fa-search"></i> Discover Groups
                    </a>
                    <a href="{{ route('groups.create') }}" class="btn-secondary">
                        <i class="fas fa-plus"></i> Create Group
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Sidebar -->
    <div style="position: sticky; top: 80px; height: fit-content;">
        <div class="card">
            <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                Group Categories
            </h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach($categories as $categoryName => $count)
                <a href="{{ route('groups.discover', ['category' => strtolower(str_replace(['&', ' '], ['', '_'], $categoryName))]) }}" 
                   style="text-decoration: none;">
                    <div style="padding: 12px; background: #f8f9fa; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                         onmouseover="this.style.background='#e9ecef'; this.style.transform='translateX(2px)'" 
                         onmouseout="this.style.background='#f8f9fa'; this.style.transform='translateX(0)'">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                @php
                                    $icons = [
                                        'Gaming' => 'fas fa-gamepad',
                                        'Fitness & Health' => 'fas fa-dumbbell',
                                        'Education' => 'fas fa-book',
                                        'Music & Arts' => 'fas fa-music',
                                        'Professional' => 'fas fa-briefcase',
                                        'Technology' => 'fas fa-laptop-code'
                                    ];
                                @endphp
                                <i class="{{ $icons[$categoryName] ?? 'fas fa-folder' }}" style="margin-right: 8px; color: #1877f2;"></i>
                                <strong style="color: #1c1e21;">{{ $categoryName }}</strong>
                            </div>
                            <span style="font-size: 12px; color: #65676b; background: white; padding: 2px 8px; border-radius: 12px;">
                                {{ $count }} groups
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        
        <!-- Popular Groups Widget -->
        @if($popularGroups->count() > 0)
        <div class="card">
            <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                Popular Groups
            </h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($popularGroups as $group)
                <div style="display: flex; align-items: center; gap: 10px; padding: 8px; border-radius: 8px; cursor: pointer; transition: background 0.2s;"
                     onclick="location.href='{{ route('groups.show', $group) }}'"
                     onmouseover="this.style.background='#f8f9fa'"
                     onmouseout="this.style.background='transparent'">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: linear-gradient(45deg, #1877f2, #42a5f5); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        @if($group->cover_image)
                            <img src="{{ $group->cover_image_url }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        @else
                            <i class="fas fa-users" style="color: white; font-size: 16px;"></i>
                        @endif
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 600; color: #1c1e21; font-size: 14px; margin-bottom: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $group->name }}
                        </div>
                        <div style="font-size: 12px; color: #65676b;">
                            <i class="fas fa-users"></i> {{ number_format($group->member_count) }} members
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Join Group functionality
    document.querySelectorAll('.join-group-btn').forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.getAttribute('data-group-id');
            const originalText = this.innerHTML;
            
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Joining...';
            
            fetch(`/groups/${groupId}/join`, {
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
                    this.innerHTML = '<i class="fas fa-check"></i> Joined';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-secondary');
                    showNotification(data.message, 'success');
                    
                    // Refresh page after 1 second to show updated groups
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
    });
    
    // Search functionality
    const searchInput = document.getElementById('group-search');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Redirect to discover page with search query
                    window.location.href = `/groups/discover?search=${encodeURIComponent(query)}`;
                }, 500);
            }
        });
    }
    
    // Notification system
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

function showCreateGroupModal() {
    // Simple redirect for now - you can implement a modal later
    window.location.href = '{{ route("groups.create") }}';
}
</script>

@endsection