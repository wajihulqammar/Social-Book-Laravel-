{{-- resources/views/marketplace/index.blade.php --}}
<x-sidebar-layout title="Marketplace - SocialBook">
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #1c1e21; font-size: 24px;">
                <i class="fas fa-store" style="margin-right: 12px; color: #1877f2;"></i>
                Marketplace
            </h2>
            <a href="{{ route('marketplace.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Sell Something
            </a>
        </div>

        <!-- Search and Filters -->
        <div style="background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
            <form method="GET" action="{{ route('marketplace.index') }}" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <input type="text" name="search" placeholder="Search items..." 
                           value="{{ request('search') }}"
                           style="width: 100%; padding: 10px 16px; border: 1px solid #e4e6ea; border-radius: 8px; outline: none;">
                </div>
                
                <select name="category" style="padding: 10px 16px; border: 1px solid #e4e6ea; border-radius: 8px; outline: none;">
                    <option value="">All Categories</option>
                    <option value="vehicles" {{ request('category') == 'vehicles' ? 'selected' : '' }}>Vehicles</option>
                    <option value="home_garden" {{ request('category') == 'home_garden' ? 'selected' : '' }}>Home & Garden</option>
                    <option value="electronics" {{ request('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                    <option value="clothing" {{ request('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                    <option value="sports" {{ request('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                    <option value="toys_games" {{ request('category') == 'toys_games' ? 'selected' : '' }}>Toys & Games</option>
                    <option value="books" {{ request('category') == 'books' ? 'selected' : '' }}>Books</option>
                    <option value="furniture" {{ request('category') == 'furniture' ? 'selected' : '' }}>Furniture</option>
                    <option value="music" {{ request('category') == 'music' ? 'selected' : '' }}>Music</option>
                    <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                
                <select name="sort" style="padding: 10px 16px; border: 1px solid #e4e6ea; border-radius: 8px; outline: none;">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
                
                <button type="submit" class="btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        @if(isset($listings) && $listings->count() > 0)
            <!-- Listings Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
                @foreach($listings as $listing)
                    <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; cursor: pointer;" 
                         onclick="window.location.href='{{ route('marketplace.show', $listing) }}'"
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" 
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">

                        <!-- Image -->
                      <div style="height: 200px; background: #f8f9fa; position: relative; overflow: hidden;">
    @if($listing->images && count($listing->images) > 0)
        {{-- Use asset() for public directory images --}}
        <img src="{{ asset($listing->images[0]) }}" 
             style="width: 100%; height: 100%; object-fit: contain;"
             alt="{{ $listing->title }}"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div style="display: none; align-items: center; justify-content: center; height: 100%; color: #65676b;">
            <i class="fas fa-image" style="font-size: 48px;"></i>
        </div>
    @else
        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #65676b;">
            <i class="fas fa-image" style="font-size: 48px;"></i>
        </div>
    @endif
    
    <!-- Status Badge -->
    @if($listing->status === 'sold')
        <div style="position: absolute; top: 10px; right: 10px; background: #dc2626; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
            SOLD
        </div>
    @elseif($listing->featured ?? false)
        <div style="position: absolute; top: 10px; right: 10px; background: #f59e0b; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
            FEATURED
        </div>
    @endif

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
                                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1c1e21; line-height: 1.3;">
                                    {{ Str::limit($listing->title, 40) }}
                                </h3>
                                <div style="font-size: 18px; font-weight: 700; color: #1877f2; margin-left: 8px;">
                                    PKR {{ number_format($listing->price) }}
                                </div>
                            </div>
                            
                            <p style="margin: 0 0 12px 0; color: #65676b; font-size: 14px; line-height: 1.4;">
                                {{ Str::limit($listing->description, 80) }}
                            </p>
                            
                            <!-- Category & Condition -->
                            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                <span style="background: #e4e6ea; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #65676b;">
                                    {{ ucwords(str_replace('_', ' ', $listing->category)) }}
                                </span>
                                <span style="background: #e4e6ea; padding: 3px 8px; border-radius: 12px; font-size: 12px; color: #65676b;">
                                    {{ ucwords(str_replace('_', ' ', $listing->condition)) }}
                                </span>
                            </div>
                            
                            <!-- Seller Info -->
                            <div style="display: flex; align-items: center; gap: 8px; padding-top: 12px; border-top: 1px solid #e4e6ea;">
                                <img src="{{ $listing->user->profile_picture ? asset('uploads/profile_pictures/' . $listing->user->profile_picture) : asset('images/default.png') }}" 
                                     style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;"
                                     alt="Seller"
                                     onerror="this.onerror=null; this.src='{{ asset('images/default.png') }}';">
                                <div>
                                    <div style="font-size: 13px; font-weight: 600; color: #1c1e21;">
                                        {{ $listing->user->first_name }} {{ $listing->user->last_name }}
                                    </div>
                                    <div style="font-size: 12px; color: #65676b;">
                                        {{ $listing->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                
                                @if($listing->location)
                                    <div style="margin-left: auto; font-size: 12px; color: #65676b;">
                                        <i class="fas fa-map-marker-alt"></i> {{ Str::limit($listing->location, 15) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center;">
                {{ $listings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div style="text-align: center; padding: 60px 20px; color: #65676b;">
                @if(request('search') || request('category'))
                    <i class="fas fa-search" style="font-size: 80px; margin-bottom: 24px; color: #e4e6ea;"></i>
                    <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 24px;">No items found</h3>
                    <p style="margin: 0 0 24px 0; font-size: 16px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Try adjusting your search terms or browse all categories.
                    </p>
                    <a href="{{ route('marketplace.index') }}" class="btn-primary">
                        <i class="fas fa-refresh"></i> Clear Filters
                    </a>
                @else
                    <i class="fas fa-store" style="font-size: 80px; margin-bottom: 24px; color: #e4e6ea;"></i>
                    <h3 style="margin: 0 0 12px 0; color: #1c1e21; font-size: 24px;">Buy and Sell Locally</h3>
                    <p style="margin: 0 0 24px 0; font-size: 16px; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Discover great deals on items being sold by people in your community.
                    </p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 40px;">
                        <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; text-align: center; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                            <i class="fas fa-search" style="font-size: 48px; margin-bottom: 16px; color: #1877f2;"></i>
                            <h4 style="margin: 0 0 8px 0; color: #1c1e21;">Browse Items</h4>
                            <p style="margin: 0 0 16px 0; color: #65676b; font-size: 14px;">
                                Find exactly what you're looking for in your area
                            </p>
                            <button class="btn-primary" onclick="document.querySelector('input[name=search]').focus()">
                                Start Browsing
                            </button>
                        </div>
                        
                        <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; text-align: center; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                            <i class="fas fa-tags" style="font-size: 48px; margin-bottom: 16px; color: #1877f2;"></i>
                            <h4 style="margin: 0 0 8px 0; color: #1c1e21;">Sell Items</h4>
                            <p style="margin: 0 0 16px 0; color: #65676b; font-size: 14px;">
                                Turn your unused items into cash quickly and easily
                            </p>
                            <a href="{{ route('marketplace.create') }}" class="btn-primary">
                                Create Listing
                            </a>
                        </div>
                        
                        <div style="background: #fff; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; text-align: center; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
                            <i class="fas fa-handshake" style="font-size: 48px; margin-bottom: 16px; color: #1877f2;"></i>
                            <h4 style="margin: 0 0 8px 0; color: #1c1e21;">Safe Trading</h4>
                            <p style="margin: 0 0 16px 0; color: #65676b; font-size: 14px;">
                                Connect with verified sellers in your local community
                            </p>
                            <a href="{{ route('marketplace.my-listings') }}" class="btn-primary">
                                My Listings
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <x-slot:rightSidebar>
        <div class="card">
            <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                Categories
            </h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @php
                    $categoryIcons = [
                        'vehicles' => 'fa-car',
                        'home_garden' => 'fa-home',
                        'electronics' => 'fa-laptop',
                        'clothing' => 'fa-tshirt',
                        'sports' => 'fa-football-ball',
                        'toys_games' => 'fa-gamepad',
                        'books' => 'fa-book',
                        'furniture' => 'fa-couch',
                        'music' => 'fa-music',
                        'other' => 'fa-boxes'
                    ];
                    
                    $categoryNames = [
                        'vehicles' => 'Vehicles',
                        'home_garden' => 'Home & Garden',
                        'electronics' => 'Electronics',
                        'clothing' => 'Clothing',
                        'sports' => 'Sports',
                        'toys_games' => 'Toys & Games',
                        'books' => 'Books',
                        'furniture' => 'Furniture',
                        'music' => 'Music',
                        'other' => 'Other'
                    ];
                @endphp

                <a href="{{ route('marketplace.index') }}" 
                   style="display: block; padding: 12px; background: {{ !request('category') ? '#e3f2fd' : '#f8f9fa' }}; border-radius: 8px; cursor: pointer; transition: background 0.2s; text-decoration: none; color: #1c1e21;" 
                   onmouseover="this.style.background='#e9ecef'" 
                   onmouseout="this.style.background='{{ !request('category') ? '#e3f2fd' : '#f8f9fa' }}'">
                    <i class="fas fa-th-large" style="margin-right: 8px; color: #1877f2;"></i>
                    <strong>All Categories</strong>
                    <div style="font-size: 12px; color: #65676b; margin-top: 4px;">
                        {{ isset($listings) ? $listings->total() : 0 }} listings
                    </div>
                </a>
                
                @foreach($categoryNames as $key => $name)
                    <a href="{{ route('marketplace.index', ['category' => $key]) }}" 
                       style="display: block; padding: 12px; background: {{ request('category') === $key ? '#e3f2fd' : '#f8f9fa' }}; border-radius: 8px; cursor: pointer; transition: background 0.2s; text-decoration: none; color: #1c1e21;" 
                       onmouseover="this.style.background='#e9ecef'" 
                       onmouseout="this.style.background='{{ request('category') === $key ? '#e3f2fd' : '#f8f9fa' }}'">
                        <i class="fas {{ $categoryIcons[$key] }}" style="margin-right: 8px; color: #1877f2;"></i>
                        <strong>{{ $name }}</strong>
                        <div style="font-size: 12px; color: #65676b; margin-top: 4px;">
                            {{ isset($categoryCounts[$key]) ? $categoryCounts[$key] : 0 }} listings
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @auth
            <div class="card" style="margin-top: 16px;">
                <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                    Quick Actions
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <a href="{{ route('marketplace.create') }}" class="btn-primary" style="display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                        <i class="fas fa-plus"></i> Create Listing
                    </a>
                    <a href="{{ route('marketplace.my-listings') }}" class="btn" style="display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; background: #6c757d;">
                        <i class="fas fa-list"></i> My Listings
                    </a>
                </div>
            </div>
        @endauth

        <div class="card" style="margin-top: 16px;">
            <h3 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1c1e21;">
                Safety Tips
            </h3>
            <div style="font-size: 14px; color: #65676b; line-height: 1.5;">
                <div style="margin-bottom: 12px; padding: 12px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                    <strong style="color: #856404;">Meet in Public</strong><br>
                    Always meet buyers/sellers in safe, public locations.
                </div>
                <div style="margin-bottom: 12px; padding: 12px; background: #d1ecf1; border-radius: 8px; border-left: 4px solid #17a2b8;">
                    <strong style="color: #0c5460;">Verify Items</strong><br>
                    Inspect items carefully before completing transactions.
                </div>
                <div style="padding: 12px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;">
                    <strong style="color: #155724;">Trust Your Instincts</strong><br>
                    If something feels wrong, don't proceed with the transaction.
                </div>
            </div>
        </div>
    </x-slot:rightSidebar>

    <style>
        .btn-primary {
            background: linear-gradient(135deg, #1877f2 0%, #42a5f5 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
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

        .btn {
            background: linear-gradient(135deg, #6c757d 0%, #868e96 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(108, 117, 125, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
            text-decoration: none;
            color: #fff;
        }

        @media (max-width: 768px) {
            .shell {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            form[style*="flex-wrap"] {
                flex-direction: column;
                align-items: stretch;
            }
            
            form[style*="flex-wrap"] > * {
                width: 100% !important;
                margin-bottom: 8px;
            }
            
            form[style*="flex-wrap"] > div {
                min-width: auto !important;
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