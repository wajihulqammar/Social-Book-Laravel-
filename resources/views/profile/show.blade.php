@extends('layouts.app')

@section('content')
<!-- Add CSRF token meta tag -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<head> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>

<style>
body {
    background: #f0f2f5;
    font-family: Arial, sans-serif;
}

.cover {
    background: #4267B2;
    height: 200px;
    position: relative;
}

.avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid white;
    position: absolute;
    bottom: -75px;
    left: 50%;
    transform: translateX(-50%);
    object-fit: cover;
}

.profile-header {
    text-align: center;
    margin-top: 90px;
}

.profile-header h1 {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
}

.profile-header p {
    color: #606770;
    margin: 5px 0 10px 0;
}

.edit-btn {
    background: #1877F2;
    color: white;
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}

.nav-tabs {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    border-bottom: 1px solid #ddd;
    gap: 20px;
}

.nav-tabs a {
    padding: 10px 15px;
    text-decoration: none;
    color: #606770;
    font-weight: 500;
    cursor: pointer;
}

.nav-tabs a.active {
    color: #1877F2;
    border-bottom: 3px solid #1877F2;
}

.nav-tabs a:hover {
    color: #1877F2;
    background-color: rgba(24, 119, 242, 0.1);
    border-radius: 6px;
}

.container {
    max-width: 1000px;
    margin: 30px auto;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: flex;
    gap: 20px;
}

.sidebar {
    width: 35%;
}

.main {
    width: 65%;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.card h2 {
    font-size: 16px;
    margin-bottom: 8px;
}

/* Photos grid */
.photos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 6px;
}

.photos-grid img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
}

/* Friends grid */
.friends-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.friends-grid a {
    text-decoration: none;
    color: #111;
    text-align: center;
    font-size: 13px;
}

.friends-grid img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 4px;
}

/* Large Friends List for Friends Tab */
.friends-large-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
    padding: 10px 0;
}

.friend-card {
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.2s;
}

.friend-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.friend-card img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.friend-card h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #1877F2;
}

.friend-card a {
    text-decoration: none;
    color: inherit;
}

