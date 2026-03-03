{{-- resources/views/marketplace/my-listings.blade.php --}}
<x-sidebar-layout title="My Listings - SocialBook">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1c1e21; font-size: 24px;">
                <i class="fas fa-list" style="margin-right: 12px; color: #1877f2;"></i>
                My Listings
            </h2>
            <a href="{{ route('marketplace.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Create New Listing
            </a>
        </div>

        @if($listings->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($listings as $listing)
                    <div style="background: #fff; border: 1px solid #e4e6ea; border-radius: 12px; overflow: hidden; transition: all 0.3s;" 
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" 
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        
                        <!-- Image -->
                        <div style="height: 200px; background: #f8f9fa; position: relative; overflow: hidden;">
                            @if($listing->images && count($listing->images) > 0)
                                {{-- Use asset() for public directory images --}}
                                <img src="{{ asset($listing->images[0]) }}" 
                                     style="width: 100%; height: 100%; object-fit: contain; cursor: pointer;"
                                     onclick="window.location.href='{{ route('marketplace.show', $listing) }}'"
                                     alt="{{ $listing->title }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display: none; align-items: center; justify-content: center; height: 100%; color: #65676b; cursor: pointer;"
                                     onclick="window.location.href='{{ route('marketplace.show', $listing) }}'">
                                    <i class="fas fa-image" style="font-size: 48px;"></i>
                                </div>
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #65676b; cursor: pointer;"
                                     onclick="window.location.href='{{ route('marketplace.show', $listing) }}'">
                                    <i class="fas fa-image" style="font-size: 48px;"></i>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div style="position: absolute; top: 10px; right: 10px;">
                                @if($listing->status === 'sold')
                                    <span style="background: #dc2626; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        SOLD
                                    </span>
                                @elseif($listing->status === 'inactive')
                                    <span style="background: #6b7280; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        INACTIVE
                                    </span>
                                @else
                                    <span style="background: #10b981; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        ACTIVE
                                    </span>
                                @endif
                            </div>

                            <!-- Multiple Images Indicator -->
                            @if($listing->images && count($listing->images) > 1)
                                <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                    <i class="fas fa-images"></i> {{ count($listing->images) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div style="padding: 16px;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1c1e21; line-height: 1.3; cursor: pointer;"
                                    onclick="window.location.href='{{ route('marketplace.show', $listing) }}'">
                                    {{ Str::limit($listing->title, 40) }}
                                </h3>
                                <div style="font-size: 18px; font-weight: 700; color: #1877f2; margin-left: 8px;">
                                    PKR {{ number_format($listing->price) }}
                                </div>
                            </div>
                            
                            <p style="margin: 0 0 12px 0; color: #65676b; font-size: 14px; line-height: 1.4;">
                                {{ Str::limit($listing->description, 80) }}
                            </p>
                            
                            <!-- Category & Date -->
                            <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                                <span style="background: #e4e6ea; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #65676b;">
                                    {{ ucwords(str_replace('_', ' ', $listing->category)) }}
                                </span>
                                <span style="background: #e4e6ea; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #65676b;">
                                    {{ $listing->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 8px; border-top: 1px solid #e4e6ea; padding-top: 12px;">
                                <a href="{{ route('marketplace.show', $listing) }}" 
                                   style="flex: 1; background: #1877f2; color: #fff; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; text-align: center; transition: all 0.2s;"
                                   onmouseover="this.style.background='#166fe5'"
                                   onmouseout="this.style.background='#1877f2'">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                
                                <a href="{{ route('marketplace.edit', $listing) }}" 
                                   style="flex: 1; background: #6c757d; color: #fff; padding: 8px 12px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 12px; text-align: center; transition: all 0.2s;"
                                   onmouseover="this.style.background='#5a6268'"
                                   onmouseout="this.style.background='#6c757d'">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                @if($listing->status === 'active')
                                    <button onclick="markAsSold({{ $listing->id }})" 
                                            style="flex: 1; background: #f59e0b; color: #fff; padding: 8px 12px; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='#d97706'"
                                            onmouseout="this.style.background='#f59e0b'">
                                        <i class="fas fa-check"></i> Mark Sold
                                    </button>
                                @endif
                                
                                <form method="POST" action="{{ route('marketplace.destroy', $listing) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this listing?')"
                                      style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="background: #dc2626; color: #fff; padding: 8px 12px; border: none; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.background='#b91c1c'"
                                            onmouseout="this.style.background='#dc2626'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 30px; display: flex; justify-content: center;">
                {{ $listings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 60px 20px; color: #65676b;">
                <i class="fas fa-box-open" style="font-size: 80px; margin-bottom: 24px; color: #e4e6ea;"></i>
                <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 24px;">No listings yet</h3>
                <p style="margin: 0 0 24px 0; font-size: 16px; max-width: 400px; margin-left: auto; margin-right: auto;">
                    Start selling your items by creating your first listing.
                </p>
                <a href="{{ route('marketplace.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i> Create Your First Listing
                </a>
            </div>
        @endif
    </div>

    <script>
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
    </script>

    <style>
        .btn-primary {
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
            text-decoration: none;
            color: #fff;
        }

        @media (max-width: 768px) {
            [style*="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr))"] {
                grid-template-columns: 1fr !important;
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