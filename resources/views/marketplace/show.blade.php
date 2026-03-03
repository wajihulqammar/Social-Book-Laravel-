{{-- resources/views/marketplace/show.blade.php --}}
<x-sidebar-layout title="{{ $listing->title }} - Marketplace - SocialBook">
    <div class="card" style="max-width: 1000px; margin: 0 auto;">
        <!-- Back Button -->
        <div style="margin-bottom: 20px;">
            <a href="{{ route('marketplace.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #1877f2; text-decoration: none; font-weight: 500;">
                <i class="fas fa-arrow-left"></i> Back to Marketplace
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <!-- Left Column - Images and Details -->
            <div>
                <!-- Image Gallery -->
                <div style="margin-bottom: 30px;">
                    @if($listing->images && count($listing->images) > 0)
                        <div style="position: relative;">
                            <div id="mainImageContainer" style="aspect-ratio: 4/3; border-radius: 12px; overflow: hidden; background: #f8f9fa; margin-bottom: 12px;">
                               {{-- Use asset() for public directory images --}}
                               <img id="mainImage" src="{{ asset($listing->images[0]) }}"
                                     style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;"
                                     onclick="openImageModal(this.src)"
                                     alt="{{ $listing->title }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/default-marketplace.png') }}'; this.style.objectFit='contain'; this.style.background='#f8f9fa';">
                            </div>
                            
                            @if(count($listing->images) > 1)
                                <!-- Thumbnail Gallery -->
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    @foreach($listing->images as $index => $image)
                                        <div onclick="changeMainImage('{{ asset($image) }}', {{ $index }})" 
                                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                             style="flex-shrink: 0; width: 80px; height: 80px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 3px solid {{ $index === 0 ? '#1877f2' : 'transparent' }}; transition: all 0.2s; background: #f8f9fa;">
                                            <img src="{{ asset($image) }}" 
                                                 style="width: 100%; height: 100%; object-fit: contain;"
                                                 alt="Image {{ $index + 1 }}"
                                                 onerror="this.onerror=null; this.src='{{ asset('images/default-marketplace.png') }}'; this.style.objectFit='contain';">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div style="aspect-ratio: 4/3; background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #65676b;">
                            <div style="text-align: center;">
                                <i class="fas fa-image" style="font-size: 48px; margin-bottom: 16px;"></i>
                                <div>No images available</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div style="background: #f8f9fa; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 16px 0; color: #1c1e21; font-size: 20px;">Description</h3>
                    <p style="margin: 0; color: #1c1e21; font-size: 16px; line-height: 1.6; white-space: pre-wrap;">{{ $listing->description }}</p>
                </div>

                <!-- Item Details -->
                <div style="background: #fff; border: 1px solid #e4e6ea; border-radius: 12px; padding: 24px;">
                    <h3 style="margin: 0 0 20px 0; color: #1c1e21; font-size: 20px;">Item Details</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div>
                            <div style="color: #65676b; font-size: 14px; margin-bottom: 4px;">Category</div>
                            <div style="color: #1c1e21; font-weight: 600; font-size: 16px;">
                                <i class="fas fa-tag" style="margin-right: 8px; color: #1877f2;"></i>
                                {{ ucwords(str_replace('_', ' ', $listing->category)) }}
                            </div>
                        </div>
                        <div>
                            <div style="color: #65676b; font-size: 14px; margin-bottom: 4px;">Condition</div>
                            <div style="color: #1c1e21; font-weight: 600; font-size: 16px;">
                                @php
                                    $conditionColors = [
                                        'new' => '#10b981',
                                        'like_new' => '#10b981', 
                                        'good' => '#f59e0b',
                                        'fair' => '#ef4444',
                                        'poor' => '#dc2626'
                                    ];
                                @endphp
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: {{ $conditionColors[$listing->condition] ?? '#6b7280' }}; display: inline-block; margin-right: 8px;"></span>
                                {{ ucwords(str_replace('_', ' ', $listing->condition)) }}
                            </div>
                        </div>
                        @if($listing->location)
                            <div>
                                <div style="color: #65676b; font-size: 14px; margin-bottom: 4px;">Location</div>
                                <div style="color: #1c1e21; font-weight: 600; font-size: 16px;">
                                    <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #1877f2;"></i>
                                    {{ $listing->location }}
                                </div>
                            </div>
                        @endif
                        <div>
                            <div style="color: #65676b; font-size: 14px; margin-bottom: 4px;">Listed</div>
                            <div style="color: #1c1e21; font-weight: 600; font-size: 16px;">
                                <i class="fas fa-calendar" style="margin-right: 8px; color: #1877f2;"></i>
                                {{ $listing->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Seller Info and Actions -->
            <div>
                <!-- Price and Status -->
                <div style="background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%); color: #fff; border-radius: 12px; padding: 24px; margin-bottom: 20px; text-align: center;">
                    <div style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">
                        PKR {{ number_format($listing->price) }}
                    </div>
                    @if($listing->status === 'sold')
                        <div style="background: rgba(220, 38, 38, 0.2); color: #fca5a5; padding: 8px 16px; border-radius: 20px; font-weight: 600; display: inline-block;">
                            <i class="fas fa-times-circle"></i> SOLD
                        </div>
                    @else
                        <div style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 8px 16px; border-radius: 20px; font-weight: 600; display: inline-block;">
                            <i class="fas fa-check-circle"></i> Available
                        </div>
                    @endif
                </div>

                <!-- Seller Information -->
                <div style="background: #fff; border: 1px solid #e4e6ea; border-radius: 12px; padding: 24px; margin-bottom: 20px;">
                    <h3 style="margin: 0 0 16px 0; color: #1c1e21; font-size: 18px;">Seller Information</h3>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                        <img src="{{ $listing->user->profile_picture ? asset('uploads/profile_pictures/' . $listing->user->profile_picture) : asset('images/default.png') }}" 
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 3px solid #e4e6ea;"
                             alt="Seller"
                             onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
                        <div>
                            <a href="{{ route('profile.show', $listing->user->id) }}" 
                               style="color: #1c1e21; text-decoration: none; font-weight: 600; font-size: 16px;">
                                {{ $listing->user->first_name }} {{ $listing->user->last_name }}
                            </a>
                            <div style="color: #65676b; font-size: 14px;">
                                Member since {{ $listing->user->created_at->format('M Y') }}
                            </div>
                        </div>
                    </div>
                    
                    @if(auth()->id() !== $listing->user_id)
                        @if($listing->status !== 'sold')
                            <!-- Contact Actions -->
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <a href="{{ route('messages.show', $listing->user->id) }}" 
                                   style="background: #1877f2; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s;"
                                   onmouseover="this.style.background='#166fe5'; this.style.transform='translateY(-2px)'"
                                   onmouseout="this.style.background='#1877f2'; this.style.transform='translateY(0)'">
                                    <i class="fas fa-envelope"></i> Message Seller
                                </a>
                                <a href="tel:" onclick="showContactInfo()" 
                                   style="background: #10b981; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s;"
                                   onmouseover="this.style.background='#059669'; this.style.transform='translateY(-2px)'"
                                   onmouseout="this.style.background='#10b981'; this.style.transform='translateY(0)'">
                                    <i class="fas fa-phone"></i> Call Seller
                                </a>
                            </div>
                        @else
                            <div style="text-align: center; padding: 16px; background: #fee2e2; color: #991b1b; border-radius: 8px;">
                                <i class="fas fa-info-circle"></i> This item has been sold
                            </div>
                        @endif
                    @else
                        <!-- Owner Actions -->
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <a href="{{ route('marketplace.edit', $listing) }}" 
                               style="background: #6c757d; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.2s;"
                               onmouseover="this.style.background='#5a6268'; this.style.transform='translateY(-2px)'"
                               onmouseout="this.style.background='#6c757d'; this.style.transform='translateY(0)'">
                                <i class="fas fa-edit"></i> Edit Listing
                            </a>
                            
                            @if($listing->status !== 'sold')
                                <button onclick="markAsSold({{ $listing->id }})" 
                                        style="background: #f59e0b; color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                                        onmouseover="this.style.background='#d97706'; this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.background='#f59e0b'; this.style.transform='translateY(0)'">
                                    <i class="fas fa-check"></i> Mark as Sold
                                </button>
                            @endif
                            
                            <form method="POST" action="{{ route('marketplace.destroy', $listing) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this listing?')"
                                  style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        style="background: #dc2626; color: #fff; padding: 12px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%;"
                                        onmouseover="this.style.background='#b91c1c'; this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.background='#dc2626'; this.style.transform='translateY(0)'">
                                    <i class="fas fa-trash"></i> Delete Listing
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Safety Tips -->
                <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 20px;">
                    <h4 style="margin: 0 0 12px 0; color: #856404; font-size: 16px;">
                        <i class="fas fa-shield-alt"></i> Safety Tips
                    </h4>
                    <ul style="margin: 0; padding-left: 16px; color: #856404; font-size: 14px; line-height: 1.5;">
                        <li>Meet in a safe, public location</li>
                        <li>Bring a friend if possible</li>
                        <li>Inspect the item carefully</li>
                        <li>Use secure payment methods</li>
                        <li>Trust your instincts</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Related Items -->
        @if($relatedListings->count() > 0)
            <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e4e6ea;">
                <h3 style="margin: 0 0 20px 0; color: #1c1e21; font-size: 20px;">Similar Items</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                    @foreach($relatedListings as $related)
                        <a href="{{ route('marketplace.show', $related) }}" 
                           style="display: block; background: #fff; border: 1px solid #e4e6ea; border-radius: 8px; overflow: hidden; text-decoration: none; transition: all 0.2s;"
                           onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            
                            <div style="aspect-ratio: 4/3; background: #f8f9fa; overflow: hidden;">
                                @if($related->images && count($related->images) > 0)
                                    {{-- Use asset() for public directory images here too --}}
                                    <img src="{{ asset($related->images[0]) }}" 
                                         style="width: 100%; height: 100%; object-fit: contain;"
                                         alt="{{ $related->title }}"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-marketplace.png') }}'; this.style.objectFit='contain';">
                                @else
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #65676b;">
                                        <i class="fas fa-image" style="font-size: 24px;"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div style="padding: 12px;">
                                <div style="font-weight: 600; color: #1c1e21; margin-bottom: 4px; font-size: 14px;">
                                    {{ Str::limit($related->title, 30) }}
                                </div>
                                <div style="color: #1877f2; font-weight: 700; font-size: 16px;">
                                    PKR {{ number_format($related->price) }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10000; cursor: pointer;" onclick="closeImageModal()">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
            <img id="modalImage" style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
        <div style="position: absolute; top: 20px; right: 20px; color: white; font-size: 24px; cursor: pointer;" onclick="closeImageModal()">
            <i class="fas fa-times"></i>
        </div>
    </div>

    <script>
        function changeMainImage(src, index) {
            document.getElementById('mainImage').src = src;
            
            // Update thumbnail active state
            document.querySelectorAll('.thumbnail').forEach((thumb, i) => {
                thumb.style.border = i === index ? '3px solid #1877f2' : '3px solid transparent';
            });
        }
        
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        function showContactInfo() {
            alert('For your safety, contact the seller through our messaging system first to arrange a safe meeting location.');
        }
        
        async function markAsSold(listingId) {
            if (!confirm('Are you sure you want to mark this item as sold?')) return;
            
            try {
                const response = await fetch(`/marketplace/${listingId}/mark-sold`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error marking item as sold. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error marking item as sold. Please try again.');
            }
        }
        
        // Keyboard navigation for image modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>

    <style>
        @media (max-width: 768px) {
            [style*="grid-template-columns: 1fr 350px"] {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
            
            [style*="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))"] {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
            }
            
            .thumbnail {
                width: 60px !important;
                height: 60px !important;
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