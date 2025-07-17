<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Culturoo</title>
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
        .booking-card {
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
        
        .chat-container {
            height: 400px;
            overflow-y: auto;
        }
        .message-bubble {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            margin-bottom: 0.5rem;
        }
        .message-sent {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 0.25rem;
        }
        .message-received {
            background: #f3f4f6;
            color: #1f2937;
            margin-right: auto;
            border-bottom-left-radius: 0.25rem;
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
                        <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    @if(Auth::user()->isHost())
                        <a href="{{ route('host.dashboard') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Dashboard</a>
                    @endif
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Admin</a>
                    @endif
                    <a href="{{ route('profile') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Profile</a>
                    <span class="text-gray-700">{{ Auth::user()->first_name }}</span>
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

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('profile') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Profile
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Booking Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Booking Header -->
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">Booking Details</h1>
                            <p class="text-gray-600">Booking ID: #{{ $booking->id }}</p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-medium status-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <!-- Booking Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Dates & Guests</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-in:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Check-out:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} night{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) > 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Guests:</span>
                                    <span class="font-medium">{{ $booking->guests_count }} guest{{ $booking->guests_count > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Pricing</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Price per night:</span>
                                    <span class="font-medium">{{ number_format($booking->announcement->price_per_night, 0) }} MAD</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total nights:</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-semibold text-gray-900 border-t pt-2">
                                    <span>Total Price:</span>
                                    <span>{{ number_format($booking->total_price, 0) }} MAD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Timeline -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Booking Timeline</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-sm text-gray-600">Booking requested on {{ $booking->created_at->format('M d, Y \a\t H:i') }}</span>
                            </div>
                            @if($booking->status !== 'pending')
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-{{ $booking->status === 'confirmed' ? 'green' : 'red' }}-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">
                                        Booking {{ $booking->status }} 
                                        @if($booking->updated_at != $booking->created_at)
                                            on {{ $booking->updated_at->format('M d, Y \a\t H:i') }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Property Information -->
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Property Details</h3>
                    <div class="flex items-start space-x-4">
                        @if($booking->announcement->images && count($booking->announcement->images) > 0)
                            <img src="{{ asset('storage/' . $booking->announcement->images[0]) }}" 
                                 alt="{{ $booking->announcement->title }}" 
                                 class="w-24 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $booking->announcement->title }}</h4>
                            <p class="text-gray-600 flex items-center mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $booking->announcement->city }}
                            </p>
                            <p class="text-gray-600 mt-1">{{ ucfirst(str_replace('_', ' ', $booking->announcement->room_type)) }}</p>
                            <a href="{{ route('listings.show', $booking->announcement) }}" 
                               class="text-orange-600 hover:text-orange-700 text-sm font-medium mt-2 inline-block">
                                View Property Details →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Host Information -->
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Host Information</h3>
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xl font-bold">
                            @if($booking->host->profile_picture)
                                <img src="{{ asset('storage/' . $booking->host->profile_picture) }}" alt="Host" class="w-16 h-16 rounded-full object-cover">
                            @else
                                {{ strtoupper(substr($booking->host->first_name ?? $booking->host->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-gray-900">
                                {{ $booking->host->first_name ?? $booking->host->name }} {{ $booking->host->last_name }}
                            </div>
                            <div class="text-gray-600">{{ $booking->host->email }}</div>
                            <div class="text-sm text-gray-500">Host since {{ $booking->host->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Guest Message -->
                @if($booking->guest_message)
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Your Message to Host</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $booking->guest_message }}</p>
                    </div>
                </div>
                @endif

                <!-- Host Response -->
                @if($booking->host_response)
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Host Response</h3>
                    <div class="p-4 bg-orange-50 rounded-lg">
                        <p class="text-gray-700 leading-relaxed">{{ $booking->host_response }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Actions & Chat -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Action Buttons -->
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    
                    @if(Auth::user()->id === $booking->host_id)
                        <!-- Host Actions -->
                        @if($booking->status === 'pending')
                            <div class="space-y-3">
                                <textarea id="host-response" placeholder="Add a message for the guest (optional)..." 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                    rows="3"></textarea>
                                <div class="flex space-x-2">
                                    <button onclick="respondToBooking('confirmed')" 
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-300">
                                        Accept
                                    </button>
                                    <button onclick="respondToBooking('rejected')" 
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-300">
                                        Decline
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <p class="text-gray-600 mb-2">Booking {{ $booking->status }}</p>
                                @if($booking->status === 'confirmed')
                                    <p class="text-sm text-green-600">The guest's booking has been confirmed!</p>
                                @elseif($booking->status === 'rejected')
                                    <p class="text-sm text-red-600">This booking was declined.</p>
                                @endif
                            </div>
                        @endif
                    @else
                        <!-- Guest Actions -->
                        @if($booking->status === 'pending')
                            <div class="text-center p-4">
                                <svg class="w-12 h-12 text-yellow-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-600 mb-2">Waiting for host response</p>
                                <p class="text-sm text-gray-500">The host will review your booking request soon.</p>
                            </div>
                        @elseif($booking->status === 'confirmed')
                            <div class="text-center p-4">
                                <svg class="w-12 h-12 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-green-600 mb-2 font-medium">Booking Confirmed!</p>
                                <p class="text-sm text-gray-500">Your booking has been accepted by the host.</p>
                            </div>
                        @elseif($booking->status === 'rejected')
                            <div class="text-center p-4">
                                <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-red-600 mb-2 font-medium">Booking Declined</p>
                                <p class="text-sm text-gray-500">Unfortunately, this booking was not accepted.</p>
                            </div>
                        @endif

                        @if($booking->status === 'pending')
                            <button onclick="cancelBooking()" 
                                class="w-full mt-4 border border-red-300 text-red-600 hover:bg-red-50 py-2 px-4 rounded-lg font-medium transition-colors duration-300">
                                Cancel Request
                            </button>
                        @endif
                    @endif
                </div>

                <!-- Chat Section -->
                <div class="booking-card rounded-2xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Messages</h3>
                    
                    <!-- Chat Messages -->
                    <div id="chat-container" class="chat-container border border-gray-200 rounded-lg p-4 mb-4">
                        <div id="messages-list" class="space-y-2">
                            @forelse($booking->messages as $message)
                                <div class="message-bubble {{ $message->sender_id === Auth::user()->id ? 'message-sent' : 'message-received' }}">
                                    <p class="text-sm">{{ $message->message }}</p>
                                    <p class="text-xs opacity-75 mt-1">{{ $message->created_at->format('M d, H:i') }}</p>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-8">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-sm">No messages yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Message Input -->
                    <form id="message-form" class="flex space-x-2">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="text" name="message" placeholder="Type your message..." 
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                            required>
                        <button type="submit" class="btn-moroccan text-white px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const bookingId = {{ $booking->id }};
        const currentUserId = {{ Auth::user()->id }};

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

        // Host response to booking
        @if(Auth::user()->id === $booking->host_id && $booking->status === 'pending')
            function respondToBooking(status) {
                const response = document.getElementById('host-response').value;
                
                const submitButton = event.target;
                const originalText = submitButton.textContent;
                submitButton.textContent = 'Processing...';
                submitButton.disabled = true;
                
                fetch(`{{ route('bookings.respond', $booking) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status,
                        host_response: response
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message || 'Failed to update booking', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred. Please try again.', 'error');
                })
                .finally(() => {
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                });
            }
        @endif

        // Guest cancel booking
        @if(Auth::user()->id === $booking->guest_id && $booking->status === 'pending')
            function cancelBooking() {
                if (!confirm('Are you sure you want to cancel this booking request?')) {
                    return;
                }
                
                fetch(`{{ route('bookings.respond', $booking) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'cancelled'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showAlert(data.message || 'Failed to cancel booking', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred. Please try again.', 'error');
                });
            }
        @endif

        // Message sending
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const messageInput = this.querySelector('input[name="message"]');
            const message = messageInput.value.trim();
            
            if (!message) return;
            
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            
            fetch(`{{ route('bookings.message', $booking) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add message to chat
                    addMessageToChat(message, true);
                    messageInput.value = '';
                } else {
                    showAlert(data.message || 'Failed to send message', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
            });
        });

        function addMessageToChat(message, isSent) {
            const messagesList = document.getElementById('messages-list');
            const noMessagesDiv = messagesList.querySelector('.text-center');
            
            if (noMessagesDiv) {
                noMessagesDiv.remove();
            }
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `message-bubble ${isSent ? 'message-sent' : 'message-received'}`;
            
            const now = new Date();
            const timeString = now.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric', 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
            
            messageDiv.innerHTML = `
                <p class="text-sm">${message}</p>
                <p class="text-xs opacity-75 mt-1">${timeString}</p>
            `;
            
            messagesList.appendChild(messageDiv);
            
            // Scroll to bottom
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Auto-scroll chat to bottom on load
        document.addEventListener('DOMContentLoaded', function() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    </script>
</body>
</html>
