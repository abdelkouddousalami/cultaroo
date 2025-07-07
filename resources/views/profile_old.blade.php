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
    </style>
</head>
<body class="font-['Inter'] text-gray-800 bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-24 w-auto">
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}#home" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('welcome') }}#experiences" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('welcome') }}#families" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('welcome') }}#about" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('welcome') }}#contact" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Hello, {{ Auth::user()->first_name ?? Auth::user()->name }}!</span>
                    <form action="{{ route('auth.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen pt-28 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-32"></div>
                <div class="px-8 pb-8">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16">
                        <div class="relative">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="profile-image bg-white">
                            @else
                                <div class="profile-image bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-3xl font-bold">
                                    {{ strtoupper(substr(Auth::user()->first_name ?? Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left">
                            <h1 class="text-3xl font-['Playfair_Display'] font-bold text-gray-800">
                                {{ Auth::user()->first_name && Auth::user()->last_name ? Auth::user()->first_name . ' ' . Auth::user()->last_name : Auth::user()->name }}
                            </h1>
                            <p class="text-orange-600 font-medium capitalize">{{ Auth::user()->user_type ?? 'Traveler' }}</p>
                            @if(Auth::user()->city && Auth::user()->country)
                                <p class="text-gray-600">📍 {{ Auth::user()->city }}, {{ Auth::user()->country }}</p>
                            @endif
                            @if(Auth::user()->is_verified)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-2">
                                    ✓ Verified Member
                                </span>
                            @endif
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-auto">
                            <button onclick="switchTab('edit')" class="btn-moroccan text-white px-6 py-2 rounded-lg font-medium">
                                Edit Profile
                            </button>
                        </div>
                    </div>
                    @if(Auth::user()->bio)
                        <div class="mt-6">
                            <p class="text-gray-700 leading-relaxed">{{ Auth::user()->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex border-b">
                    <button id="profile-tab" class="flex-1 py-4 px-6 text-center font-semibold transition-all duration-300 tab-active" onclick="switchTab('profile')">
                        Profile Info
                    </button>
                    <button id="edit-tab" class="flex-1 py-4 px-6 text-center font-semibold transition-all duration-300 tab-inactive" onclick="switchTab('edit')">
                        Edit Profile
                    </button>
                    <button id="security-tab" class="flex-1 py-4 px-6 text-center font-semibold transition-all duration-300 tab-inactive" onclick="switchTab('security')">
                        Security
                    </button>
                </div>

                <div class="p-8">
                    <!-- Profile Info Tab -->
                    <div id="profile-content" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Email:</span>
                                        <p class="text-gray-800">{{ Auth::user()->email }}</p>
                                    </div>
                                    @if(Auth::user()->phone)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Phone:</span>
                                            <p class="text-gray-800">{{ Auth::user()->phone }}</p>
                                        </div>
                                    @endif
                                    @if(Auth::user()->date_of_birth)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Date of Birth:</span>
                                            <p class="text-gray-800">{{ \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('F d, Y') }}</p>
                                        </div>
                                    @endif
                                    @if(Auth::user()->gender)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Gender:</span>
                                            <p class="text-gray-800 capitalize">{{ str_replace('_', ' ', Auth::user()->gender) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Preferences</h3>
                                <div class="space-y-3">
                                    @if(Auth::user()->languages)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Languages:</span>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                @foreach(Auth::user()->languages as $language)
                                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-sm capitalize">{{ $language }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if(Auth::user()->interests)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Interests:</span>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                @foreach(Auth::user()->interests as $interest)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm capitalize">{{ $interest }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Member since:</span>
                                        <p class="text-gray-800">{{ Auth::user()->created_at->format('F Y') }}</p>
                                    </div>
                                    @if(Auth::user()->last_active_at)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Last active:</span>
                                            <p class="text-gray-800">{{ \Carbon\Carbon::parse(Auth::user()->last_active_at)->diffForHumans() }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Tab -->
                    <div id="edit-content" class="hidden">
                        <form id="profile-form" class="space-y-6">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                <textarea id="bio" name="bio" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Tell us about yourself...">{{ Auth::user()->bio }}</textarea>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">User Type</label>
                                    <select id="user_type" name="user_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="traveler" {{ Auth::user()->user_type === 'traveler' ? 'selected' : '' }}>Traveler</option>
                                        <option value="host" {{ Auth::user()->user_type === 'host' ? 'selected' : '' }}>Host</option>
                                        <option value="both" {{ Auth::user()->user_type === 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                    <input type="text" id="country" name="country" value="{{ Auth::user()->country }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                    <input type="text" id="city" name="city" value="{{ Auth::user()->city }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                    <select id="gender" name="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ Auth::user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ Auth::user()->gender === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <p class="text-sm text-gray-500 mt-1">Upload a new profile picture (optional)</p>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="btn-moroccan text-white px-8 py-3 rounded-lg font-semibold">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Tab -->
                    <div id="security-content" class="hidden">
                        <div class="max-w-md space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>
                            <form id="password-form" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" id="new_password" name="new_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                </div>
                                <button type="submit" class="btn-moroccan text-white px-6 py-3 rounded-lg font-semibold">
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div id="message-container" class="mt-6 hidden">
                        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded hidden">
                        </div>
                        <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded hidden">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        // Tab switching functionality
        function switchTab(tabName) {
            const tabs = ['profile', 'edit', 'security'];
            
            tabs.forEach(tab => {
                const tabButton = document.getElementById(tab + '-tab');
                const tabContent = document.getElementById(tab + '-content');
                
                if (tab === tabName) {
                    tabButton.className = 'flex-1 py-4 px-6 text-center font-semibold transition-all duration-300 tab-active';
                    tabContent.classList.remove('hidden');
                } else {
                    tabButton.className = 'flex-1 py-4 px-6 text-center font-semibold transition-all duration-300 tab-inactive';
                    tabContent.classList.add('hidden');
                }
            });
        }

        // Profile form submission
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this, '{{ route("profile.update") }}');
        });

        // Password form submission
        document.getElementById('password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this, '{{ route("profile.change-password") }}');
        });

        function handleFormSubmit(form, url) {
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            // Show loading state
            submitButton.textContent = 'Processing...';
            submitButton.disabled = true;

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Reload page after profile update to show new data
                    if (url.includes('profile/update')) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Clear password form
                        form.reset();
                    }
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
        }

        function showMessage(message, type) {
            const messageContainer = document.getElementById('message-container');
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');

            // Hide all messages first
            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');

            if (type === 'success') {
                successMessage.textContent = message;
                successMessage.classList.remove('hidden');
            } else {
                errorMessage.textContent = message;
                errorMessage.classList.remove('hidden');
            }

            messageContainer.classList.remove('hidden');

            // Auto-hide after 5 seconds
            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, 5000);
        }
    </script>
</body>
</html>