/* About Tab Styles */
.about-section {
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.about-section-header {
    background: #f7f8fa;
    padding: 15px 20px;
    border-bottom: 1px solid #e4e6ea;
    font-weight: 600;
    font-size: 18px;
    color: #1c1e21;
}

.about-section-content {
    padding: 20px;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f2f5;
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    width: 20px;
    height: 20px;
    margin-right: 15px;
    font-size: 16px;
}

.info-content {
    flex: 1;
}

.info-label {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 2px;
}

.info-value {
    color: #65676b;
    font-size: 14px;
}

.add-info-btn {
    background: #f0f2f5;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    color: #1877f2;
    font-weight: 600;
    width: 100%;
    margin-top: 10px;
}

.add-info-btn:hover {
    background: #e4e6ea;
}

/* Tab Content */
.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Post composer */
.composer {
    background: white;
    padding: 12px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.composer-header {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
}

.composer-header img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.composer-header textarea {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 12px;
    resize: none;
    font-size: 14px;
    outline: none;
}

.composer-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}

.upload-btn {
    color: #555;
    font-size: 14px;
    cursor: pointer;
}

.upload-btn input {
    display: none;
}

.composer-footer button {
    background: #1877F2;
    color: white;
    border: none;
    padding: 6px 14px;
    border-radius: 20px;
    cursor: pointer;
}

/* Posts */
.post {
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.post-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.post-header img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.post-header .name {
    font-weight: 600;
    margin: 0;
}

.post-body {
    margin: 10px 0;
}

.post img {
    max-width: 100%;
    border-radius: 6px;
    margin-top: 8px;
}

.post-footer {
    display: flex;
    gap: 15px;
    margin-top: 8px;
    font-size: 14px;
    color: #606770;
}

.post-footer button {
    background: none;
    border: none;
    cursor: pointer;
    color: #606770;
}

.post-footer button:hover {
    color: #1877F2;
}

.composer {
    background: #fff;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 20px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    max-width: 100%;
    font-family: Arial, sans-serif;
}

/* Header */
.composer-header {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
}

.composer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.composer textarea {
    width: 100%;
    border: none;
    resize: none;
    outline: none;
    font-size: 15px;
    background: #f0f2f5;
    border-radius: 20px;
    padding: 10px 15px;
    box-sizing: border-box;
}

/* Actions */
.composer-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #e4e6eb;
    padding-top: 10px;
}

.action-btn {
    background: #f0f2f5;
    border: none;
    padding: 8px 14px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s;
}

.action-btn:hover {
    background: #e4e6eb;
}

.post-btn {
    background: #1877f2;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    font-size: 14px;
}

.post-btn:hover {
    background: #166fe5;
}

/* Dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle::after {
    content: " ▼";
    font-size: 12px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-top: 5px;
    z-index: 10;
    min-width: 150px;
}

.dropdown-menu button {
    display: block;
    width: 100%;
    background: none;
    border: none;
    padding: 8px 12px;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
}

.dropdown-menu button:hover {
    background: #f0f2f5;
}

.dropdown.show .dropdown-menu {
    display: block;
}

.post-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #ddd;
    padding: 6px 0;
    margin-top: 8px;
}

.post-actions form, .post-actions button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px;
    padding: 4px 8px;
    margin: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
    transition: background 0.2s;
}

.post-actions button:hover, .post-actions form button:hover {
    background: #f2f2f2;
    border-radius: 4px;
}

/* Comment styles */
.comments-list {
    margin-top: 10px;
}

.comment-item {
    padding: 8px 0;
    border-bottom: 1px solid #f0f2f5;
    font-size: 14px;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-form {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    align-items: center;
}

.comment-form input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 20px;
    outline: none;
    font-size: 14px;
}

.comment-form button {
    background: #1877F2;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 15px;
    cursor: pointer;
    font-size: 14px;
}

.comment-form button:hover {
    background: #166fe5;
}

.post-actions {
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid #e4e6ea;
    margin-top: 8px;
    background: white;
}

.post-actions button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    color: #65676b;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.2s ease;
    flex: 1;
    justify-content: center;
}

.post-actions button:hover {
    background-color: #f2f3f4;
}

.like-btn {
    color: #65676b;
}

.like-btn.liked {
    color: #1877f2;
}

/* Custom icons to match the design */
.like-btn::before {
    content: "👍";
    font-size: 14px;
}

.comment-toggle-btn::before {
    content: "💬";  
    font-size: 14px;
}

.share-btn::before {
    content: "↗";
    font-size: 14px;
    font-weight: bold;
}

.post-actions button .count {
    color: #65676b;
    font-weight: normal;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.edit-btn-small {
    background: #f0f2f5;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    color: #65676b;
}

.edit-btn-small:hover {
    background: #e4e6ea;
}

.edit-form {
    margin-top: 8px;
}

.edit-form textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    resize: vertical;
    min-height: 60px;
    font-family: inherit;
}

.edit-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.save-btn {
    background: #1877f2;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
}

.cancel-btn {
    background: #e4e6ea;
    color: #65676b;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
}

.save-btn:hover {
    background: #166fe5;
}

.cancel-btn:hover {
    background: #d8dadf;
}

/* Friends sidebar for friends tab */
.friends-sidebar {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    height: fit-content;
}

.friends-search {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 20px;
    margin-bottom: 20px;
    outline: none;
    font-size: 14px;
    box-sizing: border-box;
}

.friends-filter {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.filter-btn {
    background: none;
    border: none;
    text-align: left;
    padding: 12px 15px;
    border-radius: 8px;
    cursor: pointer;
    color: #65676b;
    font-weight: 500;
    font-size: 15px;
    transition: all 0.2s;
}

.filter-btn:hover, .filter-btn.active {
    background: #e7f3ff;
    color: #1877f2;
}
/* Tab Content Layout Fix */
.tab-content {
    display: none;
}

.tab-content.active {
    display: flex;
    gap: 20px;
    width: 100%;
}

/* Posts Tab - Sidebar left, Posts right */
#posts-tab.active .sidebar {
    width: 35%;
    flex-shrink: 0;
}

