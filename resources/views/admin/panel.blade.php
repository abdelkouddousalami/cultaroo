<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Culturoo</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --dropdown-open: false;
        }
        
        body {
            isolation: isolate;
        }
        
        /* Admin nav specific styles */
        nav {
            position: relative;
            z-index: 10;
        }

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
        .admin-card {
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
            will-change: transform, opacity;
            transform: translateZ(0);
            backface-visibility: hidden;
            position: absolute !important;
            z-index: 9999 !important;
            isolation: isolate;
        }

        /* Add a specific stacking context for dropdown container */
        .relative {
            position: relative;
            isolation: isolate;
        }

        /* Enhanced dropdown styling */
        .dropdown-wrapper {
            position: relative;
            isolation: isolate;
            z-index: 1000;
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
                    
                    <!-- User Profile Dropdown -->
                    <div class="relative dropdown-wrapper">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors duration-300 p-2 rounded-lg hover:bg-orange-50">
                            <div class="text-right mr-2">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->first_name ?? Auth::user()->name }}</p>
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full font-medium">
                                    Admin
                                </span>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white text-sm font-bold">
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
                        <div id="user-menu" class="absolute right-0 mt-2 w-[250px] bg-white rounded-xl shadow-2xl border-2 border-red-200 py-3 hidden" style="z-index: 9999; position: absolute; transform: translateZ(0); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                            <!-- User Info Section -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="font-medium text-gray-900 text-base">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
                                <div class="mt-2">
                                    <span class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded-full font-medium">
                                        Admin Panel
                                    </span>
                                </div>
                            </div>

                            <!-- Dropdown Actions -->
                            <div class="py-2">
                                <!-- Profile Link -->
                                <a href="{{ route('profile') }}" class="dropdown-item font-medium text-base py-3">
                                    My Profile
                                </a>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <!-- Admin Dashboard Header -->
        <div class="admin-card rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">Admin Dashboard</h1>
                    <p class="text-gray-600">Manage users, host applications, and platform statistics</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</div>
                    <div class="text-sm text-gray-600">Total Users</div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_visitors'] }}</div>
                    <div class="text-sm text-blue-800">Visitors</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_hosts'] }}</div>
                    <div class="text-sm text-green-800">Hosts</div>
                </div>
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['total_admins'] }}</div>
                    <div class="text-sm text-red-800">Admins</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_applications'] }}</div>
                    <div class="text-sm text-yellow-800">Pending Apps</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['recent_users'] }}</div>
                    <div class="text-sm text-purple-800">New Users (7d)</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="admin-card rounded-2xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Host Applications Overview</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending Applications</span>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">{{ $stats['pending_applications'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Approved Applications</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">{{ $stats['approved_applications'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Rejected Applications</span>
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">{{ $stats['rejected_applications'] }}</span>
                    </div>
                    <div class="pt-2 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-900">Total Applications</span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">{{ $stats['total_applications'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card rounded-2xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">{{ $stats['recent_users'] }} new users registered this week</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">{{ $stats['recent_applications'] }} host applications submitted this week</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-600">{{ $stats['pending_applications'] }} applications awaiting review</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Management -->
        <div class="admin-card rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6">
                <h2 class="text-2xl font-bold">User Management</h2>
                <p class="text-red-100">Manage user roles and permissions</p>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $user->first_name ?? $user->name }} {{ $user->last_name }}
                                            </div>
                                            @if($user->country)
                                                <div class="text-sm text-gray-500">{{ $user->country }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst($user->user_type ?? 'traveler') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-{{ $user->role_color }}-100 text-{{ $user->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $user->role_display }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($user->id !== Auth::id())
                                        <select onchange="updateUserRole({{ $user->id }}, this.value)" class="text-sm border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500">
                                            <option value="visitor" {{ $user->role === 'visitor' ? 'selected' : '' }}>Visitor</option>
                                            <option value="host" {{ $user->role === 'host' ? 'selected' : '' }}>Host</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    @else
                                        <span class="text-gray-400 text-xs">Current User</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Host Applications Management -->
        @if($stats['total_applications'] > 0)
        <div class="admin-card rounded-2xl shadow-lg overflow-hidden mt-8">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">Host Applications</h2>
                        <p class="text-purple-100">Review visitor requests to become hosts</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold">{{ $stats['pending_applications'] }}</div>
                        <div class="text-sm text-purple-100">Pending Review</div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Filter Tabs -->
                <div class="flex space-x-2 mb-6">
                    <button id="filter-all" onclick="filterApplications('all')" class="px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-purple-600 text-white">
                        All ({{ $stats['total_applications'] }})
                    </button>
                    <button id="filter-pending" onclick="filterApplications('pending')" class="px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Pending ({{ $stats['pending_applications'] }})
                    </button>
                    <button id="filter-approved" onclick="filterApplications('approved')" class="px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Approved ({{ $stats['approved_applications'] }})
                    </button>
                    <button id="filter-rejected" onclick="filterApplications('rejected')" class="px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Rejected ({{ $stats['rejected_applications'] }})
                    </button>
                </div>

                <div class="space-y-6" id="applications-container">
                    @foreach($hostApplications as $application)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-300 application-item" data-status="{{ $application->status }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($application->user->first_name ?? $application->user->name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $application->user->first_name ?? $application->user->name }} {{ $application->user->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $application->user->email }}</div>
                                    <div class="text-sm text-gray-500">Applied on {{ $application->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-{{ $application->status_color }}-100 text-{{ $application->status_color }}-800">
                                {{ $application->status_display }}
                            </span>
                        </div>

                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700">City:</span>
                                <p class="text-sm text-gray-900">{{ $application->city }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Family Size:</span>
                                <p class="text-sm text-gray-900">{{ $application->family_members_count }} member{{ $application->family_members_count > 1 ? 's' : '' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Languages:</span>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach($application->languages as $language)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $language }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Amenities Count:</span>
                                <p class="text-sm text-gray-900">{{ count($application->amenities) }} items</p>
                            </div>
                        </div>

                        <!-- Full Motivation Text -->
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-700">Motivation:</span>
                            <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-900 leading-relaxed">{{ $application->motivation }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="text-xs font-medium text-gray-600">Amenities:</span>
                            @foreach($application->amenities as $amenity)
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $amenity }}</span>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <div class="flex space-x-2">
                                <a href="{{ asset('storage/' . $application->national_id_document) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">View National ID</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ asset('storage/' . $application->house_ownership_document) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">View House Document</a>
                            </div>
                            
                            @if($application->isPending())
                                <div class="space-y-3">
                                    <!-- Admin Notes Input -->
                                    <div>
                                        <label for="admin-notes-{{ $application->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                            Admin Notes (Optional)
                                        </label>
                                        <textarea 
                                            id="admin-notes-{{ $application->id }}" 
                                            placeholder="Add notes for the applicant..."
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 text-sm"
                                            rows="2"></textarea>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <button onclick="reviewApplication({{ $application->id }}, 'rejected')" 
                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-300">
                                            Reject
                                        </button>
                                        <button onclick="reviewApplication({{ $application->id }}, 'approved')" 
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-300">
                                            Approve
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-gray-500">
                                    Reviewed {{ $application->reviewed_at->diffForHumans() }}
                                    @if($application->reviewer)
                                        by {{ $application->reviewer->first_name }}
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if($application->admin_notes)
                            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Admin Notes:</span>
                                <p class="text-sm text-gray-900 mt-1">{{ $application->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Host Applications Pagination -->
                @if($hostApplications->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $hostApplications->links() }}
                    </div>
                @endif
            </div>
        </div>
        @endif

    </div>

    @vite('resources/js/app.js')
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
                    
                    // Force reflow to ensure the menu is visible and properly sized
                    void userMenu.offsetWidth;
                    
                    // Ensure the menu is properly positioned and visible
                    const menuRect = userMenu.getBoundingClientRect();
                    const viewportWidth = window.innerWidth;
                    
                    // Make sure the dropdown is on top of other elements
                    userMenu.style.zIndex = '9999';
                    
                    // Add CSS custom property to help with stacking context
                    document.documentElement.style.setProperty('--dropdown-open', 'true');
                    
                    // If menu is going off-screen, adjust position
                    if (menuRect.right > viewportWidth) {
                        userMenu.style.left = 'auto';
                        userMenu.style.right = '0';
                    }
                    
                    // Apply 3D transform to help with layering
                    userMenu.style.transform = 'translateZ(0)';
                    userMenu.style.isolation = 'isolate';
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
                    document.documentElement.style.removeProperty('--dropdown-open');
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
        // Set up CSRF token for AJAX requests
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            
            alertContainer.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function updateUserRole(userId, newRole) {
            fetch(`/admin/users/${userId}/role`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    role: newRole
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    // Reload the page to show updated role badges
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || 'Failed to update user role', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while updating the user role', 'error');
            });
        }

        function reviewApplication(applicationId, action) {
            // Get admin notes if any
            const notesTextarea = document.getElementById(`admin-notes-${applicationId}`);
            const adminNotes = notesTextarea ? notesTextarea.value.trim() : '';
            
            const url = `/admin/host-applications/${applicationId}/review`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: action,
                    admin_notes: adminNotes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    // Reload the page to show updated application status
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || 'Failed to update application status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while updating the application status', 'error');
            });
        }

        function filterApplications(status) {
            const applications = document.querySelectorAll('.application-item');
            const filterButtons = document.querySelectorAll('[id^="filter-"]');
            
            // Reset button styles
            filterButtons.forEach(btn => {
                btn.className = 'px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-gray-200 text-gray-700 hover:bg-gray-300';
            });
            
            // Highlight active button
            document.getElementById(`filter-${status}`).className = 'px-4 py-2 rounded-lg font-medium transition-colors duration-300 bg-purple-600 text-white';
            
            // Filter applications
            applications.forEach(app => {
                if (status === 'all' || app.getAttribute('data-status') === status) {
                    app.style.display = 'block';
                } else {
                    app.style.display = 'none';
                }
            });
        }

        // On page load, check the URL for a status parameter and filter applications accordingly
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status) {
                filterApplications(status);
            }
            
            // Add resize event listener to handle dropdown positioning
            window.addEventListener('resize', function() {
                const userMenu = document.getElementById('user-menu');
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    // Reposition the menu if it's open
                    const menuRect = userMenu.getBoundingClientRect();
                    const viewportWidth = window.innerWidth;
                    
                    if (menuRect.right > viewportWidth) {
                        userMenu.style.left = 'auto';
                        userMenu.style.right = '0';
                    }
                }
            });
        });
    </script>
</body>
</html>
