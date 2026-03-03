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
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 16px;
}

.page-header {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0 0 8px 0;
}

.page-subtitle {
    color: #65676b;
    font-size: 16px;
    margin: 0;
}

.search-filters {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.filter-form {
    display: flex;
    gap: 16px;
    align-items: center;
    flex-wrap: wrap;
}

.form-control {
    border: 2px solid #e4e6ea;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 15px;
    font-family: inherit;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #1877f2;
}

.search-input {
    flex: 1;
    min-width: 250px;
}

.category-select {
    min-width: 180px;
}

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
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 24px;
}

.group-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s;
    cursor: pointer;
}

.group-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.group-cover {
    height: 180px;
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
    padding: 20px;
}

.group-name {
    font-size: 20px;
    font-weight: 700;
    color: #1c1e21;
    margin: 0 0 8px 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.group-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 14px;
    color: #65676b;
}

.privacy-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.privacy-public { background: #d4edda; color: #155724; }
.privacy-closed { background: #fff3cd; color: #856404; }
.privacy-secret { background: #f8d7da; color: #721c24; }

.group-description {
    color: #1c1e21;
    line-height: 1.4;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #65676b;
}

.member-count {
    display: flex;
    align-items: center;
    gap: 4px;
}

.category-tag {
    background: #f0f2f5;
    color: #1c1e21;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 32px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #65676b;
}

.empty-state i {
    font-size: 80px;
    margin-bottom: 20px;
    color: #e4e6ea;
}

@media screen and (max-width: 768px) {
    .filter-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-input,
    .category-select {
        min-width: auto;
    }
    
    .groups-grid {
        grid-template-columns: 1fr;
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
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Discover Groups</h1>
        <p class="page-subtitle">Find and join groups that match your interests</p>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters">
        <form method="GET" action="{{ route('groups.discover') }}" class="filter-form">
            <input type="text" 
                   name="search" 
                   class="form-control search-input" 
                   placeholder="Search groups..." 
                   value="{{ request('search') }}">
            
            <select name="category" class="form-control category-select">
                <option value="">All Categories</option>
                @foreach($categories as $value)
                    <option value="{{ $value }}" 
                            {{ request('category') === $value ? 'selected' : '' }}>
                        {{ ucfirst($value) }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>

    <!-- Groups Grid -->
    @if($groups->count() > 0)
        <div class="groups-grid">
            @foreach($groups as $group)
                <div class="group-card" onclick="location.href='{{ route('groups.show', $group) }}'">
                    <div class="group-cover">
                        @if($group->cover_image)
                            <img src="{{ $group->cover_image_url }}" alt="Group Cover">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1877f2, #42a5f5);">
                                <i class="fas fa-users" style="font-size: 48px; color: white;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="group-info">
                        <h3 class="group-name">{{ $group->name }}</h3>
                        
                        <div class="group-meta">
                            <span class="privacy-badge privacy-{{ $group->privacy }}">
                                <i class="fas fa-{{ $group->privacy === 'public' ? 'globe' : ($group->privacy === 'closed' ? 'lock' : 'eye-slash') }}"></i>
                                {{ $group->privacy_label }}
                            </span>
                            
                            @if($group->category)
                                <span class="category-tag">
                                    <i class="fas fa-tag"></i>
                                    {{ ucfirst(str_replace('_', ' ', $group->category)) }}
                                </span>
                            @endif
                        </div>
                        
                        @if($group->description)
                            <div class="group-description">{{ $group->description }}</div>
                        @endif
                        
                        <div class="group-stats">
                            <div class="member-count">
                                <i class="fas fa-users"></i>
                                <span>{{ number_format($group->member_count) }} members</span>
                            </div>
                            
                            @if($group->admin)
                                <div style="font-size: 13px;">
                                    by {{ $group->admin->first_name }} {{ $group->admin->last_name }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($groups->hasPages())
            <div class="pagination-wrapper">
                {{ $groups->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3 style="margin: 0 0 16px 0; color: #1c1e21; font-size: 24px;">No groups found</h3>
            <p style="margin: 0; font-size: 16px;">
                @if(request('search') || request('category'))
                    Try adjusting your search terms or filters
                @else
                    No groups are available to discover at the moment
                @endif
            </p>
        </div>
    @endif
</div>

@endsection