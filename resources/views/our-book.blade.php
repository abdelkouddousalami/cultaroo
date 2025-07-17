<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Book - Discover Morocco's Hidden Gems | Culturoo</title>
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
            background: linear-gradient(135deg, #D2691E 0%, #8B4513 50%, #CD853F 100%);
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/images/moroccan-pattern.png') repeat;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 3rem;
            color: #8B4513;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            border-radius: 2px;
        }

        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .city-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .city-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #D2691E, #8B4513, #D2691E);
            transform: scaleX(0);
            transition: transform 0.6s ease;
            z-index: 3;
        }

        .city-card:hover::before {
            transform: scaleX(1);
        }

        .city-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(210, 105, 30, 0.25);
            text-decoration: none;
            color: inherit;
        }

        .city-card:nth-child(even):hover {
            transform: translateY(-15px) scale(1.02) rotate(1deg);
        }

        .city-card:nth-child(odd):hover {
            transform: translateY(-15px) scale(1.02) rotate(-1deg);
        }

        .city-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: transform 0.6s ease;
        }

        .city-card:hover .city-image {
            transform: scale(1.1);
        }

        .city-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7));
            transition: opacity 0.4s ease;
        }

        .city-card:hover .city-image::after {
            opacity: 0.8;
        }

        .city-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(210, 105, 30, 0.9);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .city-content {
            padding: 2rem;
        }

        .city-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 0.5rem;
        }

        .city-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .city-highlights {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .highlight-tag {
            background: #FFF7ED;
            color: #D2691E;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid #FED7AA;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .highlight-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .city-card:hover .highlight-tag::before {
            left: 100%;
        }

        .city-card:hover .highlight-tag {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            transform: translateY(-2px);
        }

        .city-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #8B4513;
            font-weight: 600;
        }

        .stars {
            color: #F59E0B;
        }

        .divider-section {
            background: linear-gradient(135deg, #FFF7ED, #FED7AA);
            padding: 60px 0;
            text-align: center;
            margin: 80px 0;
        }

        .divider-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .divider-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #8B4513;
            margin-bottom: 1rem;
        }

        .divider-text {
            color: #666;
            font-size: 1.1rem;
        }

        .cta-section {
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .cta-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 20px;
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
        }

        .cta-button {
            display: inline-block;
            background: white;
            color: #8B4513;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: #8B4513;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .cities-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .city-content {
                padding: 1.5rem;
            }

            .section-container {
                padding: 60px 15px;
            }

            .filter-container {
                padding: 40px 15px;
            }

            .filter-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .filter-btn {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }

        /* Filter Section Styles */
        .filter-container {
            background: linear-gradient(135deg, #FFF7ED, #FED7AA);
            padding: 60px 20px;
            text-align: center;
        }

        .filter-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .filter-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 1rem;
        }

        .filter-subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: white;
            color: #8B4513;
            border: 2px solid #D2691E;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .filter-btn:hover {
            background: #D2691E;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(210, 105, 30, 0.3);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            box-shadow: 0 5px 15px rgba(210, 105, 30, 0.4);
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Food Card Styles */
        .food-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .food-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .food-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .food-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 40%, rgba(0, 0, 0, 0.6));
        }

        .food-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(210, 105, 30, 0.9);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .food-content {
            padding: 1.5rem;
        }

        .food-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            color: #8B4513;
            margin-bottom: 0.5rem;
        }

        .food-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .food-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .food-type {
            background: #FFF7ED;
            color: #D2691E;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid #FED7AA;
        }

        .food-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #8B4513;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .food-stars {
            color: #F59E0B;
        }

        /* Marrakech */
        .city-marrakech { background-image: url('/images/cities/marrakech1.jpg'); }
        
        /* Casablanca */
        .city-casablanca { background-image: url('/images/cities/casablanca1.jpg'); }
        
        /* Fez */
        .city-fez { background-image: url('/images/cities/fez1.jpg'); }
        
        /* Rabat */
        .city-rabat { background-image: url('https://images.unsplash.com/photo-1622734834651-8b3e5fb9e4e9?w=500&h=300&fit=crop'); }
        
        /* Agadir */
        .city-agadir { background-image: url('/images/cities/agadir1.jpg'); }
        
        /* Chefchaouen */
        .city-chefchaouen { background-image: url('https://images.unsplash.com/photo-1566905142009-d2e59ef2caa1?w=500&h=300&fit=crop'); }
        
        /* Essaouira */
        .city-essaouira { background-image: url('https://images.unsplash.com/photo-1573160103600-63a1bb3b4fa2?w=500&h=300&fit=crop'); }
        
        /* Ifrane */
        .city-ifrane { background-image: url('https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?w=500&h=300&fit=crop'); }
        
        /* Ouarzazate */
        .city-ouarzazate { background-image: url('https://images.unsplash.com/photo-1572985102448-d7506f8e43e0?w=500&h=300&fit=crop'); }
        
        /* Azrou */
        .city-azrou { background-image: url('https://images.unsplash.com/photo-1594736797933-d0d4a4ab9b8e?w=500&h=300&fit=crop'); }

        /* Food Images - More Specific */
        .food-tagine { background-image: url('https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop'); }
        .food-couscous { background-image: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop'); }
        .food-pastilla { background-image: url('https://images.unsplash.com/photo-1608039829572-78524f79c4c7?w=400&h=300&fit=crop'); }
        .food-harira { background-image: url('https://images.unsplash.com/photo-1547592180-85f173990554?w=400&h=300&fit=crop'); }
        .food-mechoui { background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop'); }
        .food-tea { background-image: url('https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=300&fit=crop'); }
        .food-msemen { background-image: url('https://images.unsplash.com/photo-1571115764595-644a1f56a55c?w=400&h=300&fit=crop'); }
        .food-bread { background-image: url('https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=400&h=300&fit=crop'); }
        .food-chermoula { background-image: url('https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop'); }
        .food-rfissa { background-image: url('https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=400&h=300&fit=crop'); }
    </style>
</head>
<body class="bg-orange-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-lg z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <img src="{{ asset('images/logos/cultaroo.svg') }}" alt="Culturoo" class="h-8 w-auto">
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Our Book</h1>
            <p class="hero-subtitle">Discover Morocco's Most Captivating Cities & Authentic Cuisine</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-container">
        <div class="filter-content">
            <h2 class="filter-title">What would you like to explore?</h2>
            <p class="filter-subtitle">Choose between discovering Morocco's amazing cities or diving into its rich culinary heritage</p>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="showContent('cities')">
                    🏛️ Moroccan Cities
                </button>
                <button class="filter-btn" onclick="showContent('food')">
                    🍽️ Moroccan Cuisine
                </button>
            </div>
        </div>
    </section>

    <!-- Cities Content Section -->
    <div id="cities-content" class="content-section active">

    <!-- Most Touristic Cities Section -->
    <section class="section-container">
        <h2 class="section-title">5 Most Touristic Cities in Morocco</h2>
        <div class="cities-grid">
            <!-- Marrakech -->
            <a href="{{ route('city.show', 'marrakech') }}" class="city-card">
                <div class="city-image city-marrakech">
                    <div class="city-badge">Most Popular</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Marrakech</h3>
                    <p class="city-description">Known as the "Red City," Marrakech enchants visitors with its vibrant souks, stunning palaces, and the iconic Jemaa el-Fnaa square. Experience the magic of Arabian nights in this imperial city.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Medina</span>
                        <span class="highlight-tag">Majorelle Garden</span>
                        <span class="highlight-tag">Bahia Palace</span>
                        <span class="highlight-tag">Atlas Mountains</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.8/5 Tourist Rating</span>
                    </div>
                </div>
            </a>

            <!-- Casablanca -->
            <a href="{{ route('city.show', 'casablanca') }}" class="city-card">
                <div class="city-image city-casablanca">
                    <div class="city-badge">Economic Hub</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Casablanca</h3>
                    <p class="city-description">Morocco's economic capital and largest city, featuring the magnificent Hassan II Mosque and a blend of modern architecture with traditional Moroccan culture.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Hassan II Mosque</span>
                        <span class="highlight-tag">Corniche</span>
                        <span class="highlight-tag">Art Deco</span>
                        <span class="highlight-tag">Modern Culture</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.5/5 Tourist Rating</span>
                    </div>
                </div>
            </a>

            <!-- Fez -->
            <a href="{{ route('city.show', 'fez') }}" class="city-card">
                <div class="city-image city-fez">
                    <div class="city-badge">UNESCO Heritage</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Fez</h3>
                    <p class="city-description">The spiritual and cultural heart of Morocco, home to the world's oldest continuously operating university and an incredibly well-preserved medieval medina.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Al Quaraouiyine</span>
                        <span class="highlight-tag">Tanneries</span>
                        <span class="highlight-tag">Bou Inania</span>
                        <span class="highlight-tag">Ceramics</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.7/5 Tourist Rating</span>
                    </div>
                </div>
            </a>

            <!-- Rabat -->
            <a href="{{ route('city.show', 'rabat') }}" class="city-card">
                <div class="city-image city-rabat">
                    <div class="city-badge">Capital City</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Rabat</h3>
                    <p class="city-description">Morocco's capital city offers a perfect blend of historical monuments, modern amenities, and coastal charm along the Atlantic Ocean.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Kasbah of Udayas</span>
                        <span class="highlight-tag">Hassan Tower</span>
                        <span class="highlight-tag">Royal Palace</span>
                        <span class="highlight-tag">Ocean Views</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.4/5 Tourist Rating</span>
                    </div>
                </div>
            </a>

            <!-- Agadir -->
            <a href="{{ route('city.show', 'agadir') }}" class="city-card">
                <div class="city-image city-agadir">
                    <div class="city-badge">Beach Resort</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Agadir</h3>
                    <p class="city-description">Morocco's premier beach destination with golden sandy beaches, modern resorts, and year-round sunshine, perfect for relaxation and water sports.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Beach Resort</span>
                        <span class="highlight-tag">Surfing</span>
                        <span class="highlight-tag">Golf Courses</span>
                        <span class="highlight-tag">Souk El Had</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.3/5 Tourist Rating</span>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Divider Section -->
    <section class="divider-section">
        <div class="divider-content">
            <h2 class="divider-title">Beyond the Beaten Path</h2>
            <p class="divider-text">While Morocco's famous cities capture the world's attention, the kingdom holds countless hidden treasures waiting to be discovered. These lesser-known destinations offer authentic experiences away from the crowds.</p>
        </div>
    </section>

    <!-- Hidden Gems Section -->
    <section class="section-container">
        <h2 class="section-title">5 Hidden Gems You Must Visit</h2>
        <div class="cities-grid">
            <!-- Chefchaouen -->
            <a href="{{ route('city.show', 'chefchaouen') }}" class="city-card">
                <div class="city-image city-chefchaouen">
                    <div class="city-badge">Blue Pearl</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Chefchaouen</h3>
                    <p class="city-description">The enchanting "Blue Pearl" nestled in the Rif Mountains, where every building is painted in mesmerizing shades of blue, creating a dreamlike atmosphere.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Blue Streets</span>
                        <span class="highlight-tag">Rif Mountains</span>
                        <span class="highlight-tag">Photography</span>
                        <span class="highlight-tag">Handicrafts</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.9/5 Hidden Gem</span>
                    </div>
                </div>
            </a>

            <!-- Essaouira -->
            <a href="{{ route('city.show', 'essaouira') }}" class="city-card">
                <div class="city-image city-essaouira">
                    <div class="city-badge">Coastal Charm</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Essaouira</h3>
                    <p class="city-description">A windswept coastal city with Portuguese-influenced architecture, vibrant arts scene, and fresh seafood. Perfect for those seeking bohemian charm by the sea.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Windsurfing</span>
                        <span class="highlight-tag">Gnawa Music</span>
                        <span class="highlight-tag">Art Galleries</span>
                        <span class="highlight-tag">Fresh Seafood</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★★</span>
                        <span>4.6/5 Hidden Gem</span>
                    </div>
                </div>
            </a>

            <!-- Ifrane -->
            <a href="{{ route('city.show', 'ifrane') }}" class="city-card">
                <div class="city-image city-ifrane">
                    <div class="city-badge">Little Switzerland</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Ifrane</h3>
                    <p class="city-description">Known as "Little Switzerland," this mountain town features Alpine-style architecture, pristine forests, and is home to one of Africa's top universities.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Alpine Style</span>
                        <span class="highlight-tag">Cedar Forests</span>
                        <span class="highlight-tag">Skiing</span>
                        <span class="highlight-tag">Clean Air</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.5/5 Hidden Gem</span>
                    </div>
                </div>
            </a>

            <!-- Ouarzazate -->
            <a href="{{ route('city.show', 'ouarzazate') }}" class="city-card">
                <div class="city-image city-ouarzazate">
                    <div class="city-badge">Hollywood of Africa</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Ouarzazate</h3>
                    <p class="city-description">The "Gateway to the Sahara" and Morocco's film capital, where countless Hollywood productions have been filmed against the backdrop of ancient kasbahs.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Film Studios</span>
                        <span class="highlight-tag">Ait Ben Haddou</span>
                        <span class="highlight-tag">Desert Gateway</span>
                        <span class="highlight-tag">Kasbahs</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.4/5 Hidden Gem</span>
                    </div>
                </div>
            </a>

            <!-- Azrou -->
            <a href="{{ route('city.show', 'azrou') }}" class="city-card">
                <div class="city-image city-azrou">
                    <div class="city-badge">Berber Heritage</div>
                </div>
                <div class="city-content">
                    <h3 class="city-name">Azrou</h3>
                    <p class="city-description">A charming Berber town in the Middle Atlas, famous for its weekly souk, cedar forests, and the opportunity to see Barbary macaques in their natural habitat.</p>
                    <div class="city-highlights">
                        <span class="highlight-tag">Berber Culture</span>
                        <span class="highlight-tag">Cedar Forest</span>
                        <span class="highlight-tag">Barbary Apes</span>
                        <span class="highlight-tag">Handicrafts</span>
                    </div>
                    <div class="city-rating">
                        <span class="stars">★★★★☆</span>
                        <span>4.3/5 Hidden Gem</span>
                    </div>
                </div>
            </a>
        </div>
    </section>

    <!-- Call to Action Section for Cities -->
    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Ready to Explore Morocco?</h2>
            <p class="cta-text">Join Culturoo and connect with local families who can show you the authentic side of these incredible cities. Experience Morocco like never before.</p>
            <a href="{{ route('auth') }}" class="cta-button">Start Your Journey</a>
        </div>
    </section>

    </div> <!-- End Cities Content -->

    <!-- Food Content Section -->
    <div id="food-content" class="content-section">
        <!-- Moroccan Cuisine Introduction -->
        <section class="section-container">
            <h2 class="section-title">Discover Authentic Moroccan Cuisine</h2>
            <div class="description-section" style="text-align: center; margin-bottom: 4rem;">
                <p class="description-text">Moroccan cuisine is a magnificent tapestry of flavors, colors, and aromas that reflects the country's rich history and diverse cultural influences. From aromatic tagines to delicate pastries, every dish tells a story of tradition, hospitality, and culinary artistry passed down through generations.</p>
            </div>
            
            <div class="cities-grid">
                <!-- Tagine -->
                <div class="food-card">
                    <div class="food-image food-tagine">
                        <div class="food-badge">Traditional</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Tagine</h3>
                        <p class="food-description">A slow-cooked stew named after the earthenware pot it's cooked in. Features tender meat, vegetables, and aromatic spices like cinnamon, cumin, and saffron.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.9</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Couscous -->
                <div class="food-card">
                    <div class="food-image food-couscous">
                        <div class="food-badge">Friday Special</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Couscous</h3>
                        <p class="food-description">Steamed semolina grains served with vegetables, meat, and a flavorful broth. Traditionally eaten on Fridays and considered Morocco's national dish.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.8</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pastilla -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1608039829572-78524f79c4c7?w=400&h=300&fit=crop');">
                        <div class="food-badge">Royal Dish</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Pastilla</h3>
                        <p class="food-description">A delicate pastry traditionally filled with pigeon or chicken, almonds, and spices, topped with powdered sugar and cinnamon. A perfect blend of sweet and savory.</p>
                        <div class="food-details">
                            <span class="food-type">Appetizer</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.7</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Harira -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1547592180-85f173990554?w=400&h=300&fit=crop');">
                        <div class="food-badge">Ramadan Special</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Harira</h3>
                        <p class="food-description">A hearty tomato-based soup with lentils, chickpeas, rice, and fresh herbs. Traditionally served to break the fast during Ramadan.</p>
                        <div class="food-details">
                            <span class="food-type">Soup</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.6</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mechoui -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop');">
                        <div class="food-badge">Celebration</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Mechoui</h3>
                        <p class="food-description">Slow-roasted lamb or goat, traditionally cooked in a clay oven. The meat is incredibly tender and infused with aromatic herbs and spices.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.8</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mint Tea -->
                <div class="food-card">
                    <div class="food-image food-tea">
                        <div class="food-badge">Hospitality</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Atay (Mint Tea)</h3>
                        <p class="food-description">Sweet green tea infused with fresh mint leaves, served in small glasses. A symbol of Moroccan hospitality and social life.</p>
                        <div class="food-details">
                            <span class="food-type">Beverage</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.9</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Msemen -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1571115764595-644a1f56a55c?w=400&h=300&fit=crop');">
                        <div class="food-badge">Breakfast</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Msemen</h3>
                        <p class="food-description">Flaky, square-shaped pancakes that are crispy on the outside and soft inside. Perfect for breakfast with honey, jam, or cheese.</p>
                        <div class="food-details">
                            <span class="food-type">Bread</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Khobz -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=400&h=300&fit=crop');">
                        <div class="food-badge">Daily Staple</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Khobz (Moroccan Bread)</h3>
                        <p class="food-description">Round, flat bread with a golden crust and soft interior. Baked in communal ovens and essential to every Moroccan meal.</p>
                        <div class="food-details">
                            <span class="food-type">Bread</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.4</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chermoula -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop');">
                        <div class="food-badge">Marinade</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Chermoula</h3>
                        <p class="food-description">A vibrant herb marinade made with cilantro, parsley, garlic, lemon, and spices. Used to flavor fish, meat, and vegetables.</p>
                        <div class="food-details">
                            <span class="food-type">Sauce</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rfissa -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=400&h=300&fit=crop');">
                        <div class="food-badge">Comfort Food</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Rfissa</h3>
                        <p class="food-description">Shredded crepe-like pastry served with chicken in a rich, spiced broth with fenugreek. A comforting dish often served to new mothers.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.4</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zaalouk -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=400&h=300&fit=crop');">
                        <div class="food-badge">Healthy</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Zaalouk</h3>
                        <p class="food-description">A smoky eggplant and tomato salad seasoned with garlic, cumin, and paprika. Served as a side dish or appetizer with bread.</p>
                        <div class="food-details">
                            <span class="food-type">Salad</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.2</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Briouats -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop');">
                        <div class="food-badge">Appetizer</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Briouats</h3>
                        <p class="food-description">Triangular pastries filled with meat, cheese, or almonds, wrapped in thin pastry and fried until crispy. Perfect for special occasions.</p>
                        <div class="food-details">
                            <span class="food-type">Appetizer</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanjia -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1515443961218-a51367888e4b?w=400&h=300&fit=crop');">
                        <div class="food-badge">Marrakech Special</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Tanjia</h3>
                        <p class="food-description">A Marrakech specialty of slow-cooked meat in a clay pot with preserved lemons, garlic, and spices. Cooked in the ashes of hammam furnaces.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.7</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chebakia -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=400&h=300&fit=crop');">
                        <div class="food-badge">Ramadan Sweet</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Chebakia</h3>
                        <p class="food-description">Rose-shaped fried pastries made with sesame seeds, coated in honey and sprinkled with sesame seeds. A traditional Ramadan treat.</p>
                        <div class="food-details">
                            <span class="food-type">Dessert</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.6</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sellou -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop');">
                        <div class="food-badge">Energy Food</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Sellou</h3>
                        <p class="food-description">A nutritious mixture of roasted flour, almonds, sesame seeds, and argan oil. Traditionally given to pregnant women and children for energy.</p>
                        <div class="food-details">
                            <span class="food-type">Snack</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Makroudh -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop');">
                        <div class="food-badge">Tea Time</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Makroudh</h3>
                        <p class="food-description">Diamond-shaped semolina pastries filled with dates and almonds, then baked until golden. Perfect accompaniment to mint tea.</p>
                        <div class="food-details">
                            <span class="food-type">Dessert</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.4</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amlou -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=300&fit=crop');">
                        <div class="food-badge">Argan Specialty</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Amlou</h3>
                        <p class="food-description">A Berber paste made from argan oil, ground almonds, and honey. Often served as a dip with bread or used as a spread.</p>
                        <div class="food-details">
                            <span class="food-type">Spread</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kefta Tagine -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=300&fit=crop');">
                        <div class="food-badge">Popular</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Kefta Tagine</h3>
                        <p class="food-description">Spiced meatballs cooked in a rich tomato sauce with eggs on top. A family favorite that's both hearty and flavorful.</p>
                        <div class="food-details">
                            <span class="food-type">Main Dish</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★★</span>
                                <span>4.8</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bissara -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1547592180-85f173990554?w=400&h=300&fit=crop');">
                        <div class="food-badge">Winter Comfort</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Bissara</h3>
                        <p class="food-description">A creamy fava bean soup drizzled with olive oil and sprinkled with cumin. A warming winter dish popular for breakfast.</p>
                        <div class="food-details">
                            <span class="food-type">Soup</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.2</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rghaif -->
                <div class="food-card">
                    <div class="food-image" style="background-image: url('https://images.unsplash.com/photo-1571115764595-644a1f56a55c?w=400&h=300&fit=crop');">
                        <div class="food-badge">Street Food</div>
                    </div>
                    <div class="food-content">
                        <h3 class="food-name">Rghaif</h3>
                        <p class="food-description">Thin, layered pancakes that are crispy and flaky. Can be sweet or savory, often served with honey or stuffed with vegetables.</p>
                        <div class="food-details">
                            <span class="food-type">Bread</span>
                            <div class="food-rating">
                                <span class="food-stars">★★★★☆</span>
                                <span>4.3</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Food CTA Section -->
        <section class="cta-section">
            <div class="cta-content">
                <h2 class="cta-title">Taste the Authentic Flavors</h2>
                <p class="cta-text">Experience Morocco's incredible cuisine with local families. Learn traditional recipes and discover the stories behind each dish through Culturoo.</p>
                <a href="{{ route('auth') }}" class="cta-button">Start Your Culinary Journey</a>
            </div>
        </section>
    </div> <!-- End Food Content -->

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Smooth scroll for anchor links
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

        // Add scroll animation for cards with stagger effect
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -80px 0px'
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

        // Observe all city cards with enhanced animations
        document.querySelectorAll('.city-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px) scale(0.9)';
            card.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            card.style.animationDelay = `${index * 0.1}s`;
            observer.observe(card);
        });

        // Add hero section animation
        const heroContent = document.querySelector('.hero-content');
        if (heroContent) {
            heroContent.style.opacity = '0';
            heroContent.style.transform = 'translateY(30px)';
            heroContent.style.transition = 'all 1s ease-out';
            
            setTimeout(() => {
                heroContent.style.opacity = '1';
                heroContent.style.transform = 'translateY(0)';
            }, 200);
        }

        // Add parallax effect to hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });

        // Filter functionality
        function showContent(type) {
            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected content section
            document.getElementById(type + '-content').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
            
            // Smooth scroll to content
            setTimeout(() => {
                document.getElementById(type + '-content').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
            
            // Re-initialize animations for food cards if food section is shown
            if (type === 'food') {
                setTimeout(() => {
                    initializeFoodAnimations();
                }, 200);
            }
        }
        
        function initializeFoodAnimations() {
            const observerOptions2 = {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            };

            const observer2 = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0) scale(1)';
                            entry.target.classList.add('animate-in');
                        }, index * 120); // Stagger food card animations
                    }
                });
            }, observerOptions2);

            // Observe all food cards with enhanced animations
            document.querySelectorAll('.food-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px) scale(0.9)';
                card.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                card.style.animationDelay = `${index * 0.1}s`;
                observer2.observe(card);
            });
        }

        // Add CSS for enhanced animations
        const style = document.createElement('style');
        style.textContent = `
            .animate-in {
                animation: slideInScale 0.8s ease-out forwards;
            }
            
            @keyframes slideInScale {
                0% {
                    opacity: 0;
                    transform: translateY(50px) scale(0.8) rotate(-1deg);
                }
                50% {
                    opacity: 0.7;
                    transform: translateY(-10px) scale(1.05) rotate(0.5deg);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1) rotate(0deg);
                }
            }

            .hero-section {
                transition: transform 0.1s ease-out;
            }

            .section-title {
                animation: titleSlideIn 1s ease-out forwards;
                opacity: 0;
                transform: translateY(30px);
            }

            @keyframes titleSlideIn {
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
        document.head.appendChild(style);

        // Animate section titles when they come into view
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
    </script>
</body>
</html>
