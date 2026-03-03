{{-- resources/views/marketplace/create.blade.php --}}
<x-sidebar-layout title="Create Listing - SocialBook">
    <div class="card" 
         style="max-width: 800px; margin: 0 auto; padding: 24px; box-sizing: border-box; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        
        <!-- Header -->
        <div style="margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1c1e21; font-size: 24px;">
                <i class="fas fa-plus-circle" style="margin-right: 12px; color: #1877f2;"></i>
                Create New Listing
            </h2>
            <p style="margin: 8px 0 0 0; color: #65676b;">
                Share details about your item to attract potential buyers.
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('marketplace.store') }}" enctype="multipart/form-data" id="listingForm">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                    Item Title <span style="color: #dc2626;">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" required
                       placeholder="e.g., iPhone 13 Pro Max, Vintage Leather Sofa..."
                       style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('title') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; transition: border-color 0.2s; box-sizing: border-box;"
                       onfocus="this.style.borderColor='#1877f2'" 
                       onblur="this.style.borderColor='#e4e6ea'">
                @error('title')
                    <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                    Description <span style="color: #dc2626;">*</span>
                </label>
                <textarea name="description" required rows="4"
                          placeholder="Describe your item's condition, features, and any important details..."
                          style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('description') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; resize: vertical; font-family: inherit; transition: border-color 0.2s; box-sizing: border-box;"
                          onfocus="this.style.borderColor='#1877f2'" 
                          onblur="this.style.borderColor='#e4e6ea'">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price + Category Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <!-- Price -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                        Price <span style="color: #dc2626;">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #65676b; font-size: 14px; font-weight: 600;">PKR</span>
                        <input type="number" name="price" value="{{ old('price') }}" required step="1" min="0"
                               placeholder="0"
                               style="width: 100%; padding: 12px 16px 12px 42px; border: 2px solid {{ $errors->has('price') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; transition: border-color 0.2s; box-sizing: border-box;"
                               onfocus="this.style.borderColor='#1877f2'" 
                               onblur="this.style.borderColor='#e4e6ea'">
                    </div>
                    @error('price')
                        <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                        Category <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="category" required
                            style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('category') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; background: #fff; transition: border-color 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#1877f2'" 
                            onblur="this.style.borderColor='#e4e6ea'">
                        <option value="">Select a category...</option>
                        @foreach($categories as $key => $name)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Condition + Location Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <!-- Condition -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                        Condition <span style="color: #dc2626;">*</span>
                    </label>
                    <select name="condition" required
                            style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('condition') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; background: #fff; transition: border-color 0.2s; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#1877f2'" 
                            onblur="this.style.borderColor='#e4e6ea'">
                        <option value="">Select condition...</option>
                        <option value="new" {{ old('condition') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="like_new" {{ old('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
                        <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                        <option value="poor" {{ old('condition') === 'poor' ? 'selected' : '' }}>Poor</option>
                    </select>
                    @error('condition')
                        <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                        Location (Optional)
                    </label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="e.g., Lahore, Karachi, Islamabad..."
                           style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('location') ? '#dc2626' : '#e4e6ea' }}; border-radius: 8px; font-size: 16px; transition: border-color 0.2s; box-sizing: border-box;"
                           onfocus="this.style.borderColor='#1877f2'" 
                           onblur="this.style.borderColor='#e4e6ea'">
                    @error('location')
                        <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Images -->
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; color: #1c1e21; margin-bottom: 8px;">
                    Photos (Up to 5)
                </label>
                <div style="border: 2px dashed #e4e6ea; border-radius: 8px; padding: 20px; text-align: center; transition: all 0.2s; cursor: pointer;" 
                     id="imageDropArea"
                     ondragover="event.preventDefault(); this.style.borderColor='#1877f2'; this.style.background='#f0f8ff'"
                     ondragleave="this.style.borderColor='#e4e6ea'; this.style.background='transparent'"
                     ondrop="handleDrop(event)"
                     onclick="document.getElementById('imageInput').click()">
                    
                    <input type="file" name="images[]" id="imageInput" multiple accept="image/*" 
                           style="display: none;" onchange="handleFiles(this.files)">
                    
                    <div id="uploadPrompt">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #65676b; margin-bottom: 16px;"></i>
                        <h4 style="margin: 0 0 8px 0; color: #1c1e21;">Upload Photos</h4>
                        <p style="margin: 0; color: #65676b; font-size: 14px;">
                            Drag and drop images here, or click to select files<br>
                            <small>(JPEG, PNG, GIF up to 2MB each)</small>
                        </p>
                    </div>
                    
                    <div id="imagePreview" style="display: none;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 12px; margin-top: 16px;" id="previewGrid"></div>
                        <button type="button" onclick="clearImages()" style="margin-top: 16px; background: #dc2626; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px;">
                            Clear All
                        </button>
                    </div>
                </div>
                @error('images')
                    <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @error('images.*')
                    <div style="color: #dc2626; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #e4e6ea; padding-top: 20px;">
                <a href="{{ route('marketplace.index') }}" 
                   style="padding: 12px 24px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.2s;"
                   onmouseover="this.style.background='#5a6268'"
                   onmouseout="this.style.background='#6c757d'">
                    Cancel
                </a>
                <button type="submit" id="submitBtn"
                        style="padding: 12px 24px; background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(24, 119, 242, 0.4)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(24, 119, 242, 0.3)'">
                    <i class="fas fa-plus-circle"></i> Create Listing
                </button>
            </div>
        </form>
    </div>

    {{-- JavaScript and Styles --}}
    @push('scripts')
    <script>
        let selectedFiles = [];
        
        function handleFiles(files) {
            const maxFiles = 5;
            const maxFileSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            
            Array.from(files).forEach(file => {
                if (selectedFiles.length >= maxFiles) {
                    alert(`Maximum ${maxFiles} images allowed`);
                    return;
                }
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} is not a supported image type`);
                    return;
                }
                if (file.size > maxFileSize) {
                    alert(`File ${file.name} is too large. Maximum size is 2MB`);
                    return;
                }
                selectedFiles.push(file);
            });
            
            updateImagePreview();
            updateFileInput();
        }
        
        function handleDrop(e) {
            e.preventDefault();
            e.currentTarget.style.borderColor = '#e4e6ea';
            e.currentTarget.style.background = 'transparent';
            handleFiles(e.dataTransfer.files);
        }
        
        function updateImagePreview() {
            const preview = document.getElementById('imagePreview');
            const prompt = document.getElementById('uploadPrompt');
            const grid = document.getElementById('previewGrid');
            
            if (selectedFiles.length > 0) {
                preview.style.display = 'block';
                prompt.style.display = 'none';
                
                grid.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.style.cssText = 'position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1;';
                        div.innerHTML = `
                            <img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">
                            <button type="button" onclick="removeImage(${index})" 
                                    style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.7); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                ×
                            </button>
                        `;
                        grid.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                preview.style.display = 'none';
                prompt.style.display = 'block';
            }
        }
        
        function removeImage(index) {
            selectedFiles.splice(index, 1);
            updateImagePreview();
            updateFileInput();
        }
        
        function clearImages() {
            selectedFiles = [];
            updateImagePreview();
            updateFileInput();
        }
        
        function updateFileInput() {
            const input = document.getElementById('imageInput');
            const dt = new DataTransfer();
            
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            
            input.files = dt.files;
        }
        
        // Form validation
        document.getElementById('listingForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
            
            // Re-enable button after 5 seconds in case of issues
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-plus-circle"></i> Create Listing';
            }, 5000);
        });
    </script>
    @endpush

    <style>
        @media (max-width: 768px) {
            .card {
                margin: 0 16px !important;
                padding: 16px !important;
            }
            
            [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
            
            .submit-buttons {
                flex-direction: column !important;
            }
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
    </style>
</x-sidebar-layout>