<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Culturoo - Experience Authentic Moroccan Culture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .moroccan-pattern {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><pattern id="pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M30 0L60 30L30 60L0 30Z" fill="none" stroke="rgba(139,69,19,0.05)" stroke-width="1"/></pattern></defs><rect width="60" height="60" fill="url(%23pattern)"/></svg>');
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
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 50%, #FED7AA 100%);
        }
        .form-transition {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .slide-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        .slide-exit {
            transform: translateX(-100%);
            opacity: 0;
        }
        .input-focus {
            transition: all 0.3s ease;
        }
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 69, 19, 0.1);
        }
        .social-btn {
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body class="font-['Inter'] text-gray-800">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center h-28" style="width: 150px;">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-28 w-auto">
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
                    <span class="text-gray-600 text-sm">Already have an account? Switch below</span>
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
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                    <a href="{{ route('welcome') }}#home" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('welcome') }}#experiences" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('welcome') }}#families" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('welcome') }}#about" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('welcome') }}#contact" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="auth-container moroccan-pattern flex items-center justify-center p-4 pt-24">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-40 w-auto mx-auto">
                <p class="text-gray-600 mt-2">Experience authentic Moroccan culture</p>
            </div>

            <!-- Form Container -->
            <div class="form-container rounded-2xl shadow-2xl p-8 border border-orange-100">
                <!-- Tab Switcher -->
                <div class="flex mb-8 bg-gray-100 rounded-full p-1">
                    <button id="loginTab" class="flex-1 py-2 px-4 rounded-full text-sm font-medium transition-all duration-300 bg-white text-orange-600 shadow-sm">
                        Sign In
                    </button>
                    <button id="registerTab" class="flex-1 py-2 px-4 rounded-full text-sm font-medium transition-all duration-300 text-gray-600 hover:text-orange-600">
                        Sign Up
                    </button>
                </div>

                <!-- Login Form -->
                <div id="loginForm" class="form-transition">
                    <form id="login-form" class="space-y-6">
                        @csrf
                        <div>
                            <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="loginEmail" name="email" required 
                                class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                placeholder="Enter your email">
                        </div>
                        
                        <div>
                            <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" id="loginPassword" name="password" required 
                                    class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none pr-12"
                                    placeholder="Enter your password">
                                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('loginPassword')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <a href="#" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn-moroccan w-full text-white py-3 rounded-lg font-semibold text-lg">
                            Sign In
                        </button>
                    </form>

                    <!-- Social Login -->
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button class="social-btn w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="ml-2">Google</span>
                            </button>

                            <button class="social-btn w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="ml-2">Facebook</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="form-transition hidden">
                    <form id="register-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                <input type="text" id="firstName" name="first_name" required 
                                    class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                    placeholder="First name">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                <input type="text" id="lastName" name="last_name" required 
                                    class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                    placeholder="Last name">
                            </div>
                        </div>
                        
                        <div>
                            <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="registerEmail" name="email" required 
                                class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                placeholder="Enter your email">
                        </div>

                        <div>
                            <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" id="registerPassword" name="password" required 
                                    class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none pr-12"
                                    placeholder="Create a password">
                                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('registerPassword')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <input type="password" id="confirmPassword" name="password_confirmation" required 
                                    class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none pr-12"
                                    placeholder="Confirm your password">
                                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('confirmPassword')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="userType" class="block text-sm font-medium text-gray-700 mb-2">I want to</label>
                            <select id="userType" name="user_type" required 
                                class="input-focus w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none">
                                <option value="">Select your goal</option>
                                <option value="traveler">Find a Moroccan family to stay with (Visitor)</option>
                                <option value="host">Host travelers in my home (Host Family)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Note: Admin accounts can only be created by existing administrators</p>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="terms" name="terms" required class="mt-1 rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                I agree to the <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Terms of Service</a> and <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" class="btn-moroccan w-full text-white py-3 rounded-lg font-semibold text-lg">
                            Create Account
                        </button>
                    </form>

                    <!-- Social Register -->
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button class="social-btn w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span class="ml-2">Google</span>
                            </button>

                            <button class="social-btn w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                <span class="ml-2">Facebook</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Initialize all functionality when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            function switchToLogin() {
                // Update tabs
                loginTab.classList.add('bg-white', 'text-orange-600', 'shadow-sm');
                loginTab.classList.remove('text-gray-600');
                registerTab.classList.remove('bg-white', 'text-orange-600', 'shadow-sm');
                registerTab.classList.add('text-gray-600');

                // Show/hide forms
                registerForm.classList.add('hidden');
                loginForm.classList.remove('hidden');
            }

            function switchToRegister() {
                // Update tabs
                registerTab.classList.add('bg-white', 'text-orange-600', 'shadow-sm');
                registerTab.classList.remove('text-gray-600');
                loginTab.classList.remove('bg-white', 'text-orange-600', 'shadow-sm');
                loginTab.classList.add('text-gray-600');

                // Show/hide forms
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
            }

            if (loginTab && registerTab) {
                loginTab.addEventListener('click', switchToLogin);
                registerTab.addEventListener('click', switchToRegister);
            }

            // Login form handler
            const loginFormElement = document.querySelector('#login-form');
            if (loginFormElement) {
                loginFormElement.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Login form submitted');
                    
                    const form = this;
                    const formData = new FormData(form);
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    
                    // Show loading state
                    submitButton.textContent = 'Signing In...';
                    submitButton.disabled = true;

                    console.log('Sending login request...');

                    fetch('{{ route("auth.login") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Login response:', data);
                        
                        if (data.success && data.redirect) {
                            console.log('Login successful, redirecting to:', data.redirect);
                            
                            // Show success message
                            showMessage('Login successful! Redirecting...', 'success');
                            
                            // Immediate redirect
                            window.location.href = data.redirect;
                            
                        } else {
                            // Reset button state
                            submitButton.textContent = originalText;
                            submitButton.disabled = false;
                            
                            // Show error message
                            showMessage(data.message || 'Login failed', 'error');
                            
                            if (data.errors) {
                                for (let field in data.errors) {
                                    data.errors[field].forEach(error => {
                                        showMessage(error, 'error');
                                    });
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Login error:', error);
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        showMessage('An error occurred. Please try again.', 'error');
                    });
                    
                    return false;
                });
            }

            // Register form handler
            const registerFormElement = document.querySelector('#register-form');
            if (registerFormElement) {
                registerFormElement.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const password = document.getElementById('registerPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    
                    if (password !== confirmPassword) {
                        showMessage('Passwords do not match!', 'error');
                        return false;
                    }
                    
                    const form = this;
                    const formData = new FormData(form);
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    
                    // Show loading state
                    submitButton.textContent = 'Creating Account...';
                    submitButton.disabled = true;

                    fetch('{{ route("auth.register") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Register response:', data);
                        
                        if (data.success) {
                            showMessage(data.message, 'success');
                            if (data.redirect) {
                                console.log('Redirecting to:', data.redirect);
                                window.location.href = data.redirect;
                            }
                        } else {
                            submitButton.textContent = originalText;
                            submitButton.disabled = false;
                            
                            showMessage(data.message || 'Registration failed', 'error');
                            
                            if (data.errors) {
                                for (let field in data.errors) {
                                    data.errors[field].forEach(error => {
                                        showMessage(error, 'error');
                                    });
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Registration error:', error);
                        submitButton.textContent = originalText;
                        submitButton.disabled = false;
                        showMessage('An error occurred. Please try again.', 'error');
                    });
                });
            }

            // Set initial form opacity
            if (loginForm) {
                loginForm.style.opacity = '1';
                loginForm.style.transform = 'translateY(0)';
            }
        });

        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }

        function showMessage(message, type) {
            // Create message container if it doesn't exist
            let messageContainer = document.getElementById('message-container');
            if (!messageContainer) {
                messageContainer = document.createElement('div');
                messageContainer.id = 'message-container';
                messageContainer.className = 'mt-4';
                
                const authContainer = document.querySelector('.form-container');
                if (authContainer) {
                    authContainer.appendChild(messageContainer);
                }
            }

            // Create message element
            const messageEl = document.createElement('div');
            messageEl.className = `p-4 rounded-lg mb-4 ${type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'}`;
            messageEl.textContent = message;

            // Clear previous messages and add new one
            messageContainer.innerHTML = '';
            messageContainer.appendChild(messageEl);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (messageEl && messageEl.parentNode) {
                    messageEl.remove();
                }
            }, 5000);
        }

        // Enhanced input animations
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('transform', 'scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });
    </script>
</body>
</html>
