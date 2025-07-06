<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Culturoo</title>
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
    <nav class="bg-white/95 backdrop-blur-sm shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-16 w-auto">
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="text-gray-700">Welcome, <span class="font-semibold text-orange-600">{{ Auth::user()->first_name ?? Auth::user()->name }}</span></span>
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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
                    <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </h1>
                    <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ ucfirst(Auth::user()->user_type ?? 'traveler') }}
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
                </div>
            </div>
        </div>

        <!-- Profile Information Tabs -->
        <div class="profile-card rounded-2xl shadow-lg overflow-hidden">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200">
                <button onclick="showTab('profile')" id="profile-tab" class="flex-1 py-4 px-6 text-center font-medium text-orange-600 border-b-2 border-orange-600 bg-orange-50">
                    Profile Information
                </button>
                <button onclick="showTab('password')" id="password-tab" class="flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-orange-600 transition-colors duration-300">
                    Change Password
                </button>
            </div>

            <!-- Profile Information Tab -->
            <div id="profile-content" class="p-8">
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
                    <div class="mt-8">
                        <button type="submit" class="btn-moroccan text-white px-8 py-3 rounded-lg font-medium inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Tab -->
            <div id="password-content" class="p-8 hidden">
                <form id="password-form">
                    @csrf
                    <div class="max-w-md">
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                            <input type="password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="new_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                        </div>
                        <div class="mb-6">
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

    @vite('resources/js/app.js')
    <script>
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Tab switching
        function showTab(tabName) {
            // Hide all content
            document.getElementById('profile-content').classList.add('hidden');
            document.getElementById('password-content').classList.add('hidden');

            // Remove active styles from all tabs
            document.getElementById('profile-tab').className = 'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-orange-600 transition-colors duration-300';
            document.getElementById('password-tab').className = 'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-orange-600 transition-colors duration-300';

            // Show selected content and activate tab
            if (tabName === 'profile') {
                document.getElementById('profile-content').classList.remove('hidden');
                document.getElementById('profile-tab').className = 'flex-1 py-4 px-6 text-center font-medium text-orange-600 border-b-2 border-orange-600 bg-orange-50';
            } else if (tabName === 'password') {
                document.getElementById('password-content').classList.remove('hidden');
                document.getElementById('password-tab').className = 'flex-1 py-4 px-6 text-center font-medium text-orange-600 border-b-2 border-orange-600 bg-orange-50';
            }
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

            // Auto-hide after 5 seconds
            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        // Profile form submission
        document.getElementById('profile-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
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
                    // Update the profile header if name changed
                    if (data.user) {
                        location.reload();
                    }
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
    </script>
</body>
</html>
