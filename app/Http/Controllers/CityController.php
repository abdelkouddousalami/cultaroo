<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    private $cities = [
        // Most Touristic Cities
        'marrakech' => [
            'name' => 'Marrakech',
            'type' => 'touristic',
            'subtitle' => 'The Red City',
            'description' => 'Known as the "Red City," Marrakech enchants visitors with its vibrant souks, stunning palaces, and the iconic Jemaa el-Fnaa square.',
            'long_description' => 'Marrakech, the "Red City," is a mesmerizing blend of ancient traditions and modern luxury. Founded in 1070, this imperial city serves as Morocco\'s cultural and spiritual heart. The medina, a UNESCO World Heritage site, pulses with life as snake charmers, storytellers, and musicians create an unforgettable atmosphere in Jemaa el-Fnaa square. Beyond the bustling souks, discover architectural marvels like the Bahia Palace, Saadian Tombs, and the iconic Koutoubia Mosque. The city offers a perfect gateway to the Atlas Mountains, where traditional Berber villages await exploration.',
            'highlights' => ['Medina', 'Majorelle Garden', 'Bahia Palace', 'Atlas Mountains', 'Jemaa el-Fnaa', 'Koutoubia Mosque'],
            'rating' => '4.8',
            'badge' => 'Most Popular',
            'main_image' => '/images/cities/marrakech1.jpg',
            'gallery' => [
                '/images/cities/marrakech2.jpg',
                '/images/cities/marrakech3.jpg',
                '/images/cities/marrakech4.jpg',
                '/images/cities/marrakech5.jpg'
            ],
            'best_time' => 'October to April',
            'activities' => [
                'Explore the historic Medina and souks',
                'Visit Majorelle Garden and Yves Saint Laurent Museum',
                'Experience traditional hammam spa treatments',
                'Take day trips to the Atlas Mountains',
                'Enjoy rooftop dining with city views',
                'Learn traditional crafts in workshops'
            ],
            'cuisine' => [
                'Tagine with lamb and prunes',
                'Traditional couscous',
                'Mint tea and pastries',
                'Street food in Jemaa el-Fnaa'
            ]
        ],
        'casablanca' => [
            'name' => 'Casablanca',
            'type' => 'touristic',
            'subtitle' => 'Economic Hub of Morocco',
            'description' => 'Morocco\'s economic capital and largest city, featuring the magnificent Hassan II Mosque and a blend of modern architecture.',
            'long_description' => 'Casablanca, Morocco\'s economic powerhouse and largest city, perfectly embodies the country\'s modern aspirations while honoring its rich heritage. The city is home to the magnificent Hassan II Mosque, one of the largest mosques in the world, whose minaret soars 210 meters above the Atlantic Ocean. The French colonial architecture in the city center contrasts beautifully with traditional Moroccan design. The Corniche offers a vibrant nightlife scene, while the old medina provides authentic cultural experiences. As Africa\'s business hub, Casablanca seamlessly blends international sophistication with Moroccan warmth.',
            'highlights' => ['Hassan II Mosque', 'Corniche', 'Art Deco Architecture', 'Modern Culture', 'Old Medina', 'Morocco Mall'],
            'rating' => '4.5',
            'badge' => 'Economic Hub',
            'main_image' => '/images/cities/casablanca1.jpg',
            'gallery' => [
                '/images/cities/casablanca2.jpg',
                '/images/cities/casablanca3.jpg',
                '/images/cities/casablanca4.jpg',
                '/images/cities/casablanca5.jpg'
            ],
            'best_time' => 'March to May, September to November',
            'activities' => [
                'Visit Hassan II Mosque',
                'Stroll along the Corniche',
                'Explore Art Deco architecture',
                'Shop at Morocco Mall',
                'Experience modern Moroccan cuisine',
                'Visit the old medina'
            ],
            'cuisine' => [
                'Fresh seafood from Atlantic',
                'Modern Moroccan fusion',
                'International cuisine',
                'Traditional pastries'
            ]
        ],
        'fez' => [
            'name' => 'Fez',
            'type' => 'touristic',
            'subtitle' => 'Spiritual Capital of Morocco',
            'description' => 'The spiritual and cultural heart of Morocco, home to the world\'s oldest continuously operating university.',
            'long_description' => 'Fez, the spiritual and intellectual capital of Morocco, stands as one of the world\'s best-preserved medieval cities. Founded in the 9th century, Fez el-Bali (Old Fez) is a UNESCO World Heritage site and home to the University of Al Quaraouiyine, established in 859 AD and recognized as the world\'s oldest continuously operating university. The city\'s labyrinthine medina contains over 9,000 narrow streets and alleys, leading to hidden architectural gems, traditional tanneries, and bustling souks. Master craftsmen continue age-old traditions in ceramics, metalwork, and textile production, making Fez a living museum of Moroccan culture.',
            'highlights' => ['Al Quaraouiyine University', 'Tanneries', 'Bou Inania Madrasa', 'Ceramics Workshops', 'Medina', 'Royal Palace'],
            'rating' => '4.7',
            'badge' => 'UNESCO Heritage',
            'main_image' => '/images/cities/fez1.jpg',
            'gallery' => [
                '/images/cities/fez2.jpg',
                '/images/cities/fez3.jpg',
                '/images/cities/fez4.jpg',
                '/images/cities/fez5.jpg'
            ],
            'best_time' => 'April to June, September to November',
            'activities' => [
                'Explore the ancient medina',
                'Visit Al Quaraouiyine University',
                'Tour traditional tanneries',
                'Learn pottery making',
                'Visit Bou Inania Madrasa',
                'Shop for traditional crafts'
            ],
            'cuisine' => [
                'Traditional Fassi pastilla',
                'Mechoui (roasted lamb)',
                'Local honey and almonds',
                'Traditional sweets'
            ]
        ],
        'rabat' => [
            'name' => 'Rabat',
            'type' => 'touristic',
            'subtitle' => 'Capital City of Morocco',
            'description' => 'Morocco\'s capital city offers a perfect blend of historical monuments, modern amenities, and coastal charm.',
            'long_description' => 'Rabat, Morocco\'s political capital, elegantly balances its role as the seat of government with its rich historical heritage. Located along the Atlantic coast, this UNESCO World Heritage city showcases remarkable architectural landmarks including the iconic Hassan Tower and the Mausoleum of Mohammed V. The Kasbah of the Udayas, with its distinctive blue and white buildings, offers stunning ocean views and peaceful gardens. Unlike other imperial cities, Rabat maintains a more relaxed atmosphere while providing world-class museums, beautiful beaches, and excellent dining. The city serves as a gateway to understanding modern Morocco while preserving its ancient traditions.',
            'highlights' => ['Kasbah of Udayas', 'Hassan Tower', 'Royal Palace', 'Ocean Views', 'Mohammed V Mausoleum', 'Chellah Ruins'],
            'rating' => '4.4',
            'badge' => 'Capital City',
            'main_image' => 'https://images.unsplash.com/photo-1622734834651-8b3e5fb9e4e9?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1611348524140-53c9a25263d6?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1596394273808-d5c40b6b4d24?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop'
            ],
            'best_time' => 'April to June, September to November',
            'activities' => [
                'Explore Kasbah of the Udayas',
                'Visit Hassan Tower and Mausoleum',
                'Relax at Rabat Beach',
                'Tour the Royal Palace',
                'Visit Chellah archaeological site',
                'Enjoy modern shopping districts'
            ],
            'cuisine' => [
                'Fresh Atlantic seafood',
                'Royal Moroccan cuisine',
                'International restaurants',
                'Coastal specialties'
            ]
        ],
        'agadir' => [
            'name' => 'Agadir',
            'type' => 'touristic',
            'subtitle' => 'Morocco\'s Premier Beach Destination',
            'description' => 'Morocco\'s premier beach destination with golden sandy beaches, modern resorts, and year-round sunshine.',
            'long_description' => 'Agadir, Morocco\'s premier beach resort destination, offers a perfect blend of relaxation and adventure along the Atlantic coast. After being rebuilt following a devastating earthquake in 1960, the city emerged as a modern resort town with excellent infrastructure and world-class facilities. The 10-kilometer stretch of golden sandy beach provides ideal conditions for surfing, swimming, and sunbathing. The city serves as a gateway to the Anti-Atlas Mountains and Souss Valley, offering excursions to traditional Berber villages and argan oil cooperatives. Agadir\'s year-round pleasant climate makes it an ideal destination for golf enthusiasts and beach lovers alike.',
            'highlights' => ['Beach Resort', 'Surfing', 'Golf Courses', 'Souk El Had', 'Marina', 'Kasbah Ruins'],
            'rating' => '4.3',
            'badge' => 'Beach Resort',
            'main_image' => '/images/cities/agadir1.jpg',
            'gallery' => [
                '/images/cities/agadir2.jpg',
                '/images/cities/agadir3.jpg',
                '/images/cities/agadir4.jpg',
                '/images/cities/agadir5.jpg'
            ],
            'best_time' => 'Year-round destination',
            'activities' => [
                'Relax on pristine beaches',
                'Learn surfing',
                'Play golf at world-class courses',
                'Visit Souk El Had market',
                'Explore marina and restaurants',
                'Day trips to Atlas Mountains'
            ],
            'cuisine' => [
                'Fresh seafood and grilled fish',
                'Berber specialties',
                'International resort cuisine',
                'Argan oil products'
            ]
        ],
        // Hidden Gems
        'chefchaouen' => [
            'name' => 'Chefchaouen',
            'type' => 'hidden',
            'subtitle' => 'The Blue Pearl of Morocco',
            'description' => 'The enchanting "Blue Pearl" nestled in the Rif Mountains, where every building is painted in mesmerizing shades of blue.',
            'long_description' => 'Chefchaouen, known as the "Blue Pearl," is arguably Morocco\'s most photogenic city. Founded in 1471 as a small fortress, this mountain town has become famous for its striking blue-painted buildings that create a dreamlike atmosphere throughout the medina. Nestled in the Rif Mountains, Chefchaouen offers a cooler climate and a more relaxed pace compared to other Moroccan cities. The tradition of painting buildings blue is said to have been introduced by Jewish refugees in the 1930s, symbolizing the sky and heaven. Today, wandering through the blue-washed streets feels like walking through a living work of art, making it a paradise for photographers and those seeking tranquility.',
            'highlights' => ['Blue Streets', 'Rif Mountains', 'Photography', 'Handicrafts', 'Spanish Mosque', 'Kasbah Museum'],
            'rating' => '4.9',
            'badge' => 'Blue Pearl',
            'main_image' => 'https://images.unsplash.com/photo-1566905142009-d2e59ef2caa1?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1587974781560-81e04947fa70?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1589463518373-4b9e0a04e47b?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop'
            ],
            'best_time' => 'April to October',
            'activities' => [
                'Photography in blue streets',
                'Hiking in Rif Mountains',
                'Visit Spanish Mosque at sunset',
                'Shop for local handicrafts',
                'Explore the Kasbah',
                'Traditional weaving workshops'
            ],
            'cuisine' => [
                'Goat cheese specialties',
                'Mountain herbs and honey',
                'Traditional tagines',
                'Fresh mint tea'
            ]
        ],
        'essaouira' => [
            'name' => 'Essaouira',
            'type' => 'hidden',
            'subtitle' => 'Coastal Bohemian Paradise',
            'description' => 'A windswept coastal city with Portuguese-influenced architecture, vibrant arts scene, and fresh seafood.',
            'long_description' => 'Essaouira, formerly known as Mogador, is a charming coastal city that captivates visitors with its unique blend of Moroccan, Portuguese, and French influences. This UNESCO World Heritage site features well-preserved 18th-century ramparts and a picturesque harbor filled with blue fishing boats. The city has long been a haven for artists, musicians, and free spirits, earning its reputation as Morocco\'s bohemian capital. The constant Atlantic trade winds make it a world-class destination for windsurfing and kitesurfing. Essaouira is also famous for its vibrant Gnawa music scene and annual music festival, which attracts performers and visitors from around the globe.',
            'highlights' => ['Windsurfing', 'Gnawa Music', 'Art Galleries', 'Fresh Seafood', 'Ramparts', 'Argan Cooperatives'],
            'rating' => '4.6',
            'badge' => 'Coastal Charm',
            'main_image' => 'https://images.unsplash.com/photo-1573160103600-63a1bb3b4fa2?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1587974781560-81e04947fa70?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1589463518373-4b9e0a04e47b?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1611348524140-53c9a25263d6?w=600&h=400&fit=crop'
            ],
            'best_time' => 'April to October',
            'activities' => [
                'Windsurfing and kitesurfing',
                'Explore art galleries and studios',
                'Walk along ancient ramparts',
                'Visit fishing harbor',
                'Enjoy live Gnawa music',
                'Tour argan oil cooperatives'
            ],
            'cuisine' => [
                'Fresh fish and seafood',
                'Grilled sardines',
                'Seafood tagine',
                'Argan oil specialties'
            ]
        ],
        'ifrane' => [
            'name' => 'Ifrane',
            'type' => 'hidden',
            'subtitle' => 'Little Switzerland of Morocco',
            'description' => 'Known as "Little Switzerland," this mountain town features Alpine-style architecture and pristine forests.',
            'long_description' => 'Ifrane, known as "Little Switzerland," offers a surprising contrast to the typical Moroccan landscape. Built by the French in the 1930s as a hill station, this mountain town features distinctive Alpine-style architecture with red-tiled roofs and well-manicured gardens. Located in the Middle Atlas Mountains at 1,665 meters above sea level, Ifrane enjoys a cool, pleasant climate year-round and even receives snow in winter. The town is home to Al Akhawayn University, one of Africa\'s most prestigious institutions, which gives it a youthful, international atmosphere. Surrounded by cedar forests that house Barbary macaques, Ifrane serves as an excellent base for exploring the natural beauty of the Middle Atlas region.',
            'highlights' => ['Alpine Architecture', 'Cedar Forests', 'Skiing', 'Clean Air', 'Al Akhawayn University', 'Lion Stone'],
            'rating' => '4.5',
            'badge' => 'Little Switzerland',
            'main_image' => 'https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1587974781560-81e04947fa70?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1589463518373-4b9e0a04e47b?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop'
            ],
            'best_time' => 'May to September, December to February for snow',
            'activities' => [
                'Skiing in winter months',
                'Hiking in cedar forests',
                'University campus tours',
                'Photography of Alpine architecture',
                'Visit Lion Stone sculpture',
                'Nature walks and fresh air'
            ],
            'cuisine' => [
                'Mountain trout',
                'European-style cuisine',
                'Fresh dairy products',
                'International university fare'
            ]
        ],
        'ouarzazate' => [
            'name' => 'Ouarzazate',
            'type' => 'hidden',
            'subtitle' => 'Hollywood of Africa',
            'description' => 'The "Gateway to the Sahara" and Morocco\'s film capital, where countless Hollywood productions have been filmed.',
            'long_description' => 'Ouarzazate, known as the "Gateway to the Sahara," has earned international fame as the "Hollywood of Africa" due to its starring role in countless film productions. Located at the edge of the Sahara Desert, this city serves as the perfect backdrop for epic movies, with major productions like "Lawrence of Arabia," "Gladiator," and "Game of Thrones" filmed here. The nearby Ait Ben Haddou, a UNESCO World Heritage site, is one of Morocco\'s most iconic kasbahs and a favorite filming location. Beyond its cinematic fame, Ouarzazate offers authentic desert experiences, traditional Berber culture, and serves as the launching point for Sahara Desert expeditions to the famous Erg Chebbi dunes.',
            'highlights' => ['Film Studios', 'Ait Ben Haddou', 'Desert Gateway', 'Kasbahs', 'Solar Power Plant', 'Atlas Studios'],
            'rating' => '4.4',
            'badge' => 'Hollywood of Africa',
            'main_image' => 'https://images.unsplash.com/photo-1572985102448-d7506f8e43e0?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1587974781560-81e04947fa70?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1589463518373-4b9e0a04e47b?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop'
            ],
            'best_time' => 'October to April',
            'activities' => [
                'Tour film studios',
                'Visit Ait Ben Haddou kasbah',
                'Desert excursions to Sahara',
                'Explore traditional kasbahs',
                'Sunset camel rides',
                'Berber village visits'
            ],
            'cuisine' => [
                'Desert specialties',
                'Berber tagines',
                'Date and almond sweets',
                'Traditional couscous'
            ]
        ],
        'azrou' => [
            'name' => 'Azrou',
            'type' => 'hidden',
            'subtitle' => 'Heart of Berber Culture',
            'description' => 'A charming Berber town in the Middle Atlas, famous for its weekly souk and cedar forests.',
            'long_description' => 'Azrou, which means "rock" in the Berber language, is an authentic Middle Atlas town that offers visitors a genuine glimpse into traditional Berber culture. Located in the heart of Morocco\'s largest cedar forest, Azrou is famous for its weekly Tuesday souk, where local Berber tribes gather to trade everything from livestock to handwoven carpets. The surrounding cedar forests are home to the endangered Barbary macaques, offering excellent opportunities for wildlife viewing and nature photography. The town maintains its traditional character with few tourist developments, making it perfect for those seeking an authentic Moroccan experience away from the crowds.',
            'highlights' => ['Berber Culture', 'Cedar Forest', 'Barbary Apes', 'Handicrafts', 'Weekly Souk', 'Traditional Architecture'],
            'rating' => '4.3',
            'badge' => 'Berber Heritage',
            'main_image' => 'https://images.unsplash.com/photo-1594736797933-d0d4a4ab9b8e?w=800&h=500&fit=crop',
            'gallery' => [
                'https://images.unsplash.com/photo-1574469567135-b6de2be3c60a?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1587974781560-81e04947fa70?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1589463518373-4b9e0a04e47b?w=600&h=400&fit=crop',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=600&h=400&fit=crop'
            ],
            'best_time' => 'April to October',
            'activities' => [
                'Experience weekly Tuesday souk',
                'Hike in cedar forests',
                'Watch Barbary macaques',
                'Learn traditional crafts',
                'Visit local cooperatives',
                'Explore Berber villages'
            ],
            'cuisine' => [
                'Traditional Berber dishes',
                'Cedar honey specialties',
                'Mountain herbs and teas',
                'Homemade dairy products'
            ]
        ]
    ];

    public function show($city)
    {
        $cityData = $this->cities[$city] ?? null;
        
        if (!$cityData) {
            abort(404);
        }

        return view('city-detail', compact('cityData'));
    }
}