#posts-tab.active .main {
    width: 65%;
    flex-grow: 1;
}

/* About Tab - Quick info left, About sections right */
#about-tab.active {
    display: flex;
    gap: 20px;
}

#about-tab .sidebar {
    width: 30%;
    flex-shrink: 0;
}

#about-tab .main {
    width: 70%;
    flex-grow: 1;
}

/* Friends Tab - Friends sidebar left, Friends grid right */
#friends-tab.active {
    display: flex;
    gap: 20px;
}

#friends-tab .sidebar {
    width: 30%;
    flex-shrink: 0;
}

#friends-tab .main {
    width: 70%;
    flex-grow: 1;
}

/* Make sure the container doesn't interfere */
.container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 0 20px;
}

/* Ensure proper box-sizing */
.sidebar, .main {
    box-sizing: border-box;
}
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

</style>
<div class="topbar">
    <a href="{{ route('dashboard') }}" class="brand" style="text-decoration: none;">SocialBook</a>
    <div class="search">
        <input type="text" id="user-search" placeholder="Search SocialBook..." autocomplete="off">
        <div id="search-results" style="position:absolute; background:#fff; border:1px solid #ddd; border-radius:6px; width:100%; max-width:420px; display:none; z-index:1000;"></div>
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
<!-- Cover + Profile Pic -->
<div class="cover">
   <img src="{{ $user->profile_picture_url }}" class="avatar" alt="Profile">
</div>

<div class="profile-header">
    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
    <p>{{ $user->bio ?? 'No bio added yet.' }}</p>
    @if(Auth::id() === $user->id)
        <a href="{{ route('profile.edit', $user->id) }}" class="edit-btn">Edit Profile</a>
    @endif
</div>

<!-- Tabs -->
<div class="nav-tabs">
    <a href="#" class="tab-link active" data-tab="posts">Posts</a>
    <a href="#" class="tab-link" data-tab="about">About</a>
    <a href="#" class="tab-link" data-tab="friends">Friends</a>
</div>

