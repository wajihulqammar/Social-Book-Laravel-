{{-- resources/views/groups/create.blade.php --}}
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
    max-width: 600px;
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

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 8px;
    font-size: 15px;
}

.form-control,
.form-select,
textarea {
    width: 100%;
    border: 2px solid #e4e6ea;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 15px;
    font-family: inherit;
    transition: all 0.2s;
    box-sizing: border-box; /* FIX: keeps input inside container */
    resize: vertical;        /* prevent horizontal overflow */
    max-width: 100%;
}

.form-control:focus,
.form-select:focus,
textarea:focus {
    outline: none;
    border-color: #1877f2;
    box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2);
}

.form-select {
    background: white;
    cursor: pointer;
}

.form-text {
    font-size: 13px;
    color: #65676b;
    margin-top: 4px;
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
    display: inline-block;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: #e4e6ea;
    transform: translateY(-1px);
}

.radio-group {
    display: flex;
    gap: 16px;
    margin-top: 8px;
}

.radio-option {
    flex: 1;
    border: 2px solid #e4e6ea;
    border-radius: 8px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.2s;
}

.radio-option:hover {
    border-color: #1877f2;
}

.radio-option.selected {
    border-color: #1877f2;
    background: rgba(24, 119, 242, 0.05);
}

.radio-option input[type="radio"] {
    display: none;
}

.radio-title {
    font-weight: 600;
    color: #1c1e21;
    margin-bottom: 4px;
}

.radio-description {
    font-size: 13px;
    color: #65676b;
    line-height: 1.4;
}

.file-upload {
    border: 2px dashed #e4e6ea;
    border-radius: 8px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}

.file-upload:hover {
    border-color: #1877f2;
    background: rgba(24, 119, 242, 0.02);
}

.file-upload input[type="file"] {
    display: none;
}

.upload-icon {
    font-size: 32px;
    color: #65676b;
    margin-bottom: 8px;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    font-size: 14px;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<div class="topbar">
    <div class="brand">SocialBook</div>
    <div class="topbar-right">
        <a href="{{ route('profile.show', auth()->user()->id) }}" style="display: flex; align-items: center; gap: 8px; color: #1c1e21; text-decoration: none; font-weight: 600;">
            <img src="{{ auth()->user()->profile_picture_url }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;" alt="Profile">
            <span>{{ auth()->user()->first_name }}</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="card">
        <div style="margin-bottom: 24px;">
            <h2 style="margin: 0 0 8px 0; color: #1c1e21; font-size: 24px;">
                <i class="fas fa-users" style="margin-right: 12px; color: #1877f2;"></i>
                Create New Group
            </h2>
            <p style="margin: 0; color: #65676b; font-size: 15px;">
                Build a community around your interests and connect with like-minded people.
            </p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Group Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" 
                       placeholder="Enter your group name" required>
                <div class="form-text">Choose a name that clearly describes your group's purpose.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" rows="4" 
                         placeholder="Describe what your group is about..." required>{{ old('description') }}</textarea>
                <div class="form-text">Help people understand what your group is about and what they can expect.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Privacy Setting *</label>
                <div class="radio-group">
                    <div class="radio-option {{ old('privacy', 'public') == 'public' ? 'selected' : '' }}">
                        <input type="radio" name="privacy" value="public" {{ old('privacy', 'public') == 'public' ? 'checked' : '' }}>
                        <div class="radio-title">
                            <i class="fas fa-globe"></i> Public
                        </div>
                        <div class="radio-description">
                            Anyone can see the group, its members, and posts.
                        </div>
                    </div>
                    
                    <div class="radio-option {{ old('privacy') == 'closed' ? 'selected' : '' }}">
                        <input type="radio" name="privacy" value="closed" {{ old('privacy') == 'closed' ? 'checked' : '' }}>
                        <div class="radio-title">
                            <i class="fas fa-lock"></i> Closed
                        </div>
                        <div class="radio-description">
                            Anyone can find the group, but only members can see posts.
                        </div>
                    </div>
                    
                    <div class="radio-option {{ old('privacy') == 'secret' ? 'selected' : '' }}">
                        <input type="radio" name="privacy" value="secret" {{ old('privacy') == 'secret' ? 'checked' : '' }}>
                        <div class="radio-title">
                            <i class="fas fa-eye-slash"></i> Secret
                        </div>
                        <div class="radio-description">
                            Only members can find the group and see posts.
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category" class="form-select" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}" {{ old('category') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Choose the category that best fits your group.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}" 
                       placeholder="City, Country (optional)">
                <div class="form-text">Help members find local groups and events.</div>
            </div>

            <div class="form-group">
                <label class="form-label">Cover Image</label>
                <div class="file-upload" onclick="document.getElementById('cover_image').click()">
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div style="font-weight: 600; color: #1c1e21; margin-bottom: 4px;">
                        Upload Cover Image
                    </div>
                    <div style="font-size: 13px; color: #65676b;">
                        Choose an image that represents your group (JPG, PNG, max 2MB)
                    </div>
                </div>
                <div id="selected-file" style="margin-top: 8px; font-size: 13px; color: #1877f2; display: none;"></div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Create Group
                </button>
                <a href="{{ route('groups.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle radio button selections
    document.querySelectorAll('.radio-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Update visual selection
            document.querySelectorAll('.radio-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Handle file upload
    const fileInput = document.getElementById('cover_image');
    const selectedFileDiv = document.getElementById('selected-file');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const fileName = this.files[0].name;
            selectedFileDiv.textContent = `Selected: ${fileName}`;
            selectedFileDiv.style.display = 'block';
        } else {
            selectedFileDiv.style.display = 'none';
        }
    });
});
</script>

@endsection
