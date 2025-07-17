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

        .nav-link {
            @apply flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all duration-300;
        }
        
        .nav-link.active {
            @apply text-orange-600 bg-orange-50 font-semibold;
        }
        
        .btn-success {
            @apply bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center text-sm;
        }
        
        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300 inline-flex items-center text-sm;
        }
        
        .dropdown-item {
            @apply block px-4 py-2 text-base text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-200 flex items-center;
            width: 100%;
        }
        
        /* Navbar animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #user-menu:not(.hidden) {
            animation: slideDown 0.2s ease-out;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .nav-link {
                @apply px-2 py-1 text-xs;
            }
        }
        
        /* Active states and focus styles */
        .nav-link:focus,
        .dropdown-item:focus {
            @apply outline-none ring-2 ring-orange-500 ring-opacity-50;
        }
        
        /* Custom gradient for brand */
        .brand-gradient {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Enhanced button styles */
        .btn-success:hover,
        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, transform, box-shadow;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Searchable dropdown styling */
        input[list] {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
        }
        
        input[list]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
        
        /* Custom datalist appearance */
        datalist {
            max-height: 200px;
            overflow-y: auto;
        }
        
        @-moz-document url-prefix() {
            /* Styling for Firefox */
            input[list] {
                appearance: none;
            }
        }
    </style>
</head>
<body class="font-['Inter'] text-gray-800 bg-orange-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                        <div class="hidden sm:block">
                        </div>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('profile') }}" class="text-orange-600 font-medium transition-colors duration-300">My Profile</a>
                    
                    @if(Auth::user()->isHost())
                        <a href="{{ route('host.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                            Host Dashboard
                        </a>
                    @endif
                    
                    <!-- Admin Panel - Only visible if User is Admin -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                            Admin
                        </a>
                    @endif
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors duration-300 p-2 rounded-lg hover:bg-orange-50 menu-button">
                            <div class="hidden sm:block text-right mr-2">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->first_name ?? Auth::user()->name }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold profile-avatar">
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
                        <div id="user-menu" class="absolute right-0 mt-2 w-[250px] bg-white rounded-xl shadow-2xl border-2 border-orange-200 py-3 hidden dropdown-menu" style="z-index: 100000; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: absolute; transform: translateZ(0);">
                            <!-- User Info Section -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="font-medium text-gray-900 text-base">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                <div class="mt-2">
                                    <span class="text-sm bg-{{ Auth::user()->role_color ?? 'orange' }}-100 text-{{ Auth::user()->role_color ?? 'orange' }}-800 px-3 py-1 rounded-full font-medium">
                                        {{ Auth::user()->role_display }}
                                    </span>
                                </div>
                            </div>

                            <!-- Dropdown Actions -->
                            <div class="py-2">
                                <!-- Edit Profile -->
                                <button onclick="toggleEditMode(); toggleUserMenu();" class="dropdown-item w-full text-left font-medium text-base py-3">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Info
                                </button>
                                
                                <!-- Change Password -->
                                <button onclick="openPasswordModal(); toggleUserMenu();" class="dropdown-item w-full text-left font-medium text-base py-3">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Change Password
                                </button>
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

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button class="text-gray-700 hover:text-orange-600 focus:outline-none focus:text-orange-600" onclick="toggleMobileMenu()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a href="{{ route('welcome') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('listings.index') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('profile') }}" class="block px-3 py-2 text-orange-600 font-medium">My Profile</a>
                    
                    <button onclick="toggleNotifications()" class="w-full text-left block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">
                        <div class="flex items-center">
                            Notifications
                            <span class="ml-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </div>
                    </button>
                    
                    @if(Auth::user()->isHost())
                        <a href="{{ route('host.dashboard') }}" class="block px-3 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg font-medium">
                            Host Dashboard
                        </a>
                    @endif
                    
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="block px-3 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg font-medium">
                            Admin Panel
                        </a>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <!-- User Info -->
                        <div class="mb-4 p-3 bg-white rounded-lg border border-orange-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <p class="font-medium text-gray-900 text-lg">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                @if(Auth::user()->isIdentityVerified())
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 mb-2">{{ Auth::user()->email }}</p>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm bg-{{ Auth::user()->role_color ?? 'orange' }}-100 text-{{ Auth::user()->role_color ?? 'orange' }}-800 px-3 py-1 rounded-full font-medium">
                                    {{ Auth::user()->role_display }}
                                </span>
                                @if(Auth::user()->isIdentityVerified())
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <button onclick="toggleEditMode(); toggleMobileMenu();" class="w-full py-3 px-4 rounded-lg text-left bg-orange-50 text-orange-700 hover:bg-orange-100 font-medium mb-3 flex items-center justify-center text-lg">
                            Edit Info
                        </button>
                        
                        <form method="POST" action="{{ route('auth.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-lg text-left bg-red-50 text-red-700 hover:bg-red-100 font-medium flex items-center justify-center text-lg">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
                        
                        <!-- Dropdown Content - Always visible, text-only, and accessible -->
                        <div id="user-menu" class="absolute right-0 mt-2 w-[250px] bg-white rounded-xl shadow-2xl border-2 border-orange-200 py-3 hidden dropdown-menu" style="z-index: 100000; left: -8rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: absolute; transform: translateZ(0);">
                            <!-- User Info Section - Enhanced for clarity -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="font-medium text-gray-900 text-base">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                <div class="mt-2">
                                    <span class="text-sm bg-{{ Auth::user()->role_color ?? 'orange' }}-100 text-{{ Auth::user()->role_color ?? 'orange' }}-800 px-3 py-1 rounded-full font-medium">
                                        {{ Auth::user()->role_display }}
                                    </span>
                                </div>
                            </div>

                            <!-- Dropdown Actions - Only Edit Info and Logout, text-only -->
                            <div class="py-2">
                                <!-- Edit Profile -->
                                <button onclick="toggleEditMode(); toggleUserMenu();" class="dropdown-item w-full text-left font-medium text-base py-3">
                                    Edit Info
                                </button>
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="md:hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white h-full w-4/5 max-w-sm py-6 px-4 overflow-y-auto shadow-xl">
            <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-3">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                </div>
                <button onclick="toggleMobileMenu()" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="space-y-4">
                <a href="{{ route('welcome') }}" class="block py-2 px-4 rounded-lg hover:bg-orange-50 text-gray-700 hover:text-orange-600 font-medium">
                    <div class="flex items-center">
                        Home
                    </div>
                </a>
                <a href="{{ route('listings.index') }}" class="block py-2 px-4 rounded-lg hover:bg-orange-50 text-gray-700 hover:text-orange-600 font-medium">
                    <div class="flex items-center">
                        Host Families
                    </div>
                </a>
                <a href="{{ route('profile') }}" class="block py-2 px-4 rounded-lg hover:bg-orange-50 bg-orange-50 text-orange-600 font-medium">
                    <div class="flex items-center">
                        My Profile
                    </div>
                </a>
                
                @if(Auth::user()->isHost())
                    <a href="{{ route('host.dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-green-50 text-green-700 hover:text-green-800 font-medium">
                        <div class="flex items-center">
                            Host Dashboard
                        </div>
                    </a>
                @endif
                
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.panel') }}" class="block py-2 px-4 rounded-lg hover:bg-red-50 text-red-700 hover:text-red-800 font-medium">
                        <div class="flex items-center">
                            Admin Panel
                        </div>
                    </a>
                @endif
            </nav>                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <!-- User Info -->
                    <div class="mb-4 p-3 bg-white rounded-lg border border-orange-100">
                        <p class="font-medium text-gray-900 text-lg">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ Auth::user()->email }}</p>
                        <span class="text-sm bg-{{ Auth::user()->role_color ?? 'orange' }}-100 text-{{ Auth::user()->role_color ?? 'orange' }}-800 px-3 py-1 rounded-full font-medium">
                            {{ Auth::user()->role_display }}
                        </span>
                    </div>
                    
                    <button onclick="toggleEditMode(); toggleMobileMenu();" class="w-full py-3 px-4 rounded-lg text-left bg-orange-50 text-orange-700 hover:bg-orange-100 font-medium mb-3 flex items-center justify-center text-lg">
                        Edit Info
                    </button>
                    
                    <form method="POST" action="{{ route('auth.logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 rounded-lg text-left bg-red-50 text-red-700 hover:bg-red-100 font-medium flex items-center justify-center text-lg">
                            Logout
                        </button>
                    </form>
                </div>
        </div>
    </div>

    <!-- Breadcrumb Navigation -->
    <div class="bg-orange-50/50 border-b border-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-orange-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="sr-only">Home</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700 font-medium">My Profile</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

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
                            <div class="flex items-center space-x-2 mb-2">
                                <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </h1>
                                @if(Auth::user()->isIdentityVerified())
                                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst(Auth::user()->user_type ?? 'traveler') }}
                        </span>
                        <span class="bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ Auth::user()->role_display }}
                        </span>
                        @if(Auth::user()->isIdentityVerified())
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Verified Identity</span>
                            </span>
                        @endif
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

        <!-- Profile Completion Section -->
        <div class="profile-card rounded-2xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Profile Completion</h2>
                    <p class="text-gray-600">Complete your profile to get the most out of Culturoo</p>
                </div>
                
                <!-- Circular Progress -->
                <div class="relative">
                    <div class="circular-progress" data-percentage="{{ Auth::user()->profile_completion['percentage'] }}">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <!-- Background circle -->
                            <path class="circle-bg" stroke="currentColor" stroke-width="3" fill="none" 
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <!-- Progress circle -->
                            <path class="circle-progress" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"
                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <!-- Percentage text -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-lg font-bold percentage-text">{{ Auth::user()->profile_completion['percentage'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Button -->
            @if(Auth::user()->profile_completion['percentage'] < 100)
                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <button onclick="toggleEditMode()" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-300 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Complete Profile
                    </button>
                </div>
            @endif
        </div>

        <!-- Profile Verification Section - Only show if user is not verified -->
        @if(!Auth::user()->isIdentityVerified())
            <div class="profile-card rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                    <h2 class="text-2xl font-bold text-white">Profile Verification</h2>
                    <p class="text-blue-100">Verify your identity to unlock more features</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center mb-2">
                                @if(Auth::user()->hasVerificationRequest())
                                    @php
                                        $latestRequest = Auth::user()->latestVerificationRequest;
                                    @endphp
                                    @if($latestRequest->status === 'pending')
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-yellow-600">Verification Pending</h3>
                                            <p class="text-sm text-gray-600">Your verification request is being reviewed</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Submitted {{ $latestRequest->created_at->diffForHumans() }} 
                                                • Document: {{ $latestRequest->document_type_display }}
                                            </p>
                                        </div>
                                    @elseif($latestRequest->status === 'rejected')
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-red-600">Verification Rejected</h3>
                                            <p class="text-sm text-gray-600">Your verification request was not approved</p>
                                            @if($latestRequest->admin_notes)
                                                <p class="text-xs text-gray-500 mt-1">Admin note: {{ $latestRequest->admin_notes }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Verification Required</h3>
                                        <p class="text-sm text-gray-600">Upload your ID document to verify your identity</p>
                                    </div>
                                @endif
                            </div>
                            @if(!Auth::user()->hasVerificationRequest())
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Benefits of verification:</p>
                                    <ul class="text-sm text-gray-500 mt-1 space-y-1">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Increased trust with hosts and guests
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Access to premium features
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Higher booking acceptance rate
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        @php
                            $latestRequest = Auth::user()->latestVerificationRequest;
                        @endphp
                        @if(!$latestRequest || $latestRequest->status === 'rejected')
                            <button onclick="openVerificationModal()" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-300 inline-flex items-center shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                {{ $latestRequest && $latestRequest->status === 'rejected' ? 'Resubmit Verification' : 'Verify Identity' }}
                            </button>
                        @elseif($latestRequest->status === 'pending')
                            <div class="text-center">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 inline-block">
                                    <div class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="text-yellow-800 font-medium">Under Review</span>
                                    </div>
                                    <p class="text-yellow-700 text-sm mt-1">We'll notify you once your verification is complete</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                                                        @else
                                                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs text-gray-600">Completed</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            <div class="w-full bg-gray-200 rounded-full h-1">
                                                @php
                                                    $progressClass = 'w-1/3'; // Default 33%
                                                    if ($booking->status === 'completed') {
                                                        $progressClass = 'w-full'; // 100%
                                                    } elseif ($booking->status === 'confirmed') {
                                                        $progressClass = 'w-2/3'; // 66%
                                                    }
                                                @endphp
                                                <div class="bg-green-600 h-1 rounded-full transition-all duration-300 {{$progressClass}}"></div>
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
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">/antml:parameter>
</invoke>
    
    <script src="{{ asset('js/profile.js') }}"></script>

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
                        <div class="relative">
                            <input type="text" id="cityInput" list="moroccanCities" placeholder="Type to search cities..." 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-300">
                            <input type="hidden" name="city" id="cityHidden" required>
                            <datalist id="moroccanCities">
                                <option value="Agadir">Agadir</option>
                                <option value="Al Hoceima">Al Hoceima</option>
                                <option value="Assilah">Assilah</option>
                                <option value="Azemmour">Azemmour</option>
                                <option value="Beni Mellal">Beni Mellal</option>
                                <option value="Casablanca">Casablanca</option>
                                <option value="Chefchaouen">Chefchaouen</option>
                                <option value="El Jadida">El Jadida</option>
                                <option value="Erfoud">Erfoud</option>
                                <option value="Essaouira">Essaouira</option>
                                <option value="Fez">Fez</option>
                                <option value="Ifrane">Ifrane</option>
                                <option value="Kenitra">Kenitra</option>
                                <option value="Larache">Larache</option>
                                <option value="Marrakech">Marrakech</option>
                                <option value="Meknes">Meknes</option>
                                <option value="Merzouga">Merzouga</option>
                                <option value="Mohammedia">Mohammedia</option>
                                <option value="Nador">Nador</option>
                                <option value="Ouarzazate">Ouarzazate</option>
                                <option value="Oujda">Oujda</option>
                                <option value="Rabat">Rabat</option>
                                <option value="Safi">Safi</option>
                                <option value="Sale">Sale</option>
                                <option value="Tangier">Tangier</option>
                                <option value="Taroudant">Taroudant</option>
                                <option value="Taza">Taza</option>
                                <option value="Tetouan">Tetouan</option>
                                <option value="Tinghir">Tinghir</option>
                                <option value="Zagora">Zagora</option>
                            </datalist>
                        </div>
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

    <!-- Verification Modal -->
    <div id="verification-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-8 max-h-[90vh] overflow-y-auto shadow-2xl">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Verify Your Identity</h2>
                        <p class="text-sm text-gray-600 mt-1">Secure your account with document verification</p>
                    </div>
                </div>
                <button onclick="closeVerificationModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Progress Steps -->
            <div class="flex items-center justify-center mb-8">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">1</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Choose Document</span>
                    </div>
                    <div class="w-8 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Upload & Submit</span>
                    </div>
                </div>
            </div>

            <!-- Benefits Section -->
            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-6 mb-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Why verify your identity?</h3>
                        <div class="grid md:grid-cols-3 gap-4 text-sm text-gray-700">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Increased trust
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Premium features
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Higher acceptance
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form id="verification-form" class="space-y-8">
                @csrf
                
                <!-- Document Type Selection -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">
                        <span class="flex items-center">
                            <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                            Choose your document type
                        </span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="document-option relative cursor-pointer group">
                            <input type="radio" name="document_type" value="carte_nationale" required class="sr-only peer">
                            <div class="border-3 border-gray-200 rounded-xl p-6 text-center hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300 hover:shadow-lg group-hover:transform group-hover:scale-105">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-300">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Carte Nationale</h3>
                                <p class="text-sm text-gray-600">National ID Card</p>
                                <p class="text-xs text-gray-500 mt-2">Moroccan National Identity Card</p>
                            </div>
                        </label>
                        
                        <label class="document-option relative cursor-pointer group">
                            <input type="radio" name="document_type" value="passport" required class="sr-only peer">
                            <div class="border-3 border-gray-200 rounded-xl p-6 text-center hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-300 hover:shadow-lg group-hover:transform group-hover:scale-105">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:from-green-200 group-hover:to-green-300 transition-all duration-300">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Passport</h3>
                                <p class="text-sm text-gray-600">International Passport</p>
                                <p class="text-xs text-gray-500 mt-2">Any valid international passport</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Document Upload -->
                <div>
                    <label class="block text-lg font-semibold text-gray-900 mb-4">
                        <span class="flex items-center">
                            <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                            Upload your document
                        </span>
                    </label>
                    <div class="document-upload-area border-3 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition-all duration-300">
                        <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" required 
                            class="hidden" id="file-input">
                        
                        <div class="upload-content">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Drop your file here</h3>
                            <p class="text-gray-600 mb-4">
                                or <button type="button" onclick="document.getElementById('file-input').click()" class="text-blue-600 hover:text-blue-700 font-medium">browse files</button>
                            </p>
                            <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Max 5MB
                                </span>
                                <span>•</span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                    JPG, PNG, PDF
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-blue-500">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">🔒 Your privacy is protected</h4>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                Your document is encrypted and securely stored. We only use it for verification purposes and will never share it with third parties. The verification process typically takes 24-48 hours.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeVerificationModal()" 
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-all duration-300 hover:border-gray-400">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-semibold transition-all duration-300 inline-flex items-center shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit for Verification
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Functions -->
    <script>
        // Open password change modal
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close password change modal
        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable background scrolling
            // Reset form
            document.getElementById('password-form').reset();
        }

        // Handle password form submission
        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.innerHTML = '<svg class="w-4 h-4 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="4" stroke-opacity="0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Updating...';
            submitButton.disabled = true;

            fetch('{{ route("profile.change-password") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Password updated successfully!');
                    closePasswordModal();
                } else {
                    // Show error message
                    alert(data.message || 'An error occurred while updating password.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating password.');
            })
            .finally(() => {
                // Reset button state
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            });
        });

        // Close modal when clicking outside
        document.getElementById('passwordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePasswordModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePasswordModal();
            }
        });
    </script>

    <!-- Change Password Modal -->
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm">
        <div class="relative top-10 mx-auto p-0 border-0 w-full max-w-md shadow-2xl rounded-2xl bg-white my-8">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold">Change Password</h3>
                        <p class="text-orange-100 text-sm mt-1">Update your account password</p>
                    </div>
                    <button onclick="closePasswordModal()" class="text-orange-100 hover:text-white transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="password-form" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Current Password
                        </label>
                        <input type="password" name="current_password" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            New Password
                        </label>
                        <input type="password" name="new_password" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Confirm New Password
                        </label>
                        <input type="password" name="new_password_confirmation" required 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closePasswordModal()" 
                            class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200 border border-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
