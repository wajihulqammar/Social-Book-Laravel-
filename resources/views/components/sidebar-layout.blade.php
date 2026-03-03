{{-- resources/views/components/sidebar-layout.blade.php --}}
@props(['title' => 'SocialBook', 'rightSidebar' => null])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: #f0f2f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background: #fff;
            color: #1c1e21;
            display: flex;
            gap: 14px;
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
            text-decoration: none;
        }

        .topbar .search {
            flex: 1;
            position: relative;
            max-width: 320px;
        }

        .topbar .search input {
            width: 100%;
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
            grid-template-columns: 280px 1fr {{ $rightSidebar ? '320px' : '' }};
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

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 16px;
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
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(24, 119, 242, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.4);
        }

        .right-sidebar {
            position: sticky;
            top: 80px;
            height: fit-content;
        }

        @media screen and (max-width: 1024px) {
            .shell {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .left-sidebar, .right-sidebar {
                position: relative;
                top: 0;
            }
        }

        /* Search Results */
        #search-results {
            position: absolute;
            background: #fff;
            border: 1px solid #e4e6ea;
            border-radius: 8px;
            width: 100%;
            max-width: 420px;
            display: none;
            z-index: 1000;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            margin-top: 4px;
        }

        .search-result-item {
            padding: 10px;
            border-bottom: 1px solid #e4e6ea;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .search-result-item:hover {
            background: #f0f2f5;
        }

        .search-result-item img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-name {
            font-weight: 500;
            color: #1c1e21;
            font-size: 14px;
        }

        .search-result-username {
            font-size: 12px;
            color: #65676b;
        }
    </style>
</head>
<body>
    <!-- Topbar -->
    <div class="topbar">
        <a href="{{ route('dashboard') }}" class="brand">SocialBook</a>
        <div class="search">
            <input type="text" id="user-search" placeholder="Search SocialBook..." autocomplete="off">
            <div id="search-results"></div>
        </div>
        <div class="topbar-right">
            <a href="{{ route('profile.show', auth()->user()->id) }}" class="profile-link">
                <img src="{{ auth()->user()->profile_picture 
                    ? asset('uploads/profile_pictures/' . auth()->user()->profile_picture)
                    : asset('images/default.png') }}" alt="Profile">
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
                <li class="{{ request()->routeIs('marketplace*') ? 'active' : '' }}">
                    <a href="{{ route('marketplace.index') }}">
                        <i class="fas fa-store"></i> Marketplace
                    </a>
                </li>
                <li class="{{ request()->routeIs('groups*') ? 'active' : '' }}">
                    <a href="{{ route('groups.index') }}">
                        <i class="fas fa-users"></i> Groups
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
            {{ $slot }}
        </div>

        <!-- Right Sidebar -->
        @if($rightSidebar)
            <div class="right-sidebar">
                {{ $rightSidebar }}
            </div>
        @endif
    </div>

    <!-- Base JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const searchInput = document.getElementById('user-search');
            const searchResults = document.getElementById('search-results');
            let searchTimeout;

            // Enhanced search functionality
            if (searchInput && searchResults) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    
                    clearTimeout(searchTimeout);
                    
                    if (query.length < 2) {
                        searchResults.style.display = 'none';
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        searchResults.innerHTML = '<div style="padding:12px;color:#65676b;font-size:14px;">Searching...</div>';
                        searchResults.style.display = 'block';

                        fetch(`/search/users?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.users && data.users.length > 0) {
                                searchResults.innerHTML = data.users.map(user => `
                                    <div class="search-result-item" onclick="window.location.href='/profile/${user.id}'">
                                        <img src="${user.profile_picture ? '/uploads/profile_pictures/' + user.profile_picture : '/images/default.png'}" alt="Profile">
                                        <div class="search-result-info">
                                            <div class="search-result-name">${user.first_name} ${user.last_name}</div>
                                            <div class="search-result-username">@${user.username || user.first_name.toLowerCase()}</div>
                                        </div>
                                    </div>
                                `).join('');
                            } else {
                                searchResults.innerHTML = '<div style="padding:12px;color:#65676b;font-size:14px;">No users found</div>';
                            }
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            searchResults.innerHTML = '<div style="padding:12px;color:#dc2626;font-size:14px;">Search error occurred</div>';
                        });
                    }, 300);
                });

                // Hide search results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.style.display = 'none';
                    }
                });
            }
        });
    </script>

    {{ $scripts ?? '' }}
</body>
</html>