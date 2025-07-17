<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Culturoo') - Culturoo</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body class="font-['Inter'] text-gray-800 bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    
                    @auth
                        <!-- User Profile Dropdown -->
                        <div class="relative dropdown-wrapper">
                            <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors duration-300 p-2 rounded-lg hover:bg-orange-50">
                                <div class="text-right mr-2">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->first_name ?? Auth::user()->name }}</p>
                                    @if(Auth::user()->isAdmin())
                                        <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">
                                            Admin
                                        </span>
                                    @elseif(Auth::user()->isHost())
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-medium">
                                            Host
                                        </span>
                                    @else
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                                            Visitor
                                        </span>
                                    @endif
                                </div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                                <svg class="w-5 h-5 transform transition-transform duration-200" id="menu-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Content -->
                            <div id="user-menu" class="absolute right-0 mt-2 w-[250px] bg-white rounded-xl shadow-2xl border-2 border-orange-200 py-3 hidden" style="z-index: 9999;">
                                <!-- User Info Section -->
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <p class="font-medium text-gray-900 text-base">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                    <div class="mt-2">
                                        @if(Auth::user()->isAdmin())
                                            <span class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium">
                                                Admin Panel
                                            </span>
                                        @elseif(Auth::user()->isHost())
                                            <span class="text-sm bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                                Host Dashboard
                                            </span>
                                        @else
                                            <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                                                Visitor Profile
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Dropdown Actions -->
                                <div class="py-2">
                                    <!-- Profile Link -->
                                    <a href="{{ route('profile') }}" class="dropdown-item font-medium text-base py-3">
                                        My Profile
                                    </a>
                                    
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.panel') }}" class="dropdown-item font-medium text-base py-3">
                                            Admin Dashboard
                                        </a>
                                    @endif
                                    
                                    @if(Auth::user()->isHost())
                                        <a href="{{ route('host.dashboard') }}" class="dropdown-item font-medium text-base py-3">
                                            Host Dashboard
                                        </a>
                                    @endif
                                </div>

                                <!-- Logout -->
                                <div class="border-t border-gray-200 pt-2">
                                    <form method="POST" action="{{ route('auth.logout') }}" class="w-full">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-red-600 hover:bg-red-50 w-full text-left font-medium text-base py-3">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('auth') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @vite('resources/js/app.js')
    @stack('scripts')
    
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #8B4513, #D2691E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-moroccan {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            transition: all 0.3s ease;
        }
        .btn-moroccan:hover {
            background: linear-gradient(135deg, #8B4513, #D2691E);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 69, 19, 0.3);
        }
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #374151;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
        }
        .dropdown-item:hover {
            background-color: #fef3c7;
            color: #ea580c;
        }
    </style>

    <script>
        // Toggle user dropdown menu
        function toggleUserMenu() {
            const userMenu = document.getElementById('user-menu');
            const menuArrow = document.getElementById('menu-arrow');
            
            if (userMenu) {
                userMenu.classList.toggle('hidden');
                
                // Toggle arrow rotation
                if (userMenu.classList.contains('hidden')) {
                    menuArrow.classList.remove('rotate-180');
                } else {
                    menuArrow.classList.add('rotate-180');
                }
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const profileButton = document.querySelector('.dropdown-wrapper button');
            
            if (userMenu && !userMenu.classList.contains('hidden')) {
                // Check if the click was outside the dropdown and its toggle button
                if (!userMenu.contains(event.target) && !profileButton.contains(event.target)) {
                    userMenu.classList.add('hidden');
                    document.getElementById('menu-arrow').classList.remove('rotate-180');
                }
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const userMenu = document.getElementById('user-menu');
                const menuArrow = document.getElementById('menu-arrow');
                
                if (userMenu) {
                    userMenu.classList.add('hidden');
                }
                if (menuArrow) {
                    menuArrow.classList.remove('rotate-180');
                }
            }
        });
    </script>
</body>
</html>
