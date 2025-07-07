<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Dashboard - Culturoo</title>
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
        .host-card {
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
                    <a href="{{ route('profile') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Profile</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                            Admin Panel
                        </a>
                    @endif
                    <span class="text-gray-700">Host: <span class="font-semibold text-green-600">{{ Auth::user()->first_name }}</span></span>
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <!-- Dashboard Header -->
        <div class="host-card rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">Host Dashboard</h1>
                    <p class="text-gray-600">Manage your hosting announcements and bookings</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('host.announcements.create') }}" class="btn-moroccan text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Listing
                    </a>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_announcements'] }}</div>
                    <div class="text-sm text-blue-800">Total Listings</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['active_announcements'] }}</div>
                    <div class="text-sm text-green-800">Active Listings</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_bookings'] }}</div>
                    <div class="text-sm text-purple-800">Total Bookings</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_bookings'] }}</div>
                    <div class="text-sm text-yellow-800">Pending</div>
                </div>
                <div class="bg-indigo-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-indigo-600">{{ $stats['confirmed_bookings'] }}</div>
                    <div class="text-sm text-indigo-800">Confirmed</div>
                </div>
                <div class="bg-orange-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($stats['total_earnings'], 2) }} MAD</div>
                    <div class="text-sm text-orange-800">Total Earnings</div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- My Announcements -->
            <div class="host-card rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
                    <h2 class="text-2xl font-bold">My Hosting Announcements</h2>
                    <p class="text-green-100">Manage your active listings</p>
                </div>

                <div class="p-6">
                    @if($announcements->count() > 0)
                        <div class="space-y-4">
                            @foreach($announcements->take(5) as $announcement)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $announcement->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">{{ $announcement->price_per_night }} MAD/night</span> • 
                                        <span>{{ $announcement->room_type_display }}</span> • 
                                        <span>{{ $announcement->city }}</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">{{ $announcement->bookings->count() }} bookings</div>
                                    </div>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach($announcement->languages as $language)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $language }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($announcements->count() > 5)
                            <div class="mt-4 text-center">
                                <span class="text-sm text-gray-500">Showing 5 of {{ $announcements->count() }} announcements</span>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hosting announcements yet</h3>
                            <p class="text-gray-500 mb-4">Create your first hosting announcement to start welcoming guests.</p>
                            <a href="{{ route('host.announcements.create') }}" class="btn-moroccan text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create First Listing
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="host-card rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6">
                    <h2 class="text-2xl font-bold">Recent Bookings</h2>
                    <p class="text-purple-100">Latest booking requests and confirmations</p>
                </div>

                <div class="p-6">
                    @if($recentBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-300">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $booking->announcement->title }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $booking->status_color }}-100 text-{{ $booking->status_color }}-800">
                                        {{ $booking->status_display }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <div>{{ $booking->check_in_date->format('M d') }} - {{ $booking->check_out_date->format('M d, Y') }}</div>
                                    <div>{{ $booking->guests_count }} {{ $booking->guests_count === 1 ? 'guest' : 'guests' }} • {{ $booking->total_price }} MAD</div>
                                </div>
                                <div class="mt-2 flex justify-end space-x-2">
                                    <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        View Details
                                    </a>
                                    @if($booking->isPending())
                                        <button onclick="respondToBooking({{ $booking->id }}, 'confirm')" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                            Confirm
                                        </button>
                                        <button onclick="respondToBooking({{ $booking->id }}, 'cancel')" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            Decline
                                        </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-8 0h8m-8 0l-2 2m8-2l2 2m-2 14h-8a2 2 0 01-2-2V9a2 2 0 012-2h8a2 2 0 012 2v14a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No bookings yet</h3>
                            <p class="text-gray-500">Once guests start booking your listings, they will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pending Bookings (if any) -->
        @if($pendingBookings->count() > 0)
        <div class="host-card rounded-2xl shadow-lg overflow-hidden mt-8">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6">
                <h2 class="text-2xl font-bold">Pending Bookings</h2>
                <p class="text-yellow-100">{{ $pendingBookings->count() }} booking{{ $pendingBookings->count() === 1 ? '' : 's' }} awaiting your response</p>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    @foreach($pendingBookings as $booking)
                    <div class="border border-yellow-200 bg-yellow-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $booking->guest->email }}</p>
                                <p class="text-sm font-medium text-gray-700 mt-1">{{ $booking->announcement->title }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                Pending Response
                            </span>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="text-sm font-medium text-gray-700">Check-in:</span>
                                <p class="text-sm text-gray-900">{{ $booking->check_in_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Check-out:</span>
                                <p class="text-sm text-gray-900">{{ $booking->check_out_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Guests:</span>
                                <p class="text-sm text-gray-900">{{ $booking->guests_count }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-700">Total Price:</span>
                                <p class="text-sm text-gray-900 font-semibold">{{ $booking->total_price }} MAD</p>
                            </div>
                        </div>

                        @if($booking->guest_message)
                        <div class="mb-4">
                            <span class="text-sm font-medium text-gray-700">Guest Message:</span>
                            <div class="mt-1 p-3 bg-white rounded-lg border">
                                <p class="text-sm text-gray-900">{{ $booking->guest_message }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View Full Details & Chat
                            </a>
                            <div class="flex space-x-2">
                                <button onclick="respondToBooking({{ $booking->id }}, 'cancel')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-300">
                                    Decline
                                </button>
                                <button onclick="respondToBooking({{ $booking->id }}, 'confirm')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-300">
                                    Confirm Booking
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    @vite('resources/js/app.js')
    <script>
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = message;
            
            alertContainer.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function respondToBooking(bookingId, action) {
            const message = action === 'confirm' 
                ? 'Are you sure you want to confirm this booking?' 
                : 'Are you sure you want to decline this booking?';
            
            if (!confirm(message)) {
                return;
            }

            fetch(`/bookings/${bookingId}/respond`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showAlert(data.message || 'Failed to update booking', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            });
        }
    </script>
</body>
</html>
