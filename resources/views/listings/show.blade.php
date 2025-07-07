<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} - Culturoo</title>
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
        .listing-card {
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
        .image-gallery {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0.5rem;
            height: 400px;
        }
        .main-image {
            grid-row: span 2;
        }
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .gallery-image:hover {
            transform: scale(1.05);
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
                    @auth
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
                    @else
                        <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                            Login / Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('listings.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Listings
            </a>
        </div>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Listing Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title and Host Info -->
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">{{ $announcement->title }}</h1>
                            <div class="flex items-center text-gray-600 space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $announcement->city }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $announcement->max_guests }} guest{{ $announcement->max_guests > 1 ? 's' : '' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4"></path>
                                    </svg>
                                    {{ ucfirst(str_replace('_', ' ', $announcement->room_type)) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-orange-600">{{ number_format($announcement->price_per_night, 0) }} MAD</div>
                            <div class="text-sm text-gray-500">per night</div>
                        </div>
                    </div>

                    <!-- Host Information -->
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-lg font-bold">
                            @if($announcement->host->profile_picture)
                                <img src="{{ asset('storage/' . $announcement->host->profile_picture) }}" alt="Host" class="w-12 h-12 rounded-full object-cover">
                            @else
                                {{ strtoupper(substr($announcement->host->first_name ?? $announcement->host->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">
                                Hosted by {{ $announcement->host->first_name ?? $announcement->host->name }} {{ $announcement->host->last_name }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Host since {{ $announcement->host->created_at->format('M Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Gallery -->
                @if($announcement->images && count($announcement->images) > 0)
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Photos</h2>
                    <div class="image-gallery rounded-lg overflow-hidden">
                        @foreach($announcement->images as $index => $image)
                            <div class="{{ $index === 0 ? 'main-image' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" alt="Listing Image {{ $index + 1 }}" 
                                     class="gallery-image" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                            </div>
                            @if($index >= 4) @break @endif
                        @endforeach
                    </div>
                    @if(count($announcement->images) > 5)
                        <p class="text-sm text-gray-500 mt-2">+ {{ count($announcement->images) - 5 }} more photos</p>
                    @endif
                </div>
                @endif

                <!-- Description -->
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">About this place</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $announcement->description }}</p>
                </div>

                <!-- Address -->
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Location</h2>
                    <p class="text-gray-700">{{ $announcement->address }}</p>
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            The exact address will be shared after booking confirmation for security reasons.
                        </p>
                    </div>
                </div>

                <!-- Languages -->
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Languages Spoken</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($announcement->languages as $language)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $language }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Amenities -->
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($announcement->amenities as $amenity)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ $amenity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- House Rules -->
                @if($announcement->house_rules && count($announcement->house_rules) > 0)
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">House Rules</h2>
                    <ul class="space-y-2">
                        @foreach($announcement->house_rules as $rule)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-gray-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-gray-700">{{ $rule }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Special Notes -->
                @if($announcement->special_notes)
                <div class="listing-card rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Special Notes</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $announcement->special_notes }}</p>
                </div>
                @endif
            </div>

            <!-- Right Column - Booking Widget -->
            <div class="lg:col-span-1">
                <div class="listing-card rounded-2xl p-6 shadow-lg sticky top-6">
                    @auth
                        @if(Auth::user()->id !== $announcement->host_id)
                            <form id="booking-form" class="space-y-4">
                                @csrf
                                <input type="hidden" name="announcement_id" value="{{ $announcement->id }}">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                                    <input type="date" name="check_in_date" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                                    <input type="date" name="check_out_date" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                                    <select name="guests_count" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                                        @for($i = 1; $i <= $announcement->max_guests; $i++)
                                            <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Message to Host</label>
                                    <textarea name="message" rows="3" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                                        placeholder="Tell the host about your travel plans..."></textarea>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span>Price per night</span>
                                        <span>{{ number_format($announcement->price_per_night, 0) }} MAD</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                                        <span id="nights-count">0 nights</span>
                                        <span id="total-nights-price">0 MAD</span>
                                    </div>
                                    <div class="flex justify-between font-semibold text-lg text-gray-900 border-t border-gray-200 pt-2">
                                        <span>Total</span>
                                        <span id="total-price">0 MAD</span>
                                    </div>
                                </div>
                                
                                <button type="submit" class="w-full btn-moroccan text-white py-3 rounded-lg font-medium transition-colors duration-300">
                                    Request Booking
                                </button>
                            </form>
                        @else
                            <div class="text-center p-6">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 5v4"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">This is your listing</h3>
                                <p class="text-gray-600 mb-4">You cannot book your own property</p>
                                <a href="{{ route('host.dashboard') }}" class="btn-moroccan text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                                    Manage Listing
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center p-6">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Login Required</h3>
                            <p class="text-gray-600 mb-4">Please login to book this accommodation</p>
                            <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300">
                                Login / Register
                            </a>
                        </div>
                    @endauth

                    <!-- Contact Host -->
                    @auth
                        @if(Auth::user()->id !== $announcement->host_id)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <button onclick="openChatModal()" class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-300">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    Contact Host
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold z-10">
                ×
            </button>
            <img id="modal-image" src="" alt="Full size image" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    <!-- Chat Modal -->
    <div id="chat-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full max-h-96 flex flex-col">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Contact Host</h3>
                <button onclick="closeChatModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="message-form" class="p-4">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $announcement->host_id }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea name="message" rows="4" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Ask about availability, amenities, or anything else..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeChatModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 btn-moroccan text-white rounded-lg">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const pricePerNight = {{ $announcement->price_per_night }};

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

        // Image modal functions
        function openImageModal(imageSrc) {
            document.getElementById('modal-image').src = imageSrc;
            document.getElementById('image-modal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('image-modal').classList.add('hidden');
        }

        // Chat modal functions
        function openChatModal() {
            document.getElementById('chat-modal').classList.remove('hidden');
        }

        function closeChatModal() {
            document.getElementById('chat-modal').classList.add('hidden');
        }

        // Booking form calculations
        function calculateTotal() {
            const checkIn = document.querySelector('input[name="check_in_date"]').value;
            const checkOut = document.querySelector('input[name="check_out_date"]').value;
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const timeDiff = checkOutDate.getTime() - checkInDate.getTime();
                const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                if (nights > 0) {
                    const total = nights * pricePerNight;
                    document.getElementById('nights-count').textContent = `${nights} night${nights > 1 ? 's' : ''}`;
                    document.getElementById('total-nights-price').textContent = `${total.toLocaleString()} MAD`;
                    document.getElementById('total-price').textContent = `${total.toLocaleString()} MAD`;
                } else {
                    document.getElementById('nights-count').textContent = '0 nights';
                    document.getElementById('total-nights-price').textContent = '0 MAD';
                    document.getElementById('total-price').textContent = '0 MAD';
                }
            }
        }

        // Set up date inputs
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const checkInInput = document.querySelector('input[name="check_in_date"]');
            const checkOutInput = document.querySelector('input[name="check_out_date"]');
            
            if (checkInInput && checkOutInput) {
                checkInInput.setAttribute('min', today);
                checkOutInput.setAttribute('min', today);
                
                checkInInput.addEventListener('change', function() {
                    checkOutInput.setAttribute('min', this.value);
                    if (checkOutInput.value && checkOutInput.value <= this.value) {
                        checkOutInput.value = '';
                    }
                    calculateTotal();
                });
                
                checkOutInput.addEventListener('change', calculateTotal);
            }
        });

        // Booking form submission
        @auth
            @if(Auth::user()->id !== $announcement->host_id)
                document.getElementById('booking-form').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Processing...';
                    submitButton.disabled = true;
                    
                    try {
                        const formData = new FormData(this);
                        
                        const response = await fetch('{{ route("bookings.store") }}', {
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
                            setTimeout(() => {
                                window.location.href = data.redirect || '{{ route("profile") }}';
                            }, 1500);
                        } else {
                            showAlert(data.message || 'Failed to create booking request', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again.', 'error');
                    } finally {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                    }
                });
            @endif
        @endauth

        // Message form submission
        @auth
            @if(Auth::user()->id !== $announcement->host_id)
                document.getElementById('message-form').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Sending...';
                    submitButton.disabled = true;
                    
                    try {
                        const formData = new FormData(this);
                        
                        const response = await fetch('{{ route("messages.send") }}', {
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
                            closeChatModal();
                            this.reset();
                        } else {
                            showAlert(data.message || 'Failed to send message', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again.', 'error');
                    } finally {
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                    }
                });
            @endif
        @endauth

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
                closeChatModal();
            }
        });
    </script>
</body>
</html>
