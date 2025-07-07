<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Culturoo</title>
    @include('partials.favicon')
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
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .booking-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .status-pending { 
            background-color: #fef3c7; 
            color: #92400e; 
        }
        .status-confirmed { 
            background-color: #d1fae5; 
            color: #065f46; 
        }
        .status-rejected { 
            background-color: #fee2e2; 
            color: #991b1b; 
        }
        .status-completed { 
            background-color: #dbeafe; 
            color: #1e40af; 
        }
        .status-cancelled { 
            background-color: #f3f4f6; 
            color: #374151; 
        }
        .progress-step {
            transition: all 0.3s ease;
        }
        .progress-step.active {
            background-color: #059669;
            color: white;
        }
        .progress-step.completed {
            background-color: #10b981;
            color: white;
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
                <div class="flex items-center space-x-6">
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <span class="text-gray-700">Welcome, <span class="font-semibold text-orange-600">{{ Auth::user()->first_name ?? Auth::user()->name }}</span></span>
                    @if(Auth::user()->isHost())
                        <a href="{{ route('host.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Host Dashboard
                        </a>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                            Admin Panel
                        </a>
                    @endif
                    <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <!-- Profile Header -->
        <div class="profile-card rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                <div class="relative">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-32 h-32 rounded-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <button onclick="document.getElementById('profile-picture-input').click()" class="absolute bottom-0 right-0 bg-orange-600 hover:bg-orange-700 text-white p-2 rounded-full shadow-lg transition-colors duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                    <input type="file" id="profile-picture-input" accept="image/*" style="display: none;" onchange="uploadProfilePicture(this)">
                </div>
                <div class="text-center md:text-left flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                            </h1>
                            <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
                        </div>
                        <button id="edit-info-btn" onclick="toggleEditMode()" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span id="edit-btn-text">Edit Info</span>
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst(Auth::user()->user_type ?? 'traveler') }}
                        </span>
                        <span class="bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ Auth::user()->role_display }}
                        </span>
                        @if(Auth::user()->country)
                            <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                                {{ Auth::user()->country }}
                            </span>
                        @endif
                        @if(Auth::user()->is_verified)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                ✓ Verified
                            </span>
                        @endif
                    </div>
                    @if(Auth::user()->bio)
                        <p class="text-gray-600 mt-4">{{ Auth::user()->bio }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- User Information Panel -->
            <div class="lg:col-span-2">
                <!-- Profile Information Display/Edit -->
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6">
                        <h2 class="text-2xl font-bold">Profile Information</h2>
                    </div>

                    <!-- View Mode -->
                    <div id="view-mode" class="p-8 fade-transition">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->first_name ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->last_name ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->phone ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">User Type</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst(Auth::user()->user_type ?? 'traveler') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->role_display }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->country ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->city ?? 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <p class="text-gray-900 font-medium">{{ Auth::user()->date_of_birth ? Auth::user()->date_of_birth->format('M d, Y') : 'Not set' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                <p class="text-gray-900 font-medium">{{ ucfirst(Auth::user()->gender ?? 'Not set') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Languages</label>
                                <p class="text-gray-900 font-medium">
                                    @if(Auth::user()->languages)
                                        {{ is_array(Auth::user()->languages) ? implode(', ', Auth::user()->languages) : Auth::user()->languages }}
                                    @else
                                        Not set
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Interests</label>
                                <p class="text-gray-900 font-medium">
                                    @if(Auth::user()->interests)
                                        {{ is_array(Auth::user()->interests) ? implode(', ', Auth::user()->interests) : Auth::user()->interests }}
                                    @else
                                        Not set
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div id="edit-mode" class="p-8 fade-transition hidden">
                        <form id="profile-form" enctype="multipart/form-data">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="tel" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">User Type</label>
                                    <select name="user_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                        <option value="traveler" {{ Auth::user()->user_type === 'traveler' ? 'selected' : '' }}>Traveler</option>
                                        <option value="host" {{ Auth::user()->user_type === 'host' ? 'selected' : '' }}>Host Family</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                    <input type="text" name="country" value="{{ Auth::user()->country }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                    <input type="text" name="city" value="{{ Auth::user()->city }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select name="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ Auth::user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                    <textarea name="bio" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300" placeholder="Tell us about yourself...">{{ Auth::user()->bio }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Languages (comma separated)</label>
                                    <input type="text" name="languages" value="{{ is_array(Auth::user()->languages) ? implode(', ', Auth::user()->languages) : Auth::user()->languages }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300" placeholder="English, Arabic, French">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Interests (comma separated)</label>
                                    <input type="text" name="interests" value="{{ is_array(Auth::user()->interests) ? implode(', ', Auth::user()->interests) : Auth::user()->interests }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300" placeholder="Cooking, Culture, Travel">
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end space-x-4">
                                <button type="button" onclick="cancelEdit()" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-300">
                                    Cancel
                                </button>
                                <button type="submit" class="btn-moroccan text-white px-8 py-3 rounded-lg font-medium inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6">
                        <h2 class="text-2xl font-bold">Change Password</h2>
                    </div>
                    <div class="p-8">
                        <form id="password-form">
                            @csrf
                            <div class="max-w-md space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" name="new_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                <button type="submit" class="btn-moroccan text-white px-8 py-3 rounded-lg font-medium inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- My Bookings Panel -->
            <div class="lg:col-span-1">
                <div class="profile-card rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6">
                        <h2 class="text-2xl font-bold">My Bookings</h2>
                        <p class="text-orange-100">Track your reservations and their progress</p>
                    </div>
                    <div class="p-6">
                        @if(isset($bookings) && $bookings->count() > 0)
                            <div class="space-y-6">
                                @foreach($bookings as $booking)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                                        <!-- Booking Header -->
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $booking->announcement->title }}</h3>
                                                <p class="text-sm text-gray-600">
                                                    Host: {{ $booking->host->first_name }} {{ $booking->host->last_name }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 text-xs font-medium rounded-full status-{{ $booking->status }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>

                                        <!-- Booking Details -->
                                        <div class="text-sm text-gray-600 mb-4">
                                            <div class="flex items-center mb-1">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                            </div>
                                            <div class="flex items-center mb-1">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $booking->guests_count }} guest{{ $booking->guests_count > 1 ? 's' : '' }}
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $booking->announcement->city }}
                                            </div>
                                        </div>

                                        <!-- Progress Tracker -->
                                        <div class="mb-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-6 h-6 rounded-full progress-step completed flex items-center justify-center">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-xs text-gray-600">Requested</span>
                                                </div>
                                                
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-6 h-6 rounded-full progress-step {{ in_array($booking->status, ['confirmed', 'completed']) ? 'completed' : ($booking->status === 'pending' ? 'active' : '') }} flex items-center justify-center">
                                                        @if(in_array($booking->status, ['confirmed', 'completed']))
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        @elseif($booking->status === 'pending')
                                                            <div class="w-2 h-2 bg-current rounded-full animate-pulse"></div>
                                                        @else
                                                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-600">
                                                        @if($booking->status === 'rejected')
                                                            Declined
                                                        @elseif($booking->status === 'cancelled')
                                                            Cancelled
                                                        @else
                                                            Confirmed
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="flex items-center space-x-2">
                                                    <div class="w-6 h-6 rounded-full progress-step {{ $booking->status === 'completed' ? 'completed' : '' }} flex items-center justify-center">
                                                        @if($booking->status === 'completed')
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        @else
                                                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-600">Completed</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            <div class="w-full bg-gray-200 rounded-full h-1">
                                                <div class="bg-green-600 h-1 rounded-full transition-all duration-300" style="width: 
                                                    @if($booking->status === 'completed') 100% 
                                                    @elseif($booking->status === 'confirmed') 66% 
                                                    @elseif($booking->status === 'pending') 33%
                                                    @elseif($booking->status === 'rejected' || $booking->status === 'cancelled') 33%
                                                    @else 33% 
                                                    @endif"></div>
                                            </div>
                                        </div>

                                        <!-- Price and Actions -->
                                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                            <div class="font-medium text-orange-600">
                                                {{ number_format($booking->total_price, 0) }} MAD
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('bookings.show', $booking) }}" 
                                                   class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                                                    View Details
                                                </a>
                                                @if($booking->status === 'confirmed')
                                                    <span class="text-gray-300">|</span>
                                                    <button class="text-green-600 hover:text-green-700 text-sm font-medium">
                                                        Contact Host
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-500 mb-4">No bookings yet</p>
                                <a href="{{ route('listings.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">Browse Host Families</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Host Bookings (for hosts) -->
                @if(Auth::user()->isHost() && isset($hostBookings) && $hostBookings->count() > 0)
                    <div class="profile-card rounded-2xl shadow-lg overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
                            <h2 class="text-2xl font-bold">Guest Bookings</h2>
                            <p class="text-green-100">Manage your incoming reservations</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($hostBookings as $booking)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h3>
                                                <p class="text-sm text-gray-600">{{ $booking->announcement->title }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full status-{{ $booking->status }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 mb-3">
                                            <div>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</div>
                                            <div>{{ $booking->guests_count }} guest{{ $booking->guests_count > 1 ? 's' : '' }}</div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <div class="font-medium text-green-600">{{ number_format($booking->total_price, 0) }} MAD</div>
                                            <a href="{{ route('bookings.show', $booking) }}" 
                                               class="text-green-600 hover:text-green-700 text-sm font-medium">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Host Application Panel -->
                @if(Auth::user()->role === 'visitor')
                    <div class="profile-card rounded-2xl shadow-lg overflow-hidden mt-6">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6">
                            <h2 class="text-2xl font-bold">Become a Host</h2>
                        </div>
                        <div class="p-6">
                            @if(!$hostApplication)
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-purple-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <p class="text-gray-700 mb-4">Want to share Moroccan culture with travelers?</p>
                                    <button onclick="showHostApplicationForm()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300">
                                        Apply to be a Host
                                    </button>
                                    <button onclick="console.log('Test button clicked'); alert('JavaScript is working!');" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300 ml-2">
                                        Test JS
                                    </button>
                                </div>
                            @else
                                <div class="space-y-6">
                                    <!-- Status Header -->
                                    <div class="text-center border-b border-gray-200 pb-6">
                                        <div class="w-16 h-16 bg-{{ $hostApplication->status_color }}-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            @if($hostApplication->status === 'approved')
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @elseif($hostApplication->status === 'rejected')
                                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Host Application</h3>
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-{{ $hostApplication->status_color }}-100 text-{{ $hostApplication->status_color }}-800">
                                            {{ $hostApplication->status_display }}
                                        </span>
                                        <p class="text-sm text-gray-600 mt-2">
                                            Applied on {{ $hostApplication->created_at->format('M d, Y') }}
                                        </p>
                                        @if($hostApplication->reviewed_at)
                                            <p class="text-sm text-gray-600">
                                                Reviewed on {{ $hostApplication->reviewed_at->format('M d, Y') }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Application Details -->
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <h4 class="text-md font-semibold text-gray-900 mb-3">Application Details</h4>
                                            <div class="space-y-3">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700">City:</span>
                                                    <p class="text-sm text-gray-900">{{ $hostApplication->city }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700">Family Size:</span>
                                                    <p class="text-sm text-gray-900">{{ $hostApplication->family_members_count }} member{{ $hostApplication->family_members_count > 1 ? 's' : '' }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700">Languages:</span>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach($hostApplication->languages as $language)
                                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $language }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-md font-semibold text-gray-900 mb-3">Amenities Offered</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($hostApplication->amenities as $amenity)
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $amenity }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Motivation -->
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-900 mb-2">Motivation</h4>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-sm text-gray-700">{{ $hostApplication->motivation }}</p>
                                        </div>
                                    </div>

                                    <!-- Documents -->
                                    <div>
                                        <h4 class="text-md font-semibold text-gray-900 mb-3">Submitted Documents</h4>
                                        <div class="flex flex-wrap gap-3">
                                            <a href="{{ asset('storage/' . $hostApplication->national_id_document) }}" target="_blank" 
                                               class="flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span class="text-sm">National ID</span>
                                            </a>
                                            <a href="{{ asset('storage/' . $hostApplication->house_ownership_document) }}" target="_blank" 
                                               class="flex items-center px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors duration-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                </svg>
                                                <span class="text-sm">House Document</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Admin Notes -->
                                    @if($hostApplication->admin_notes)
                                        <div>
                                            <h4 class="text-md font-semibold text-gray-900 mb-2">Admin Notes</h4>
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                                <p class="text-sm text-gray-700">{{ $hostApplication->admin_notes }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Actions for pending applications -->
                                    @if($hostApplication->status === 'pending')
                                        <div class="text-center pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-600 mb-3">Your application is currently being reviewed by our team.</p>
                                            <div class="text-xs text-gray-500">
                                                You'll receive an email notification once the review is complete.
                                            </div>
                                        </div>
                                    @elseif($hostApplication->status === 'rejected')
                                        <div class="text-center pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-600 mb-3">Your application was not approved this time.</p>
                                            <button onclick="showHostApplicationForm()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-300">
                                                Submit New Application
                                            </button>
                                        </div>
                                    @elseif($hostApplication->status === 'approved')
                                        <div class="text-center pt-4 border-t border-gray-200">
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                                <p class="text-sm text-green-800 font-medium">🎉 Congratulations! You're now a verified host.</p>
                                                <p class="text-sm text-green-700 mt-1">You can start welcoming guests and sharing Moroccan culture!</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let isEditMode = false;

        // Toggle between view and edit modes
        function toggleEditMode() {
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            const editBtn = document.getElementById('edit-info-btn');
            const editBtnText = document.getElementById('edit-btn-text');

            if (!isEditMode) {
                // Switch to edit mode
                viewMode.style.opacity = '0';
                setTimeout(() => {
                    viewMode.classList.add('hidden');
                    editMode.classList.remove('hidden');
                    setTimeout(() => {
                        editMode.style.opacity = '1';
                    }, 50);
                }, 300);
                
                editBtnText.textContent = 'Cancel';
                editBtn.className = 'bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center';
                isEditMode = true;
            } else {
                // Switch to view mode
                cancelEdit();
            }
        }

        function cancelEdit() {
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            const editBtn = document.getElementById('edit-info-btn');
            const editBtnText = document.getElementById('edit-btn-text');

            editMode.style.opacity = '0';
            setTimeout(() => {
                editMode.classList.add('hidden');
                viewMode.classList.remove('hidden');
                setTimeout(() => {
                    viewMode.style.opacity = '1';
                }, 50);
            }, 300);
            
            editBtnText.textContent = 'Edit Info';
            editBtn.className = 'bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center';
            isEditMode = false;
        }

        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            
            alertContainer.innerHTML = `
                <div class="alert ${alertClass}">
                    ${message}
                </div>
            `;

            // Scroll to top to make sure alert is visible
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Auto-hide after 8 seconds for errors, 5 for success
            const hideTime = type === 'error' ? 8000 : 5000;
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, hideTime);
        }

        // Profile form submission
        document.getElementById('profile-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            const form = this;
            
            // Add CSRF token
            formData.append('_token', csrfToken);
            
            // Only add fields that have values
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name && input.name !== '_token') {
                    if (input.type === 'file') {
                        if (input.files.length > 0) {
                            formData.append(input.name, input.files[0]);
                        }
                    } else if (input.value && input.value.trim() !== '') {
                        formData.append(input.name, input.value.trim());
                    }
                }
            });
            
            try {
                const response = await fetch('/profile', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    // Switch back to view mode and reload page to show updated info
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else if (data.errors) {
                    // Handle validation errors
                    let errorMessage = 'Validation errors:\n';
                    for (const field in data.errors) {
                        errorMessage += `${field}: ${data.errors[field].join(', ')}\n`;
                    }
                    showAlert(errorMessage, 'error');
                } else {
                    showAlert(data.message || 'Profile update failed', 'error');
                }
            } catch (error) {
                showAlert('An error occurred. Please try again.', 'error');
            }
        });

        // Password form submission
        document.getElementById('password-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/profile/change-password', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    this.reset();
                } else {
                    showAlert(data.message || 'Password change failed', 'error');
                }
            } catch (error) {
                showAlert('An error occurred. Please try again.', 'error');
            }
        });

        // Profile picture upload
        async function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('profile_picture', input.files[0]);
                formData.append('_token', csrfToken);

                try {
                    const response = await fetch('/profile', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        showAlert('Profile picture updated successfully!', 'success');
                        location.reload();
                    } else {
                        showAlert(data.message || 'Failed to update profile picture', 'error');
                    }
                } catch (error) {
                    showAlert('An error occurred. Please try again.', 'error');
                }
            }
        }

        // Host Application Modal
        function showHostApplicationForm() {
            console.log('Opening host application modal');
            document.getElementById('host-application-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function hideHostApplicationForm() {
            console.log('Closing host application modal');
            document.getElementById('host-application-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Character counter for motivation field
        function updateCharacterCount(textarea) {
            const count = textarea.value.length;
            const counter = document.getElementById('motivation-char-count');
            counter.textContent = `${count}/50`;
            
            if (count < 50) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-green-500');
            } else {
                counter.classList.add('text-green-500');
                counter.classList.remove('text-red-500');
            }
        }

        // Host application form submission
        document.addEventListener('DOMContentLoaded', function() {
            const hostApplicationForm = document.getElementById('host-application-form');
            if (hostApplicationForm) {
                hostApplicationForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Client-side validation
                    const motivation = this.querySelector('textarea[name="motivation"]').value;
                    const languages = this.querySelectorAll('input[name="languages[]"]:checked');
                    const amenities = this.querySelectorAll('input[name="amenities[]"]:checked');
                    
                    let validationErrors = [];
                    
                    if (motivation.length < 50) {
                        validationErrors.push('Motivation must be at least 50 characters long');
                    }
                    
                    if (languages.length === 0) {
                        validationErrors.push('Please select at least one language');
                    }
                    
                    if (amenities.length === 0) {
                        validationErrors.push('Please select at least one amenity');
                    }
                    
                    if (validationErrors.length > 0) {
                        showAlert('Please fix the following errors:<br><br>' + validationErrors.join('<br>'), 'error');
                        return;
                    }
                    
                    // Show immediate feedback
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Submitting...';
                    submitButton.disabled = true;
                    
                    try {
                        const formData = new FormData(this);
                        
                        const response = await fetch('/host-application', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        
                        const data = await response.json();

                        if (response.ok && data.success) {
                            showAlert(data.message, 'success');
                            hideHostApplicationForm();
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            if (data.errors) {
                                let errorMessages = [];
                                for (const field in data.errors) {
                                    // Make field names more user-friendly
                                    const fieldName = field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                                    errorMessages.push(`${fieldName}: ${data.errors[field].join(', ')}`);
                                }
                                showAlert('Please fix the following errors:<br><br>' + errorMessages.join('<br>'), 'error');
                            } else {
                                showAlert(data.message || 'Application submission failed', 'error');
                            }
                        }
                    } catch (error) {
                        // Try to get more specific error information
                        let errorMessage = error.message;
                        if (error.response) {
                            try {
                                const errorData = await error.response.json();
                                if (errorData.errors) {
                                    let errorMessages = [];
                                    for (const field in errorData.errors) {
                                        const fieldName = field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                                        errorMessages.push(`${fieldName}: ${errorData.errors[field].join(', ')}`);
                                    }
                                    errorMessage = 'Please fix the following errors:<br><br>' + errorMessages.join('<br>');
                                } else if (errorData.message) {
                                    errorMessage = errorData.message;
                                }
                            } catch (parseError) {
                                // Silent fail for parse error
                            }
                        }
                        
                        showAlert(`Error: ${errorMessage}`, 'error');
                    } finally {
                        // Re-enable submit button
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                    }
                });
            }
        });
    </script>

    <!-- Host Application Modal -->
    <div id="host-application-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Apply to Become a Host</h2>
                    <button onclick="hideHostApplicationForm()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-purple-100 mt-2">Share authentic Moroccan culture with travelers from around the world</p>
            </div>

            <form id="host-application-form" class="p-6 space-y-6">
                @csrf
                
                <!-- Personal Documents -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            National ID Document <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="national_id_document" accept=".pdf,.jpg,.jpeg,.png" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300">
                        <p class="text-xs text-gray-500 mt-1">Upload your national ID (PDF, JPG, PNG - Max 5MB)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            House Ownership Document <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="house_ownership_document" accept=".pdf,.jpg,.jpeg,.png" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300">
                        <p class="text-xs text-gray-500 mt-1">Proof of house ownership or rental agreement (PDF, JPG, PNG - Max 5MB)</p>
                    </div>
                </div>

                <!-- Location and Family Info -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300"
                            placeholder="e.g., Marrakech, Casablanca, Fez">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Number of Family Members <span class="text-red-500">*</span>
                        </label>
                        <select name="family_members_count" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300">
                            <option value="">Select number of family members</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'person' : 'people' }}</option>
                            @endfor
                            <option value="11">More than 10</option>
                        </select>
                    </div>
                </div>

                <!-- Languages -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Languages Spoken <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="Arabic" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Arabic</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="Berber/Amazigh" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Berber/Amazigh</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="French" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">French</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="English" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">English</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="Spanish" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Spanish</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="German" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">German</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="Italian" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Italian</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="Other" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Other</span>
                        </label>
                    </div>
                </div>

                <!-- Amenities -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Available Amenities <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="WiFi" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">WiFi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Private Shower" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Private Shower</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Shared Bathroom" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Shared Bathroom</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Air Conditioning" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Air Conditioning</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Heating" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Heating</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Kitchen Access" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Kitchen Access</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Laundry" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Laundry</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Parking" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Parking</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Balcony/Terrace" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Balcony/Terrace</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Garden" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Garden</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Traditional Decor" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Traditional Decor</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="Meals Included" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm">Meals Included</span>
                        </label>
                    </div>
                </div>

                <!-- Motivation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Why do you want to become a host? <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivation" rows="5" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300"
                        placeholder="Tell us about your motivation to host travelers, what cultural experiences you want to share, and what makes your family special... (minimum 50 characters)"
                        oninput="updateCharacterCount(this)"></textarea>
                    <div class="flex justify-between text-sm text-gray-500 mt-1">
                        <span>Minimum 50 characters required</span>
                        <span id="motivation-char-count">0/50</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="hideHostApplicationForm()" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
