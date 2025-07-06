<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culturoo - Experience Authentic Moroccan Culture</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        .hero-bg {
            position: relative;
            background-size: cover, 200px 200px;
            background-position: center, center;
        }
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(5px);
            z-index: 0;
        }
        .moroccan-pattern {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"><defs><pattern id="pattern" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse"><path d="M30 0L60 30L30 60L0 30Z" fill="none" stroke="rgba(139,69,19,0.1)" stroke-width="1"/></pattern></defs><rect width="60" height="60" fill="url(%23pattern)"/></svg>');
        }
        .gradient-text {
            background: linear-gradient(135deg, #8B4513, #D2691E);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(139, 69, 19, 0.15);
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
    </style>
</head>
<body class="font-['Inter'] text-gray-800 bg-orange-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-28 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Browse Stays</a>
                    <a href="#experiences" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></span>
                        <span class="bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ Auth::user()->role_display }}
                        </span>
                        <a href="{{ route('profile') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Profile</a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('auth') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Sign In</a>
                        <a href="{{ route('auth') }}" class="btn-moroccan text-white px-6 py-3 rounded-full font-medium">Join Now</a>
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
                    <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="#experiences" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="#families" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
                    <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        @auth
                            <div class="px-3 py-2">
                                <p class="text-sm text-gray-600">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></p>
                                <span class="inline-block bg-{{ Auth::user()->role_color }}-100 text-{{ Auth::user()->role_color }}-800 px-2 py-1 rounded-full text-xs font-medium mt-1">
                                    {{ Auth::user()->role_display }}
                                </span>
                            </div>
                            <a href="{{ route('profile') }}" class="block px-3 py-2 text-orange-600 font-medium">Profile</a>
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
    <section id="home" class="hero-bg min-h-screen flex items-center text-white relative overflow-hidden">
        <!-- Background Video -->
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('videos/3018533-hd_1920_1080_24fps.mp4') }}" type="video/mp4">
            <!-- Fallback for browsers that don't support video -->
        </video>
        
        <!-- Video Overlay -->
        <div class="hero-overlay"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-7xl font-['Playfair_Display'] font-bold mb-6 leading-tight">
                    Experience 
                    <span class="text-orange-300">Authentic</span>
                    <br>Moroccan Culture
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-orange-100 leading-relaxed">
                    Live with genuine Moroccan families, immerse yourself in rich traditions, and create unforgettable memories in the heart of Morocco.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('auth') }}" class="btn-moroccan text-white px-8 py-4 rounded-full text-lg font-semibold inline-flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6M8 6V4m8 2v2m-8-2v2m0 0H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2h-4"></path>
                        </svg>
                        Find Your Family
                    </a>
                    <button class="border-2 border-white text-white hover:bg-white hover:text-orange-600 px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300">
                        Watch Stories
                    </button>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="experiences" class="py-20 bg-white moroccan-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-['Playfair_Display'] font-bold gradient-text mb-4">Why Choose Culturoo?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover the authentic Morocco through immersive cultural experiences with local families</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-['Playfair_Display'] font-semibold mb-4 text-gray-800">Authentic Families</h3>
                    <p class="text-gray-600 leading-relaxed">Stay with carefully selected Moroccan families who open their homes and hearts to share their culture, traditions, and daily life with you.</p>
                </div>

                <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-['Playfair_Display'] font-semibold mb-4 text-gray-800">Cultural Immersion</h3>
                    <p class="text-gray-600 leading-relaxed">Learn traditional cooking, participate in local festivals, practice Arabic or Berber, and experience Morocco beyond the tourist trail.</p>
                </div>

                <div class="card-hover bg-white rounded-2xl p-8 shadow-lg border border-orange-100">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-['Playfair_Display'] font-semibold mb-4 text-gray-800">Safe & Verified</h3>
                    <p class="text-gray-600 leading-relaxed">All host families are thoroughly vetted and verified. We ensure your safety and comfort throughout your cultural journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gradient-to-br from-orange-50 to-orange-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-['Playfair_Display'] font-bold gradient-text mb-4">Stories from Our Travelers</h2>
                <p class="text-xl text-gray-600">Real experiences from people who lived the Moroccan dream</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b55c?w=60&h=60&fit=crop&crop=face" alt="Sarah" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800">Sarah Johnson</h4>
                            <p class="text-gray-500 text-sm">United States</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Living with the Benali family in Marrakech was life-changing. I learned to cook tagine, practiced Arabic daily, and felt like part of the family. An unforgettable experience!"</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" alt="Marco" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800">Marco Silva</h4>
                            <p class="text-gray-500 text-sm">Spain</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"The warmth and hospitality of my host family in Fez exceeded all expectations. I discovered traditions I never knew existed and made lifelong friends."</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="flex items-center mb-6">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face" alt="Emma" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-800">Emma Thompson</h4>
                            <p class="text-gray-500 text-sm">United Kingdom</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"From learning traditional henna art to joining family celebrations, every day brought new cultural discoveries. This platform connected me with an amazing family."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-orange-600 to-orange-700 text-white">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl md:text-5xl font-['Playfair_Display'] font-bold mb-6">Ready for Your Moroccan Adventure?</h2>
            <p class="text-xl mb-8 text-orange-100">Join thousands of travelers who have experienced authentic Moroccan culture through our platform.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('auth') }}" class="bg-white text-orange-600 hover:bg-gray-100 px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Browse Families
                </a>
                <a href="{{ route('auth') }}" class="border-2 border-white text-white hover:bg-white hover:text-orange-600 px-8 py-4 rounded-full text-lg font-semibold transition-all duration-300">
                    Become a Host
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-24 w-auto mb-4">
                    <p class="text-gray-400 mb-6 max-w-md">Connecting travelers with authentic Moroccan families for genuine cultural experiences and lifelong memories.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.749-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">For Travelers</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Find Families</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">How It Works</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Safety Guidelines</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Travel Tips</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">For Hosts</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Become a Host</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Host Resources</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Community</a></li>
                        <li><a href="#" class="hover:text-orange-400 transition-colors duration-300">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Culturoo. All rights reserved. Made with ❤️ for cultural exchange.</p>
            </div>
        </div>
    </footer>

    @vite('resources/js/app.js')
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Smooth scrolling for navigation links
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

        // Navigation background on scroll
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