<!-- Page Layout -->
<div class="container">
    
    <!-- POSTS TAB CONTENT -->
    <div id="posts-tab" class="tab-content active">
        <!-- Left Sidebar for Posts -->
        <div class="sidebar">
            <!-- Intro -->
            <div class="card">
                <div class="card-header">
                    <h2>Intro</h2>
                    @if(Auth::id() === $user->id)
                        <button class="edit-btn-small" onclick="toggleEdit('bio')">✏️</button>
                    @endif
                </div>
                
                <div id="bio-display" class="editable-content">
                    <p>{{ $user->bio ?? 'No bio added yet.' }}</p>
                </div>
                
                @if(Auth::id() === $user->id)
                    <div id="bio-edit" class="edit-form" style="display: none;">
                        <textarea id="bio-input" maxlength="500">{{ $user->bio }}</textarea>
                        <div class="edit-actions">
                            <button onclick="saveField('bio')" class="save-btn">Save</button>
                            <button onclick="cancelEdit('bio')" class="cancel-btn">Cancel</button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Education -->
            <div class="card">
                <div class="card-header">
                    <h2>Education</h2>
                    @if(Auth::id() === $user->id)
                        <button class="edit-btn-small" onclick="toggleEdit('education')">✏️</button>
                    @endif
                </div>
                
                <div id="education-display" class="editable-content">
                    <p>{{ $user->education ?? 'No education added yet.' }}</p>
                </div>
                
                @if(Auth::id() === $user->id)
                    <div id="education-edit" class="edit-form" style="display: none;">
                        <textarea id="education-input" maxlength="300">{{ $user->education }}</textarea>
                        <div class="edit-actions">
                            <button onclick="saveField('education')" class="save-btn">Save</button>
                            <button onclick="cancelEdit('education')" class="cancel-btn">Cancel</button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Work -->
            <div class="card">
                <div class="card-header">
                    <h2>Work</h2>
                    @if(Auth::id() === $user->id)
                        <button class="edit-btn-small" onclick="toggleEdit('work')">✏️</button>
                    @endif
                </div>
                
                <div id="work-display" class="editable-content">
                    <p>{{ $user->work ?? 'No work added yet.' }}</p>
                </div>
                
                @if(Auth::id() === $user->id)
                    <div id="work-edit" class="edit-form" style="display: none;">
                        <textarea id="work-input" maxlength="300">{{ $user->work }}</textarea>
                        <div class="edit-actions">
                            <button onclick="saveField('work')" class="save-btn">Save</button>
                            <button onclick="cancelEdit('work')" class="cancel-btn">Cancel</button>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card">
                <h2>Photos</h2>
                <div class="photos-grid">
                    @forelse($posts->whereNotNull('image_path')->take(9) as $photo)
                         <img src="{{ $photo->image_url }}" alt="Photo">
                    @empty
                        <p>No photos yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2>Friends</h2>
                <div class="friends-grid">
                    @forelse($friends->take(9) as $friend)
                        <a href="{{ route('profile.show', $friend->id) }}">
                            <img src="{{ $friend->profile_picture ? asset('uploads/profile_pictures/' . $friend->profile_picture) : asset('default.png') }}" alt="Friend">
                            {{ $friend->first_name }}
                        </a>
                    @empty
                        <p>No friends yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Main - Posts -->
        <div class="main">
            <!-- Composer (only owner can see) -->
            @if(Auth::id() === $user->id)
                <div class="composer">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="composer-header">
                            <img src="{{ auth()->user()->profile_picture ? asset('uploads/profile_pictures/' . auth()->user()->profile_picture) : asset('images/default-male.png') }}" alt="Avatar">
                            <textarea name="body" rows="2" placeholder="What's on your mind, {{ $user->first_name }}?"></textarea>
                        </div>
                        <input type="file" name="image" id="imageInput" style="display:none;">
                        <div class="composer-actions">
                            <label for="imageInput" class="action-btn">📷 Photo/Video</label>
                            <div class="dropdown">
                                <button type="button" class="action-btn dropdown-toggle">😊 Feeling/Activity</button>
                                <div class="dropdown-menu">
                                    <button type="button" onclick="insertFeeling('😊 Happy')">😊 Happy</button>
                                    <button type="button" onclick="insertFeeling('😢 Sad')">😢 Sad</button>
                                    <button type="button" onclick="insertFeeling('😡 Angry')">😡 Angry</button>
                                    <button type="button" onclick="insertFeeling('😴 Tired')">😴 Tired</button>
                                </div>
                            </div>
                            <button type="submit" class="post-btn">Post</button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- User Posts -->
            @foreach($posts as $post)
                <div class="post">
                    <div class="post-header">
                        <img src="{{ $post->user->profile_picture ? asset('uploads/profile_pictures/' . $post->user->profile_picture) : asset('default.png') }}" alt="User">
                        <div>
                            <p class="name">{{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                            <span style="font-size:12px; color:#606770;">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if($post->body)
                        <div class="post-body">{{ $post->body }}</div>
                    @endif

                    @if($post->image_path)
                         <img src="{{ asset($post->image_path) }}" alt="Post image">
                    @endif

                    <!-- Post actions -->
                    <div class="post-actions" data-post-id="{{ $post->id }}">
                        <button class="like-btn" data-post-id="{{ $post->id }}">
                            Like
                            <span class="count" id="likes-count-{{ $post->id }}">{{ $post->likes_count ?? 0 }}</span>
                        </button>
                        
                        <button class="comment-toggle-btn" data-post-id="{{ $post->id }}">
                            Comment
                            <span class="count" id="comments-count-{{ $post->id }}">{{ $post->comments_count ?? 0 }}</span>
                        </button>
                        
                        <button class="share-btn" onclick="copyToClipboard('{{ url('/posts/'.$post->id) }}')">
                            Share
                        </button>
                    </div>

                    <!-- Comments list -->
                    <div class="comments-list" id="comments-list-{{ $post->id }}">
                        @php
                            $comments = $post->interactions()
                                ->where('type', 'comment')
                                ->with('user')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        @foreach($comments as $c)
                            <div class="comment-item" id="comment-{{ $c->id }}">
                                <strong>{{ $c->user->first_name ?? $c->user->name }}:</strong>
                                <span>{{ $c->content }}</span>
                                <small class="muted">• {{ $c->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>

                    <!-- Comment input (hidden by default) -->
                    <div class="comment-form" id="comment-form-{{ $post->id }}" style="display:none;margin-top:8px;">
                        <input type="text" id="comment-input-{{ $post->id }}" placeholder="Write a comment..." style="width:80%;">
                        <button type="button" class="comment-send-btn" data-post-id="{{ $post->id }}">Send</button>
                    </div>
                </div>
            @endforeach

            <div style="margin-top:20px;">
                {{ $posts->links() }}
            </div>
        </div>
    </div>

    <!-- ABOUT TAB CONTENT -->
    <div id="about-tab" class="tab-content">
        <div class="sidebar">
            <div class="card">
                <h2>Quick Info</h2>
                <div style="font-size: 14px; color: #65676b;">
                    <p><strong>Joined:</strong> {{ $user->created_at->format('F Y') }}</p>
                    <p><strong>Posts:</strong> {{ $posts->count() }}</p>
                    <p><strong>Friends:</strong> {{ $friends->count() }}</p>
                </div>
            </div>
        </div>

        <div class="main">
            <!-- Overview Section -->
            <div class="about-section">
                <div class="about-section-header">Overview</div>
                <div class="about-section-content">
                    @if($user->bio)
                        <div class="info-item">
                            <div class="info-icon">ℹ️</div>
                            <div class="info-content">
                                <div class="info-label">Bio</div>
                                <div class="info-value">{{ $user->bio }}</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <div class="info-icon">📅</div>
                        <div class="info-content">
                            <div class="info-label">Joined Facebook</div>
                            <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work and Education -->
            <div class="about-section">
                <div class="about-section-header">Work and Education</div>
                <div class="about-section-content">
                    @if($user->work)
                        <div class="info-item">
                            <div class="info-icon">💼</div>
                            <div class="info-content">
                                <div class="info-label">Work</div>
                                <div class="info-value">{{ $user->work }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->education)
                        <div class="info-item">
                            <div class="info-icon">🎓</div>
                            <div class="info-content">
                                <div class="info-label">Education</div>
                                <div class="info-value">{{ $user->education }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if(Auth::id() === $user->id && (!$user->work || !$user->education))
                        <button class="add-info-btn" onclick="showAddInfoModal('work')">+ Add Work or Education</button>
                    @endif
                </div>
            </div>

            <!-- Contact and Basic Info -->
            <div class="about-section">
                <div class="about-section-header">Contact and Basic Info</div>
                <div class="about-section-content">
                    <div class="info-item">
                        <div class="info-icon">✉️</div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>
                    
                    @if($user->phone)
                        <div class="info-item">
                            <div class="info-icon">📱</div>
                            <div class="info-content">
                                <div class="info-label">Mobile</div>
                                <div class="info-value">{{ $user->phone }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->location)
                        <div class="info-item">
                            <div class="info-icon">📍</div>
                            <div class="info-content">
                                <div class="info-label">Current City</div>
                                <div class="info-value">{{ $user->location }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->hometown)
                        <div class="info-item">
                            <div class="info-icon">🏠</div>
                            <div class="info-content">
                                <div class="info-label">Hometown</div>
                                <div class="info-value">{{ $user->hometown }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if($user->relationship_status)
                        <div class="info-item">
                            <div class="info-icon">❤️</div>
                            <div class="info-content">
                                <div class="info-label">Relationship Status</div>
                                <div class="info-value">{{ $user->relationship_status }}</div>
                            </div>
                        </div>
                    @endif
                    
                    @if(Auth::id() === $user->id)
                        <button class="add-info-btn" onclick="showAddInfoModal('contact')">+ Add Contact Info</button>
                    @endif
                </div>
            </div>

            <!-- Life Events -->
            <div class="about-section">
                <div class="about-section-header">Life Events</div>
                <div class="about-section-content">
                    <div class="info-item">
                        <div class="info-icon">🎂</div>
                        <div class="info-content">
                            <div class="info-label">Joined Facebook</div>
                            <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    
                    @if(Auth::id() === $user->id)
                        <button class="add-info-btn" onclick="showAddInfoModal('life')">+ Add Life Event</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- FRIENDS TAB CONTENT -->
    <div id="friends-tab" class="tab-content">
        <!-- Friends Sidebar -->
        <div class="sidebar">
            <div class="friends-sidebar">
                <h2 style="margin-bottom: 15px;">Friends</h2>
                
                <input type="text" class="friends-search" placeholder="Search friends..." id="friendsSearch">
                
                <div class="friends-filter">
                    <button class="filter-btn active" data-filter="all">All Friends ({{ $friends->count() }})</button>
                    <button class="filter-btn" data-filter="recently-added">Recently Added</button>
                    <button class="filter-btn" data-filter="birthdays">Birthdays</button>
                    <button class="filter-btn" data-filter="current-city">Current City</button>
                    <button class="filter-btn" data-filter="hometown">Hometown</button>
                </div>
            </div>
        </div>

        <!-- Friends Main Content -->
        <div class="main">
            <div class="card">
                <h2 style="margin-bottom: 20px;">All Friends ({{ $friends->count() }})</h2>
                
                <div class="friends-large-grid" id="friendsGrid">
                    @forelse($friends as $friend)
                        <div class="friend-card" data-name="{{ strtolower($friend->first_name . ' ' . $friend->last_name) }}" data-added="{{ $friend->created_at->format('Y-m-d') }}">
                            <a href="{{ route('profile.show', $friend->id) }}">
                                <img src="{{ $friend->profile_picture ? asset('uploads/profile_pictures/' . $friend->profile_picture) : asset('default.png') }}" alt="{{ $friend->first_name }}">
                                <h3>{{ $friend->first_name }} {{ $friend->last_name }}</h3>
                            </a>
                            
                            @if($friend->location)
                                <p style="color: #65676b; font-size: 13px; margin: 5px 0;">📍 {{ $friend->location }}</p>
                            @endif
                            
                            @if($friend->work)
                                <p style="color: #65676b; font-size: 13px; margin: 5px 0;">💼 {{ $friend->work }}</p>
                            @endif
                            <div style="margin-top: 10px; display: flex; gap: 8px;">
    {{-- Message Button --}}
    <button
        onclick="window.location.href='{{ route('messages.index') }}'"
        style="flex: 1; padding: 6px; background: #e7f3ff; color: #1877f2; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
        Message
    </button>

    {{-- Unfriend Button --}}
    <button
        style="flex: 1; padding: 6px; background: #f0f2f5; color: #65676b; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
        Unfriend
    </button>
</div>

                        </div>
                    @empty
                        <div style="text-align: center; color: #65676b; padding: 40px;">
                            <p>No friends to show</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    console.log("JS loaded ✅");
    
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // TAB FUNCTIONALITY
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs and contents
            tabLinks.forEach(l => l.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Show corresponding content
            const tabName = this.dataset.tab;
            const targetContent = document.getElementById(tabName + '-tab');
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // FRIENDS SEARCH FUNCTIONALITY
    const friendsSearch = document.getElementById('friendsSearch');
    const friendCards = document.querySelectorAll('.friend-card');
    
    if (friendsSearch) {
        friendsSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            friendCards.forEach(card => {
                const name = card.dataset.name;
                if (name.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // FRIENDS FILTER FUNCTIONALITY
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active from all filter buttons
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            friendCards.forEach(card => {
                switch(filter) {
                    case 'all':
                        card.style.display = 'block';
                        break;
                    case 'recently-added':
                        // Show friends added in last 30 days
                        const addedDate = new Date(card.dataset.added);
                        const thirtyDaysAgo = new Date();
                        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                        card.style.display = addedDate > thirtyDaysAgo ? 'block' : 'none';
                        break;
                    default:
                        card.style.display = 'block';
                        break;
                }
            });
        });
    });

    // LIKE FUNCTIONALITY
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            
            fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                const likesEl = document.getElementById('likes-count-' + postId);
                if (likesEl) likesEl.textContent = data.likesCount;
                
                // Toggle color/state
                if (data.liked) {
                    btn.style.color = '#1877F2';
                } else {
                    btn.style.color = '';
                }
            })
            .catch(err => {
                console.error('Like error:', err);
                alert('Error liking post. Please try again.');
            });
        });
    });

    // TOGGLE COMMENT INPUT
    document.querySelectorAll('.comment-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const form = document.getElementById('comment-form-' + postId);
            if (!form) return;
            
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
            
            // Focus input when opening
            if (form.style.display === 'block') {
                document.getElementById('comment-input-' + postId).focus();
            }
        });
    });

    // SEND COMMENT FUNCTIONALITY
    document.querySelectorAll(".comment-send-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const postId = this.dataset.postId;
            const input = document.getElementById("comment-input-" + postId);
            const content = input.value.trim();
            
            if (!content) {
                alert('Please write a comment first!');
                return;
            }

            console.log('Sending comment for post:', postId, 'Content:', content);

            fetch(`/posts/${postId}/comment`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ 
                    content: content 
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                
                // Create new comment element
                const commentList = document.getElementById("comments-list-" + postId);
                const newComment = document.createElement("div");
                newComment.classList.add("comment-item");
                newComment.innerHTML = `
                    <strong>${data.comment.user.first_name} ${data.comment.user.last_name || ''}:</strong> 
                    <span>${data.comment.content}</span> 
                    <small class="muted">• ${data.comment.created_at}</small>
                `;
                
                // Add to top of comments list
                commentList.insertBefore(newComment, commentList.firstChild);
                
                // Clear input
                input.value = "";
                
                // Update comments counter
                const counter = document.getElementById("comments-count-" + postId);
                if (counter) {
                    counter.innerText = data.commentsCount;
                }
                
                // Hide comment form
                document.getElementById('comment-form-' + postId).style.display = 'none';
            })
            .catch(error => {
                console.error("Comment error:", error);
                alert('Error posting comment. Please try again.');
            });
        });
    });

    // Allow Enter key to submit comment
    document.querySelectorAll('[id^="comment-input-"]').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const postId = this.id.replace('comment-input-', '');
                const sendBtn = document.querySelector(`[data-post-id="${postId}"].comment-send-btn`);
                if (sendBtn) sendBtn.click();
            }
        });
    });

    // Toggle dropdown
    document.querySelectorAll(".dropdown-toggle").forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle("show");
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('show'));
        }
    });
});

