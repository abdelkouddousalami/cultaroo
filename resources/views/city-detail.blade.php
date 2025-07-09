<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $cityData['name'] }} - {{ $cityData['subtitle'] }} | Culturoo</title>
    @include('partials.favicon')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .hero-section {
            height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.6)), url("{!! $cityData['main_image'] !!}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-top: 0;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.15"/><circle cx="20" cy="80" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .hero-content {
            max-width: 900px;
            padding: 0 20px;
            z-index: 3;
            animation: heroFadeIn 2s ease-out;
        }

        @keyframes heroFadeIn {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
            background: linear-gradient(45deg, #ffffff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: titleGlow 3s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7), 0 0 20px rgba(255, 255, 255, 0.3); }
            100% { text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7), 0 0 30px rgba(255, 255, 255, 0.5); }
        }

        .hero-subtitle {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            opacity: 0.95;
            font-weight: 300;
            letter-spacing: 1px;
            animation: subtitleSlide 2s ease-out 0.5s both;
        }

        @keyframes subtitleSlide {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            100% {
                opacity: 0.95;
                transform: translateX(0);
            }
        }

        .city-badge {
            display: inline-block;
            background: linear-gradient(135deg, rgba(210, 105, 30, 0.9), rgba(139, 69, 19, 0.9));
            color: white;
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: badgePulse 2s ease-in-out 1s both;
            transform: translateY(20px);
        }

        @keyframes badgePulse {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.8);
            }
            50% {
                transform: translateY(0) scale(1.1);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .rating-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 25px;
            border-radius: 50px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: ratingSlideUp 2s ease-out 1.5s both;
            transform: translateY(30px);
        }

        @keyframes ratingSlideUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stars {
            color: #F59E0B;
        }

        .breadcrumb {
            background: #FFF7ED;
            padding: 1rem 0;
        }

        .breadcrumb-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: #D2691E;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .content-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 20px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 2rem;
            text-align: center;
        }

        .description-section {
            background: white;
            border-radius: 25px;
            padding: 3.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            margin-bottom: 4rem;
            border: 1px solid rgba(210, 105, 30, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.6s ease;
        }

        .description-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #D2691E, transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }

        .description-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
        }

        .description-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(210, 105, 30, 0.1);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #D2691E, #8B4513, #D2691E);
            transform: scaleX(0);
            transition: transform 0.6s ease;
        }

        .info-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(210, 105, 30, 0.25);
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        .info-card:nth-child(odd) {
            animation-delay: 0.4s;
        }

        .info-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #8B4513;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-card-icon {
            font-size: 1.5rem;
            color: #D2691E;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-list li:before {
            content: '✓';
            color: #D2691E;
            font-weight: bold;
        }

        .highlights-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .highlight-tag {
            background: linear-gradient(135deg, #FFF7ED, #FED7AA);
            color: #D2691E;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            border: 2px solid #FED7AA;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            animation: floatTag 3s ease-in-out infinite;
        }

        .highlight-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.8s ease;
        }

        .highlight-tag:hover::before {
            left: 100%;
        }

        .highlight-tag:hover {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(210, 105, 30, 0.3);
        }

        .gallery-section {
            margin-bottom: 4rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(210, 105, 30, 0.2), rgba(139, 69, 19, 0.2));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item:hover {
            transform: scale(1.08) rotate(1deg);
            box-shadow: 0 20px 40px rgba(210, 105, 30, 0.3);
        }

        .gallery-item:nth-child(even):hover {
            transform: scale(1.08) rotate(-1deg);
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .cta-section {
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
            color: white;
            padding: 4rem 2rem;
            border-radius: 20px;
            text-align: center;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="ctaGrain" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="5" cy="15" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100%" height="100%" fill="url(%23ctaGrain)"/></svg>');
            animation: ctaFloat 15s ease-in-out infinite;
        }

        @keyframes ctaFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -10px) rotate(0.5deg); }
            50% { transform: translate(-5px, -20px) rotate(-0.5deg); }
            75% { transform: translate(-10px, -5px) rotate(0.3deg); }
        }

        .cta-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 69, 19, 0.3);
        }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: inline-block;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.8s ease;
            z-index: -1;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: white;
            color: #8B4513;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            background: #FFF7ED;
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        }

        .btn-outline:hover {
            background: white;
            color: #8B4513;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.2);
        }

        .back-button {
            position: fixed;
            top: 100px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #8B4513;
            padding: 10px 15px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            background: white;
            transform: translateX(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Modal for gallery */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            position: relative;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 800px;
            top: 50%;
            transform: translateY(-50%);
        }

        .modal-content img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #D2691E;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .content-section {
                padding: 2rem 15px;
            }

            .description-section {
                padding: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .back-button {
                position: static;
                margin: 1rem;
                display: inline-block;
            }
        }
    </style>
