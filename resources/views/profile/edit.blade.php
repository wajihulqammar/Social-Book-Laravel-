@extends('layouts.app')

<head> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></head>
@section('content')
<style>
    body {
        background: #f0f2f5;
        font-family: Arial, sans-serif;
    }
    .edit-wrap {
        max-width: 500px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .edit-wrap h2 {
        font-size: 22px;
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 6px;
    }
    .form-group input[type="file"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
        outline: none;
        transition: border 0.2s;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
    .form-group input[type="file"] {
        padding: 6px;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #1877f2;
        box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
    }
    .save-btn {
        width: 100%;
        background: #1877f2;
        color: #fff;
        font-weight: 600;
        padding: 10px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.2s;
    }
    .save-btn:hover {
        background: #155db2;
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
    <div class="brand">SocialBook</div>
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
<div class="edit-wrap">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Bio -->
        <div class="form-group">
            <label>Bio</label>
            <textarea name="bio" placeholder="Tell something about yourself...">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <!-- Profile Picture -->
        <div class="form-group">
            <label>Profile Picture</label>
            <input type="file" name="profile_picture">
        </div>

        <button type="submit" class="save-btn">Save Changes</button>
    </form>
</div>
@endsection
