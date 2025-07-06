<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Families - Culturoo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .listing-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .listing-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .filter-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-['Inter'] text-gray-800 bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-16 w-auto">
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('listings.index') }}" class="text-orange-600 font-medium">Host Families</a>
                    <a href="#experiences" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></span>
                        <span class="bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ Auth::user()->role_display }}
                        </span>
                        @if(Auth::user()->isHost())
                            <a href="{{ route('host.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                                Host Dashboard
                            </a>
                        @endif
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.panel') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                                Admin Panel
                            </a>
                        @endif
                        <a href="{{ route('profile') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Profile</a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('auth') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Sign In</a>
                        <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Join Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-['Playfair_Display'] font-bold mb-6">Discover Authentic Moroccan Host Families</h1>
                <p class="text-xl text-orange-100 mb-8 max-w-3xl mx-auto">Experience genuine Moroccan hospitality and immerse yourself in local culture with our carefully selected host families</p>
                <div class="flex justify-center">
                    <div class="bg-white rounded-lg p-2 flex items-center max-w-md w-full">
                        <input type="text" id="search-input" placeholder="Search by city..." 
                            class="flex-1 px-4 py-2 text-gray-800 focus:outline-none"
                            value="{{ request('city') }}">
                        <button onclick="searchListings()" class="btn-moroccan text-white px-6 py-2 rounded-lg font-medium">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:col-span-1">
                <div class="filter-card rounded-2xl p-6 shadow-lg sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Results</h3>
                    
                    <form id="filter-form" method="GET" action="{{ route('listings.index') }}">
                        <!-- City Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                            <select name="city" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room Type Filter -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Room Type</label>
                            <select name="room_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="">All Types</option>
                                <option value="private_room" {{ request('room_type') === 'private_room' ? 'selected' : '' }}>Private Room</option>
                                <option value="shared_room" {{ request('room_type') === 'shared_room' ? 'selected' : '' }}>Shared Room</option>
                                <option value="entire_place" {{ request('room_type') === 'entire_place' ? 'selected' : '' }}>Entire Place</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range (MAD/night)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                        </div>

                        <!-- Languages -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Languages</label>
                            <div class="space-y-2">
                                @php $selectedLanguages = request('languages', []); @endphp
                                <label class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="Arabic" 
                                        {{ in_array('Arabic', $selectedLanguages) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <span class="ml-2 text-sm">Arabic</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="French" 
                                        {{ in_array('French', $selectedLanguages) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <span class="ml-2 text-sm">French</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="English" 
                                        {{ in_array('English', $selectedLanguages) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <span class="ml-2 text-sm">English</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="languages[]" value="Spanish" 
                                        {{ in_array('Spanish', $selectedLanguages) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                    <span class="ml-2 text-sm">Spanish</span>
                                </label>
                            </div>
                        </div>

                        <!-- Filter Buttons -->
                        <div class="space-y-2">
                            <button type="submit" class="w-full btn-moroccan text-white py-2 rounded-lg font-medium">
                                Apply Filters
                            </button>
                            <a href="{{ route('listings.index') }}" class="w-full block text-center border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Listings Grid -->
            <div class="lg:col-span-3">
                <!-- Results Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">Available Host Families</h2>
                        <p class="text-gray-600">{{ $announcements->total() }} {{ $announcements->total() === 1 ? 'family' : 'families' }} found</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select onchange="location.href=this.value" class="px-3 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="{{ route('listings.index', array_merge(request()->all(), ['sort' => 'latest'])) }}" {{ request('sort') === 'latest' || !request('sort') ? 'selected' : '' }}>Latest</option>
                            <option value="{{ route('listings.index', array_merge(request()->all(), ['sort' => 'price_low'])) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('listings.index', array_merge(request()->all(), ['sort' => 'price_high'])) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                @if($announcements->count() > 0)
                    <!-- Listings Grid -->
                    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($announcements as $announcement)
                        <div class="listing-card rounded-2xl overflow-hidden shadow-lg">
                            <!-- Image -->
                            <div class="relative h-48">
                                @if($announcement->first_image)
                                    <img src="{{ asset('storage/' . $announcement->first_image) }}" 
                                        alt="{{ $announcement->title }}" 
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Price Badge -->
                                <div class="absolute top-4 right-4 bg-white rounded-lg px-3 py-1 shadow-lg">
                                    <span class="text-lg font-bold text-orange-600">{{ number_format($announcement->price_per_night) }}</span>
                                    <span class="text-sm text-gray-600">MAD/night</span>
                                </div>

                                <!-- Room Type Badge -->
                                <div class="absolute top-4 left-4 bg-orange-600 text-white rounded-lg px-3 py-1 text-sm font-medium">
                                    {{ $announcement->room_type_display }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $announcement->title }}</h3>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $announcement->city }}</span>
                                    <span class="mx-2">•</span>
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>Up to {{ $announcement->max_guests }} guests</span>
                                </div>

                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $announcement->description }}</p>

                                <!-- Host Info -->
                                <div class="flex items-center mb-4 pb-4 border-b border-gray-200">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold mr-3">
                                        @if($announcement->host->profile_picture)
                                            <img src="{{ asset('storage/' . $announcement->host->profile_picture) }}" 
                                                alt="{{ $announcement->host->first_name }}" 
                                                class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            {{ strtoupper(substr($announcement->host->first_name ?? $announcement->host->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $announcement->host->first_name ?? $announcement->host->name }}</p>
                                        <p class="text-xs text-gray-600">Host Family</p>
                                    </div>
                                </div>

                                <!-- Languages -->
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice($announcement->languages, 0, 3) as $language)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $language }}</span>
                                        @endforeach
                                        @if(count($announcement->languages) > 3)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">+{{ count($announcement->languages) - 3 }} more</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('listings.show', $announcement) }}" 
                                    class="w-full btn-moroccan text-white py-3 rounded-lg font-medium text-center block transition-colors duration-300">
                                    View Details & Book
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($announcements->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $announcements->appends(request()->query())->links() }}
                        </div>
                    @endif

                @else
                    <!-- No Results -->
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">No host families found</h3>
                        <p class="text-gray-600 mb-6">Try adjusting your filters or search criteria to find more results.</p>
                        <a href="{{ route('listings.index') }}" class="btn-moroccan text-white px-6 py-3 rounded-lg font-medium inline-block">
                            Clear All Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        function searchListings() {
            const searchInput = document.getElementById('search-input');
            const searchValue = searchInput.value.trim();
            
            const url = new URL(window.location.href);
            if (searchValue) {
                url.searchParams.set('city', searchValue);
            } else {
                url.searchParams.delete('city');
            }
            
            window.location.href = url.toString();
        }

        // Allow enter key to trigger search
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchListings();
            }
        });

        // Auto-submit filter form when options change
        document.getElementById('filter-form').addEventListener('change', function() {
            this.submit();
        });
    </script>
</body>
</html>
