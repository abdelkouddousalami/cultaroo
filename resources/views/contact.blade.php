<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Culturoo</title>
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
        .moroccan-pattern {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><pattern id="pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M30 0L60 30L30 60L0 30Z" fill="none" stroke="rgba(139,69,19,0.05)" stroke-width="1"/></pattern></defs><rect width="60" height="60" fill="url(%23pattern)"/></svg>');
        }
        .contact-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 69, 19, 0.1);
            transition: all 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
        }
        .contact-icon {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .form-input {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus {
            border-color: #D2691E;
            outline: none;
            box-shadow: 0 0 0 3px rgba(210, 105, 30, 0.1);
        }
        .hero-section {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.9), rgba(210, 105, 30, 0.8)),
                        url('/images/moroccan-architecture.jpg');
            background-size: cover;
            background-position: center;
            min-height: 40vh;
        }
        .section-divider {
            height: 4px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            border-radius: 2px;
            width: 80px;
            margin: 0 auto 2rem;
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
        }
        
        /* Global Dropdown Enhancements */
        .dropdown-menu, #user-menu {
            z-index: 100000 !important;
            transform: translateZ(0);
            will-change: transform, opacity;
            backface-visibility: hidden;
            position: absolute;
        }
        
        /* Notification popup styles */
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transform: translateX(150%);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 9999;
            max-width: 350px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .notification.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-left: 6px solid #064e3b;
        }
        
        .notification.error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-left: 6px solid #7f1d1d;
        }
        
        .notification.info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-left: 6px solid #1e40af;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification-icon {
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .notification-content {
            flex-grow: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 16px;
        }
        
        .notification-message {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .notification-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        
        .notification-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 moroccan-pattern">
    <!-- Notification Container -->
    <div id="notification-container"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('our-book') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Our Book</a>
                    <a href="{{route('about')}}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors duration-300 p-2 rounded-lg hover:bg-orange-50">
                            <div class="hidden sm:block text-right mr-2">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->first_name ?? Auth::user()->name }}</p>
                                <span class="text-xs bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full font-medium">
                                    {{ Auth::user()->role_display }}
                                </span>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold">
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
                        <div id="user-menu" class="absolute right-0 mt-2 w-[250px] bg-white rounded-xl shadow-2xl border-2 border-orange-200 py-3 z-[99999] hidden" style="box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
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
                    @else
                    <!-- Hide Sign In and Join Now buttons on mobile -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('auth') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Sign In</a>
                        <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Join Now</a>
                    </div>
                    @endauth
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
                    <a href="{{ route('welcome') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="#experiences" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('listings.index') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('our-book') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Our Book</a>
                    <a href="{{route('about')}}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        @auth
                        <!-- User Info -->
                        <div class="mb-4 p-3 bg-white rounded-lg border border-orange-100">
                            <p class="font-medium text-gray-900 text-lg">{{ Auth::user()->first_name ?? Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                            <p class="text-sm text-gray-500 mb-2">{{ Auth::user()->email }}</p>
                            <span class="text-sm bg-{{ Auth::user()->role_color ?? 'orange' }}-100 text-{{ Auth::user()->role_color ?? 'orange' }}-800 px-3 py-1 rounded-full font-medium">
                                {{ Auth::user()->role_display }}
                            </span>
                        </div>

                        <a href="{{ route('profile') }}" class="block px-3 py-2 text-orange-600 font-medium">My Profile</a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="px-3 mt-2">
                            @csrf
                            <button type="submit" class="w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Logout</button>
                        </form>
                        @else
                        <a href="{{ route('auth') }}" class="block px-3 py-2 text-orange-600 font-medium">Sign In</a>
                        <a href="{{ route('auth') }}" class="block mx-3 mt-2 text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Join Now</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section flex items-center justify-center text-white text-center "style="margin-top: 80px;">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 font-playfair">Get in Touch</h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">We're here to help you discover authentic Moroccan experiences</p>
            <div class="section-divider bg-white"></div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 gradient-text font-playfair">Contact Culturoo</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Have questions about hosting or traveling? Need assistance with your booking? 
                    Our team is ready to help you create unforgettable cultural experiences.
                </p>
                <div class="section-divider"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Contact Form -->
                <div class="contact-card rounded-2xl p-8 shadow-lg">
                    <h3 class="text-2xl font-bold mb-6 gradient-text font-playfair">Send us a Message</h3>
                    <form id="contactForm" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                                <input type="text" id="firstName" name="firstName" required 
                                       class="form-input w-full" placeholder="Your first name">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                                <input type="text" id="lastName" name="lastName" required 
                                       class="form-input w-full" placeholder="Your last name">
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   class="form-input w-full" placeholder="your.email@example.com">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="form-input w-full" placeholder="+212 XXX XXX XXX">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                            <select id="subject" name="subject" required class="form-input w-full">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="hosting">Become a Host</option>
                                <option value="booking">Booking Assistance</option>
                                <option value="support">Technical Support</option>
                                <option value="partnership">Business Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                            <textarea id="message" name="message" rows="6" required 
                                      class="form-input w-full resize-none" 
                                      placeholder="Tell us how we can help you..."></textarea>
                        </div>

                        <div class="flex items-start">
                            <input type="checkbox" id="newsletter" name="newsletter" 
                                   class="mt-1 h-4 w-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500">
                            <label for="newsletter" class="ml-3 text-sm text-gray-600">
                                I'd like to receive updates about new host families and cultural experiences
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full btn-moroccan text-white py-4 px-6 rounded-xl font-semibold text-lg shadow-lg">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Contact Cards -->
                    <div class="grid gap-6">
                        <div class="contact-card rounded-2xl p-6 text-center shadow-lg">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold mb-2">Email Us</h4>
                            <p class="text-gray-600 mb-3">Get in touch via email</p>
                            <a href="mailto:hello@culturoo.com" class="text-orange-600 font-medium hover:text-orange-700">
                                hello@culturoo.com
                            </a>
                        </div>

                        <div class="contact-card rounded-2xl p-6 text-center shadow-lg">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold mb-2">Call Us</h4>
                            <p class="text-gray-600 mb-3">Speak with our team</p>
                            <a href="tel:+212123456789" class="text-orange-600 font-medium hover:text-orange-700">
                                +212 123 456 789
                            </a>
                        </div>

                        <div class="contact-card rounded-2xl p-6 text-center shadow-lg">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold mb-2">Visit Us</h4>
                            <p class="text-gray-600 mb-3">Our office location</p>
                            <address class="text-orange-600 font-medium not-italic">
                                123 Medina Street<br>
                                Marrakech, Morocco
                            </address>
                        </div>

                        <div class="contact-card rounded-2xl p-6 text-center shadow-lg">
                            <div class="contact-icon">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold mb-2">Office Hours</h4>
                            <p class="text-gray-600 mb-3">When we're available</p>
                            <div class="text-orange-600 font-medium">
                                Mon - Fri: 9:00 - 18:00<br>
                                Sat: 10:00 - 16:00
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="contact-card rounded-2xl p-6 shadow-lg">
                        <h3 class="text-xl font-bold mb-4 gradient-text">Frequently Asked Questions</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-gray-800">How do I become a host family?</h4>
                                <p class="text-gray-600 text-sm mt-1">Submit an application through our platform and we'll guide you through the verification process.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Is my booking secure?</h4>
                                <p class="text-gray-600 text-sm mt-1">Yes, all payments are processed securely and we provide 24/7 support for your peace of mind.</p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Can I cancel my booking?</h4>
                                <p class="text-gray-600 text-sm mt-1">Yes, check our cancellation policy for terms and conditions based on your booking date.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10 relative overflow-hidden">
        <!-- Decorative Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="moroccan-pattern h-full w-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Main Footer Content -->
            <div class="mb-6">
                <!-- Top Row: Logo and Brand Description -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mt-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center mb-4 lg:mb-0">
                        <p class="text-gray-400 leading-relaxed max-w-md">Connecting travelers with authentic Moroccan families for genuine cultural experiences and lifelong memories.</p>
                    </div>

                    <!-- Navigation Links on Same Line -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-base font-['Playfair_Display'] font-semibold mb-3 text-white">Discover</h4>
                            <ul class="space-y-1 text-gray-400 text-sm">
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Browse Host Families
                                    </a></li>
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Cultural Experiences
                                    </a></li>
                                <li><a href="{{ route('our-book') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Travel Guide
                                    </a></li>
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Safety Center
                                    </a></li>
                            </ul>
                        </div>

                        <!-- Host Resources -->
                        <div>
                            <h4 class="text-base font-['Playfair_Display'] font-semibold mb-3 text-white">For Hosts</h4>
                            <ul class="space-y-1 text-gray-400 text-sm">
                                <li><a href="{{ route('auth') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Start Hosting
                                    </a></li>
                                <li><a href="{{ route('our-book') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Host Guidelines
                                    </a></li>
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Community Forum
                                    </a></li>
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Support Center
                                    </a></li>
                            </ul>
                        </div>

                        <!-- Support -->
                        <div>
                            <h4 class="text-base font-['Playfair_Display'] font-semibold mb-3 text-white">Support</h4>
                            <ul class="space-y-1 text-gray-400 text-sm">
                                <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Help Center
                                    </a></li>
                                <li><a href="{{ route('contact') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Contact Us
                                    </a></li>
                                <li><a href="{{ route('privacy') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Privacy Policy
                                    </a></li>
                                <li><a href="{{ route('privacy') }}" class="hover:text-orange-400 transition-colors duration-300 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Terms of Service
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Newsletter and Social Media -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Newsletter Signup -->
                    <div class="mb-4 lg:mb-0">
                        <h5 class="text-white font-semibold mb-2">Stay Connected</h5>
                        <div class="flex max-w-sm">
                            <input type="email" placeholder="Enter your email" class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-l-lg text-white placeholder-gray-400 focus:outline-none focus:border-orange-400 transition-colors text-sm">
                            <button class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 rounded-r-lg transition-all duration-300 font-medium text-sm">
                                Subscribe
                            </button>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h5 class="text-white font-semibold mb-2">Follow Us</h5>
                        <div class="flex space-x-3">
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/_cultaroo_/profilecard/?igsh=MTJkYWI0czl0cHllZQ==" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:bg-orange-600 transition-all duration-300 transform hover:scale-110">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5zm4.25 3.25a5.25 5.25 0 1 1 0 10.5a5.25 5.25 0 0 1 0-10.5zm0 1.5a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5zm5.25.75a1 1 0 1 1-2 0a1 1 0 0 1 2 0z" />
                                </svg>
                            </a>
                            <!-- TikTok -->
                            <a href="https://www.tiktok.com/@cultaroo?_t=ZM-8y9gKxxD7zx&_r=1" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:bg-orange-600 transition-all duration-300 transform hover:scale-110">
                                <svg class="w-4 h-4" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.5 7.5c.2 2.1 1.7 3.7 3.5 4v3.1c-1.7 0-3.3-.6-4.5-1.6V24c0 3.1-2.5 5.6-5.6 5.6s-5.6-2.5-5.6-5.6 2.5-5.6 5.6-5.6c.3 0 .6 0 .9.1v2.7c-.3-.1-.6-.1-.9-.1-1.6 0-2.9 1.3-2.9 2.9s1.3 2.9 2.9 2.9 2.9-1.3 2.9-2.9V7.5h3.7z" fill="currentColor"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-800 pt-6">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-3 lg:space-y-0">
                    <!-- Copyright -->
                    <div class="text-center lg:text-left mb-6">
                        <p class="text-gray-400 text-sm">
                            &copy; 2025 Culturoo. All rights reserved.
                        </p>
                        <p class="text-gray-500 text-xs flex items-center justify-center lg:justify-start mt-1">
                            Made with
                            <svg class="w-3 h-3 mx-1 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                            for cultural exchange in Morocco
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            // Submit to backend
            fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Show success message
                    showNotification('success', result.message);
                    // Reset form
                    this.reset();
                } else {
                    showNotification('error', result.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'An error occurred. Please try again later.');
            })
            .finally(() => {
                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Show notification function
        function showNotification(type, message) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            const icon = type === 'success' ? '✓' : '!';
            const colorClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';

            notification.className = `notification ${type} ${colorClass} show`;
            notification.innerHTML = `
                <div class="notification-icon">${icon}</div>
                <div class="notification-content">
                    <div class="notification-title">${type === 'success' ? 'Success' : 'Error'}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(notification);

            // Auto-remove notification after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 5000);
        }

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
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
                    
                    // If menu is going off-screen, adjust position
                    if (menuRect.right > viewportWidth) {
                        userMenu.style.left = 'auto';
                        userMenu.style.right = '0';
                    }
                }
                
                // Close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) mobileMenu.classList.add('hidden');
            }
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
            
            // Close user dropdown if open
            const userMenu = document.getElementById('user-menu');
            if (userMenu) {
                userMenu.classList.add('hidden');
            }
            
            // Reset arrow rotation
            const menuArrow = document.getElementById('menu-arrow');
            if (menuArrow) {
                menuArrow.classList.remove('rotate-180');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const menuButton = event.target.closest('[onclick="toggleUserMenu()"]');
            const menuArrow = document.getElementById('menu-arrow');
            
            if (userMenu && !menuButton && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
                // Reset arrow rotation
                if (menuArrow) {
                    menuArrow.classList.remove('rotate-180');
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
                
                // Also close mobile menu if open
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });

        // Notification System
        function showNotification(type, title, message, duration = 5000) {
            const container = document.getElementById('notification-container');
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            // Icon based on notification type
            let icon = '';
            if (type === 'success') {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="notification-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
            } else if (type === 'error') {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="notification-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
            } else {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="notification-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
            }
            
            // Create notification content
            notification.innerHTML = `
                ${icon}
                <div class="notification-content">
                    <div class="notification-title">${title}</div>
                    <div class="notification-message">${message}</div>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            `;
            
            // Add to container
            container.appendChild(notification);
            
            // Show with animation
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            // Auto-remove after duration
            if (duration > 0) {
                setTimeout(() => {
                    notification.classList.remove('show');
                    // Remove element after animation completes
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, duration);
            }
            
            return notification;
        }
        
        // Check for flash messages on page load (for Laravel flash messages)
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for status parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            if (urlParams.has('login') && urlParams.get('login') === 'success') {
                showNotification('success', 'Welcome Back!', 'You have successfully logged in to your account.');
            }
            
            if (urlParams.has('register') && urlParams.get('register') === 'success') {
                showNotification('success', 'Account Created!', 'Your account has been successfully created. Welcome to Culturoo!');
            }
            
            if (urlParams.has('error')) {
                const errorMessage = urlParams.get('error');
                showNotification('error', 'Authentication Error', errorMessage || 'There was a problem with your request. Please try again.');
            }
            
            // Check for Laravel flash messages
            @if(session('success'))
                showNotification('success', 'Success', '{{ session('success') }}');
            @endif
            
            @if(session('error'))
                showNotification('error', 'Error', '{{ session('error') }}');
            @endif
            
            @if(session('info'))
                showNotification('info', 'Information', '{{ session('info') }}');
            @endif
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    mobileMenu.classList.add('hidden');
                }
            });
        });
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('bg-white/98');
                nav.classList.remove('bg-white/95');
            } else {
                nav.classList.add('bg-white/95');
                nav.classList.remove('bg-white/98');
            }
        });
    </script>
</body>
</html>