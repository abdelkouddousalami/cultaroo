@extends('layouts.app')


@section('content')
    <style>
        /* Fade-in animation for sections */
        .fade-in {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 1s cubic-bezier(.77,0,.175,1) forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: none;
            }
        }
        /* Animated gradient text */
        .gradient-text-animated {
            background: linear-gradient(270deg, #D67D45, #F9A826, #D2691E, #8B4513);
            background-size: 800% 800%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientMove 6s ease-in-out infinite;
        }
        @keyframes gradientMove {
            0% {background-position:0% 50%}
            50% {background-position:100% 50%}
            100% {background-position:0% 50%}
        }
        /* Card hover pop and shadow */
        .card-animate {
            transition: transform 0.4s cubic-bezier(.77,0,.175,1), box-shadow 0.4s cubic-bezier(.77,0,.175,1);
        }
        .card-animate:hover {
            transform: translateY(-12px) scale(1.04);
            box-shadow: 0 24px 48px rgba(214, 125, 69, 0.18), 0 1.5px 8px rgba(0,0,0,0.08);
        }
        /* Animated border shimmer */
        .shimmer-border {
            position: relative;
        }
        .shimmer-border:before {
            content: "";
            position: absolute;
            top: -8px; left: -8px; right: -8px; bottom: -8px;
            border-radius: 24px;
            border: 3px solid #F9A826;
            opacity: 0.2;
            pointer-events: none;
            animation: shimmer 2.5s linear infinite;
        }
        @keyframes shimmer {
            0% {box-shadow: 0 0 0 0 #F9A82644;}
            50% {box-shadow: 0 0 24px 8px #F9A82688;}
            100% {box-shadow: 0 0 0 0 #F9A82644;}
        }
        /* Button pulse */
        .pulse-btn {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% {box-shadow: 0 0 0 0 #D67D45aa;}
            70% {box-shadow: 0 0 0 12px #D67D4500;}
            100% {box-shadow: 0 0 0 0 #D67D45aa;}
        }
        /* Section reveal stagger */
        .section-reveal {
            opacity: 0;
            transform: translateY(60px);
            animation: fadeInUp 1.2s cubic-bezier(.77,0,.175,1) forwards;
        }
        .section-reveal.delay-1 {animation-delay: .2s;}
        .section-reveal.delay-2 {animation-delay: .4s;}
        .section-reveal.delay-3 {animation-delay: .6s;}
        .section-reveal.delay-4 {animation-delay: .8s;}
        .section-reveal.delay-5 {animation-delay: 1s;}
    </style>
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
                    <a href="#about" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
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
                        <span class="h-6 w-6 block">&#9776;</span>
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
                    <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">About</a>
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
    <!-- Our Story -->
    <section class="max-w-3xl mx-auto pt-8 pb-12 px-4 text-center fade-in mt-8">
        <h2 class="text-3xl md:text-4xl font-['Playfair_Display'] font-bold mb-4 gradient-text-animated">Our Story: More Than Tourism, It’s Transformation</h2>
        <blockquote class="bg-orange-100 rounded-xl p-6 shadow-md text-lg text-gray-700 mb-6 italic border-l-4 border-orange-400 shimmer-border">
            <span class="inline-block mb-2 text-2xl">“</span>As travelers in Morocco, we wandered medinas and deserts – but our deepest memories were born in family kitchens, sharing stories over mint tea. Yet arranging these moments was near impossible.<br>
            So we built Culturoo: a bridge between travelers craving authenticity and Moroccan families eager to share their heritage.<br>
            <span class="font-semibold text-orange-700">Welcome to where strangers become cousins.</span>
        </blockquote>
    </section>
    <section class="max-w-4xl mx-auto pt-8 pb-12 px-4 fade-in mt-8">
        <div class="flex flex-col md:flex-row items-center md:space-x-8">
            <div class="md:w-2/3 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-['Playfair_Display'] font-bold mb-4 gradient-text-animated">Our Story: More Than Tourism, It’s Transformation</h2>
                <blockquote class="bg-orange-100 rounded-xl p-6 shadow-md text-lg text-gray-700 mb-6 italic border-l-4 border-orange-400 shimmer-border">
                    <span class="inline-block mb-2 text-2xl">“</span>As travelers in Morocco, we wandered medinas and deserts – but our deepest memories were born in family kitchens, sharing stories over mint tea. Yet arranging these moments was near impossible.<br>
                    So we built Culturoo: a bridge between travelers craving authenticity and Moroccan families eager to share their heritage.<br>
                    <span class="font-semibold text-orange-700">Welcome to where strangers become cousins.</span>
                </blockquote>
            </div>
            <div class="md:w-1/3 mt-6 md:mt-0 flex justify-center">
                <img src="{{ asset('images/aboutus/image1.jpg') }}" alt="Mint Tea Story" style="width: 1100px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);" class="w-full h-auto object-cover rounded-2xl border-4 border-orange-300 shadow-lg card-animate shimmer-border">
            </div>
        </div>
    </section>

    <!-- Why Culturoo Table -->
    <section class="max-w-4xl mx-auto py-8 px-4 fade-in section-reveal delay-1">
        <h2 class="text-2xl font-bold mb-4 text-orange-700 gradient-text-animated">Why Culturoo? Your Passport to Real Morocco</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border border-orange-200 rounded-lg shadow-md text-base">
                <thead class="bg-orange-100">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Experience</th>
                        <th class="py-3 px-4 font-semibold">Traditional Tourism</th>
                        <th class="py-3 px-4 font-semibold">Culturoo</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="card-animate">
                        <td class="py-2 px-4">Accommodation</td>
                        <td class="py-2 px-4">Hotel chains</td>
                        <td class="py-2 px-4">Handpicked family homes</td>
                    </tr>
                    <tr class="card-animate">
                        <td class="py-2 px-4">Food</td>
                        <td class="py-2 px-4">Tourist restaurants</td>
                        <td class="py-2 px-4">Cook & eat with grandmothers</td>
                    </tr>
                    <tr class="card-animate">
                        <td class="py-2 px-4">Activities</td>
                        <td class="py-2 px-4">Generic tours</td>
                        <td class="py-2 px-4">Atlas hikes with local uncles</td>
                    </tr>
                    <tr class="card-animate">
                        <td class="py-2 px-4">Connection</td>
                        <td class="py-2 px-4">Transactional</td>
                        <td class="py-2 px-4">Lifelong bonds</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Advantages -->
    <section class="max-w-4xl mx-auto py-8 px-4 grid md:grid-cols-3 gap-8 fade-in section-reveal delay-2">
        <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 card-animate">
            <h3 class="text-lg font-bold text-orange-700 mb-2">Authenticity Guaranteed</h3>
            <ul class="list-disc ml-5 text-gray-700">
                <li>Personally vetted by our team</li>
                <li>Background-checked</li>
                <li>Trained in cultural hosting</li>
            </ul>
            <p class="mt-2 text-sm text-gray-500">No staged shows – just real daily life</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 card-animate">
            <h3 class="text-lg font-bold text-orange-700 mb-2">Safety First</h3>
            <ul class="list-disc ml-5 text-gray-700">
                <li>24/7 on-call support</li>
                <li>Secure payments via escrow system</li>
                <li>Emergency protocols with local partners</li>
            </ul>
        </div>
        <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 card-animate">
            <h3 class="text-lg font-bold text-orange-700 mb-2">Value That Matters</h3>
            <table class="w-full text-sm mb-2">
                <tr><td class="font-bold">Culturoo</td><td class="font-bold">Competitors</td></tr>
                <tr><td>Night Stay: $25-40</td><td>$60+</td></tr>
                <tr><td>Meals: Included</td><td>$15/meal</td></tr>
                <tr><td>Experiences: Free with family</td><td>$50/tour</td></tr>
            </table>
            <p class="text-sm text-gray-500">80% of fees go directly to families<br>Carbon-neutral stays<br>Cultural preservation initiatives</p>
        </div>
    </section>

    <!-- How It Works -->
    <section class="max-w-4xl mx-auto py-12 px-4 fade-in section-reveal delay-3">
        <h2 class="text-2xl font-bold mb-4 text-orange-700 gradient-text-animated">How It Works: Your Journey in 3 Steps</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 flex flex-col items-center card-animate">
                <h3 class="font-bold text-orange-700 mb-2">Discover</h3>
                <ul class="list-disc ml-5 text-gray-700 text-center">
                    <li>Browse families by location (Marrakech, Sahara...)</li>
                    <li>Interests (Cooking, Music, Trekking...)</li>
                    <li>Language (French, English, Arabic...)</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 flex flex-col items-center card-animate">
                <h3 class="font-bold text-orange-700 mb-2">Connect</h3>
                <ul class="list-disc ml-5 text-gray-700 text-center">
                    <li>Message families directly → Plan your immersion</li>
                    <li class="italic">"I’d love to learn embroidery from you!"</li>
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 flex flex-col items-center card-animate">
                <h3 class="font-bold text-orange-700 mb-2">Live</h3>
                <ul class="list-disc ml-5 text-gray-700 text-center">
                    <li>Arrive as a guest → Leave as family</li>
                    <li>Take home recipes, local phone numbers</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- About Us Highlight Image -->
    <section class="max-w-4xl mx-auto py-8 px-4 fade-in section-reveal delay-4">
        <div class="flex flex-col md:flex-row items-center md:space-x-8">
            <div class="md:w-1/2 mb-6 md:mb-0 flex justify-center">
                <img src="{{ asset('images/aboutus/image2.jpg') }}" alt="Atlas Hike" style="width: 1100px; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);" class="w-full h-auto object-cover rounded-2xl border-4 border-orange-300 shadow-lg card-animate shimmer-border">
            </div>
            <div class="md:w-1/2">
                <h3 class="text-xl font-bold text-orange-700 mb-2 gradient-text-animated">A Journey Beyond the Guidebook</h3>
                <p class="text-gray-700 text-lg">From hiking the Atlas mountains with local uncles to learning family recipes, every Culturoo experience is a story you’ll tell for years.</p>
            </div>
        </div>
    </section>

    <!-- Meet Our Families Carousel (Polaroid-style grid) -->
    <section class="max-w-4xl mx-auto py-12 px-4 fade-in section-reveal delay-4">
        <h2 class="text-2xl font-bold mb-4 text-orange-700 gradient-text-animated">Meet Our Families (Real People, Real Stories)</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow-lg border-4 border-orange-200 p-6 flex flex-col items-center polaroid card-animate shimmer-border">
                <img src="{{ asset('images/aboutus/fatima.jpg') }}" alt="Fatima" class="w-28 h-28 rounded-full mb-4 object-cover border-4 border-orange-300 animate__animated animate__fadeIn">
                <p class="font-semibold text-gray-800">Fatima, Marrakech</p>
                <p class="text-gray-600 text-center mt-2">"I’ve taught 32 travelers to make couscous – now they send me photos of their attempts!"</p>
                <button class="mt-3 px-4 py-2 rounded-full bg-orange-100 text-orange-700 font-semibold hover:bg-orange-200 transition pulse-btn">Ask Fatima about her cooking class!</button>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border-4 border-orange-200 p-6 flex flex-col items-center polaroid card-animate shimmer-border">
                <img src="{{ asset('images/aboutus/ahmed.jpg') }}" alt="Ahmed" class="w-28 h-28 rounded-full mb-4 object-cover border-4 border-orange-300 animate__animated animate__fadeIn">
                <p class="font-semibold text-gray-800">Ahmed, Chefchaouen</p>
                <p class="text-gray-600 text-center mt-2">"My kids practice English with guests... last month an Italian taught us pizza-making!"</p>
                <button class="mt-3 px-4 py-2 rounded-full bg-orange-100 text-orange-700 font-semibold hover:bg-orange-200 transition pulse-btn">Ask Ahmed about his pizza recipe!</button>
            </div>
        </div>
        <!-- Carousel/slider implementation can be added here -->
    </section>

    <!-- Testimonials -->
    <section class="max-w-4xl mx-auto py-12 px-4 fade-in section-reveal delay-5">
        <h2 class="text-2xl font-bold mb-4 text-orange-700 gradient-text-animated">Join 1,200+ Travelers Who Found Their Moroccan Home</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 flex items-center card-animate">
                <img src="{{ asset('images/aboutus/sophie.jpg') }}" alt="Sophie" class="w-16 h-16 rounded-full mr-4 object-cover border-2 border-orange-200 animate__animated animate__fadeIn">
                <div>
                    <p class="text-gray-800 font-semibold">"NOT a hotel – I cried leaving ‘my family’ in Fes"</p>
                    <p class="text-gray-500 text-sm">- Sophie, Canada <span class="ml-2 text-orange-400 underline cursor-pointer">Read her story</span></p>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 flex items-center card-animate">
                <img src="{{ asset('images/aboutus/miguel.jpg') }}" alt="Miguel" class="w-16 h-16 rounded-full mr-4 object-cover border-2 border-orange-200 animate__animated animate__fadeIn">
                <div>
                    <p class="text-gray-800 font-semibold">"Learned Darija slang you won’t find in guidebooks!"</p>
                    <p class="text-gray-500 text-sm">- Miguel, Spain <span class="ml-2 text-orange-400 underline cursor-pointer">Watch his video</span></p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
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

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

   
@endsection