// Copy to clipboard for Share
function copyToClipboard(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert("Post link copied!");
    }).catch(err => {
        console.error('Copy failed:', err);
        alert('Could not copy link to clipboard');
    });
}

// Insert feeling into textarea
function insertFeeling(text) {
    let textarea = document.querySelector(".composer textarea");
    if (textarea) {
        textarea.value += (textarea.value ? " " : "") + text;
        document.querySelectorAll(".dropdown").forEach(d => d.classList.remove("show"));
    }
}

function toggleEdit(field) {
    document.getElementById(field + '-display').style.display = 'none';
    document.getElementById(field + '-edit').style.display = 'block';
    document.getElementById(field + '-input').focus();
}

function cancelEdit(field) {
    document.getElementById(field + '-display').style.display = 'block';
    document.getElementById(field + '-edit').style.display = 'none';
}

function saveField(field) {
    const input = document.getElementById(field + '-input');
    const value = input.value.trim();
    const userId = {{ $user->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/profile/${userId}/update-field`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            field: field,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(field + '-display').innerHTML = 
                '<p>' + (value || `No ${field} added yet.`) + '</p>';
            cancelEdit(field);
        } else {
            alert('Error updating ' + field);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating ' + field);
    });
}

function showAddInfoModal(type) {
    alert(`Add ${type} info modal would open here. This would be a popup form to add new information.`);
}
</script>

@endsection