</head>
<body class="bg-orange-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/logo.png') }}" alt="Culturoo" class="h-28 w-auto">
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Home</a>
                    <a href="#experiences" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Experiences</a>
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Host Families</a>
                    <a href="{{ route('our-book') }}" class="text-orange-600 font-medium">Our Book</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                    <span class="text-gray-700">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></span>
                    <a href="{{ route('profile') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Profile</a>
                    <form method="POST" action="{{ route('auth.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-full font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300">Logout</button>
                    </form>
                    @else
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('auth') }}" class="text-orange-600 hover:text-orange-700 font-medium transition-colors duration-300">Sign In</a>
                        <a href="{{ route('auth') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-full font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300">Join Now</a>
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
                    <a href="{{ route('our-book') }}" class="block px-3 py-2 text-orange-600 font-medium">Our Book</a>
                    <a href="{{ route('contact') }}" class="block px-3 py-2 text-gray-700 hover:text-orange-600 transition-colors duration-300">Contact</a>
                    @auth
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <div class="px-3 py-2">
                            <p class="text-sm text-gray-600">Welcome, <span class="font-medium text-orange-600">{{ Auth::user()->first_name }}</span></p>
                        </div>
                        <a href="{{ route('profile') }}" class="block px-3 py-2 text-orange-600 font-medium">Profile</a>
                        <form method="POST" action="{{ route('auth.logout') }}" class="px-3 mt-2">
                            @csrf
                            <button type="submit" class="w-full text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Logout</button>
                        </form>
                    </div>
                    @else
                    <div class="border-t border-gray-200 pt-3 mt-3">
                        <a href="{{ route('auth') }}" class="block px-3 py-2 text-orange-600 font-medium">Sign In</a>
                        <a href="{{ route('auth') }}" class="block mx-3 mt-2 text-center bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-full font-medium">Join Now</a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Back Button -->
    <a href="{{ route('our-book') }}" class="back-button">
        ← Back to Our Book
    </a>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="city-badge">{{ $cityData['badge'] }}</div>
            <h1 class="hero-title">{{ $cityData['name'] }}</h1>
            <p class="hero-subtitle">{{ $cityData['subtitle'] }}</p>
            <div class="rating-display">
                <span class="stars">★★★★★</span>
                <span>{{ $cityData['rating'] }}/5 Rating</span>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <div class="breadcrumb-content">
            <a href="{{ route('welcome') }}">Home</a>
            <span>›</span>
            <a href="{{ route('our-book') }}">Our Book</a>
            <span>›</span>
            <span>{{ $cityData['name'] }}</span>
        </div>
    </div>

    <!-- Content Section -->
    <div class="content-section">
        <!-- Description -->
        <div class="description-section">
            <p class="description-text">{{ $cityData['long_description'] }}</p>
        </div>

        <!-- Highlights -->
        <div class="info-card" style="margin-bottom: 4rem;">
            <h3>
                <span class="info-card-icon">🌟</span>
                Top Highlights
            </h3>
            <div class="highlights-grid">
                @foreach($cityData['highlights'] as $highlight)
                    <span class="highlight-tag">{{ $highlight }}</span>
                @endforeach
            </div>
        </div>

        <!-- Information Grid -->
        <div class="info-grid">
            <!-- Best Time to Visit -->
            <div class="info-card">
                <h3>
                    <span class="info-card-icon">📅</span>
                    Best Time to Visit
                </h3>
                <p style="font-size: 1.1rem; color: #D2691E; font-weight: 600;">{{ $cityData['best_time'] }}</p>
            </div>

            <!-- Activities -->
            <div class="info-card">
                <h3>
                    <span class="info-card-icon">🎯</span>
                    Top Activities
                </h3>
                <ul class="info-list">
                    @foreach($cityData['activities'] as $activity)
                        <li>{{ $activity }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- Cuisine -->
            <div class="info-card">
                <h3>
                    <span class="info-card-icon">🍽️</span>
                    Local Cuisine
                </h3>
                <ul class="info-list">
                    @foreach($cityData['cuisine'] as $dish)
                        <li>{{ $dish }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="gallery-section">
            <h2 class="section-title">Photo Gallery</h2>
            <div class="gallery-grid">
                @foreach($cityData['gallery'] as $index => $image)
                    <div class="gallery-item" onclick="openModal('{{ $image }}')">
                        <img src="{{ $image }}" alt="{{ $cityData['name'] }} - Image {{ $index + 1 }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="cta-section">
            <h2 class="cta-title">Ready to Experience {{ $cityData['name'] }}?</h2>
            <p class="cta-text">Connect with local families in {{ $cityData['name'] }} through Culturoo and discover authentic experiences that go beyond typical tourism.</p>
            <div class="cta-buttons">
                <a href="{{ route('auth') }}" class="btn btn-primary">Find Host Families</a>
                <a href="{{ route('listings.index') }}" class="btn btn-outline">Browse Experiences</a>
            </div>
        </div>
    </div>

    <!-- Modal for Gallery -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="" alt="">
        </div>
    </div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Gallery modal functions
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modal.style.display = 'block';
            modalImage.src = imageSrc;
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById('imageModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Smooth scroll animations with stagger effect
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                        entry.target.classList.add('animate-in');
                    }, index * 150); // Stagger animation
                }
            });
        }, observerOptions);

        // Enhanced parallax effect for hero section
        let ticking = false;
        
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-section');
            const heroContent = document.querySelector('.hero-content');
            
            if (hero && heroContent) {
                // Parallax background
                hero.style.transform = `translateY(${scrolled * 0.3}px)`;
                
                // Fade out hero content as user scrolls
                const fadeStart = 100;
                const fadeUntil = 500;
                let opacity = 1;
                
                if (scrolled >= fadeStart && scrolled <= fadeUntil) {
                    opacity = 1 - (scrolled - fadeStart) / (fadeUntil - fadeStart);
                } else if (scrolled > fadeUntil) {
                    opacity = 0;
                }
                
                heroContent.style.opacity = opacity;
                heroContent.style.transform = `translateY(${scrolled * 0.2}px) scale(${1 + scrolled * 0.0002})`;
            }
            
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', requestTick);

        // Observe all elements with enhanced animations
        document.querySelectorAll('.info-card, .gallery-item, .description-section, .highlight-tag, .cta-section').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px) scale(0.9)';
            element.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            observer.observe(element);
        });

        // Add floating animation to highlight tags with different delays
        document.querySelectorAll('.highlight-tag').forEach((tag, index) => {
            tag.style.animationDelay = `${index * 0.1}s`;
            tag.style.animation = `floatTag ${3 + (index % 3)}s ease-in-out infinite`;
        });

        // Add progressive reveal for gallery items
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            item.style.animationDelay = `${index * 0.2}s`;
        });

        // Enhanced CTA section animation
        const ctaSection = document.querySelector('.cta-section');
        if (ctaSection) {
            const ctaObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0) scale(1)';
                        
                        // Animate CTA elements individually
                        const ctaTitle = entry.target.querySelector('.cta-title');
                        const ctaText = entry.target.querySelector('.cta-text');
                        const ctaButtons = entry.target.querySelectorAll('.btn');
                        
                        setTimeout(() => {
                            if (ctaTitle) {
                                ctaTitle.style.opacity = '1';
                                ctaTitle.style.transform = 'translateY(0)';
                            }
                        }, 200);
                        
                        setTimeout(() => {
                            if (ctaText) {
                                ctaText.style.opacity = '1';
                                ctaText.style.transform = 'translateY(0)';
                            }
                        }, 400);
                        
                        ctaButtons.forEach((btn, btnIndex) => {
                            setTimeout(() => {
                                btn.style.opacity = '1';
                                btn.style.transform = 'translateY(0) scale(1)';
                            }, 600 + (btnIndex * 150));
                        });
                    }
                });
            }, { threshold: 0.3 });
            
            ctaObserver.observe(ctaSection);
            
            // Initially hide CTA elements
            const ctaTitle = ctaSection.querySelector('.cta-title');
            const ctaText = ctaSection.querySelector('.cta-text');
            const ctaButtons = ctaSection.querySelectorAll('.btn');
            
            if (ctaTitle) {
                ctaTitle.style.opacity = '0';
                ctaTitle.style.transform = 'translateY(30px)';
                ctaTitle.style.transition = 'all 0.8s ease';
            }
            
            if (ctaText) {
                ctaText.style.opacity = '0';
                ctaText.style.transform = 'translateY(30px)';
                ctaText.style.transition = 'all 0.8s ease';
            }
            
            ctaButtons.forEach(btn => {
                btn.style.opacity = '0';
                btn.style.transform = 'translateY(30px) scale(0.9)';
                btn.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            });
        }

        // CSS animation for floating tags (add to style section)
        const floatAnimation = `
            @keyframes floatTag {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                25% { transform: translateY(-3px) rotate(0.5deg); }
                50% { transform: translateY(-8px) rotate(0deg); }
                75% { transform: translateY(-3px) rotate(-0.5deg); }
            }
            
            .animate-in {
                animation: slideInScale 0.8s ease-out forwards;
            }
            
            @keyframes slideInScale {
                0% {
                    opacity: 0;
                    transform: translateY(50px) scale(0.8) rotate(-2deg);
                }
                50% {
                    opacity: 0.7;
                    transform: translateY(-10px) scale(1.05) rotate(1deg);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1) rotate(0deg);
                }
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            .gallery-item:hover img {
                transform: scale(1.1) rotate(2deg);
                transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .info-card:hover h3 {
                color: #D2691E;
                transform: translateX(5px);
                transition: all 0.3s ease;
            }

            .section-title {
                animation: titleReveal 1s ease-out forwards;
                opacity: 0;
                transform: translateY(30px);
            }

            @keyframes titleReveal {
                0% {
                    opacity: 0;
                    transform: translateY(30px) scale(0.9);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
        `;
        
        // Inject additional CSS
        const style = document.createElement('style');
        style.textContent = floatAnimation;
        document.head.appendChild(style);

        // Animate section titles on scroll
        const titleObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.section-title').forEach(title => {
            title.style.animationPlayState = 'paused';
            titleObserver.observe(title);
        });

        // Add mouse parallax effect to hero section
        document.addEventListener('mousemove', (e) => {
            const hero = document.querySelector('.hero-section');
            if (hero) {
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;
                
                const xPercent = (clientX / innerWidth - 0.5) * 20;
                const yPercent = (clientY / innerHeight - 0.5) * 20;
                
                hero.style.transform = `translate(${xPercent}px, ${yPercent}px)`;
            }
        });

        // Add smooth scroll for navigation links
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
    </script>
</body>
</html>
