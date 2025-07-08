<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Hosting Announcement - Culturoo</title>
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
        .form-card {
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
        .image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
        }
        /* Searchable dropdown styling */
        input[list] {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
        }
        
        input[list]::-webkit-calendar-picker-indicator {
            opacity: 0;
        }
        
        /* Custom datalist appearance */
        datalist {
            max-height: 200px;
            overflow-y: auto;
        }
        
        @-moz-document url-prefix() {
            /* Styling for Firefox */
            input[list] {
                appearance: none;
            }
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
                    <a href="{{ route('listings.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Browse Listings</a>
                    <a href="{{ route('host.dashboard') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Dashboard</a>
                    <a href="{{ route('profile') }}" class="text-gray-700 hover:text-orange-600 transition-colors duration-300">Profile</a>
                    <span class="text-gray-700">Host: <span class="font-semibold text-green-600">{{ Auth::user()->first_name }}</span></span>
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

        <!-- Header -->
        <div class="form-card rounded-2xl p-8 shadow-lg mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-['Playfair_Display'] font-bold gradient-text mb-2">Create Hosting Announcement</h1>
                    <p class="text-gray-600">Share your home and culture with travelers from around the world</p>
                </div>
                <a href="{{ route('host.dashboard') }}" class="text-gray-600 hover:text-gray-800 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Form -->
        <form id="announcement-form" class="form-card rounded-2xl p-8 shadow-lg space-y-8">
            @csrf

            <!-- Basic Information -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                            placeholder="e.g., Cozy Traditional Riad in Marrakech Medina">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="announcementCityInput" list="announcementMoroccanCities" placeholder="Type to search cities..." 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                            <input type="hidden" name="city" id="announcementCityHidden" required>
                            <datalist id="announcementMoroccanCities">
                                <option value="Agadir">Agadir</option>
                                <option value="Al Hoceima">Al Hoceima</option>
                                <option value="Assilah">Assilah</option>
                                <option value="Azemmour">Azemmour</option>
                                <option value="Beni Mellal">Beni Mellal</option>
                                <option value="Casablanca">Casablanca</option>
                                <option value="Chefchaouen">Chefchaouen</option>
                                <option value="El Jadida">El Jadida</option>
                                <option value="Erfoud">Erfoud</option>
                                <option value="Essaouira">Essaouira</option>
                                <option value="Fez">Fez</option>
                                <option value="Ifrane">Ifrane</option>
                                <option value="Kenitra">Kenitra</option>
                                <option value="Larache">Larache</option>
                                <option value="Marrakech">Marrakech</option>
                                <option value="Meknes">Meknes</option>
                                <option value="Merzouga">Merzouga</option>
                                <option value="Mohammedia">Mohammedia</option>
                                <option value="Nador">Nador</option>
                                <option value="Ouarzazate">Ouarzazate</option>
                                <option value="Oujda">Oujda</option>
                                <option value="Rabat">Rabat</option>
                                <option value="Safi">Safi</option>
                                <option value="Sale">Sale</option>
                                <option value="Tangier">Tangier</option>
                                <option value="Taroudant">Taroudant</option>
                                <option value="Taza">Taza</option>
                                <option value="Tetouan">Tetouan</option>
                                <option value="Tinghir">Tinghir</option>
                                <option value="Zagora">Zagora</option>
                            </datalist>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="5" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                    placeholder="Describe your place, what makes it special, the cultural experiences you offer, and what guests can expect during their stay..."
                    oninput="updateCharacterCount(this, 'description-char-count', 50, 2000)"></textarea>
                <div class="flex justify-between text-sm text-gray-500 mt-1">
                    <span>Minimum 50 characters required</span>
                    <span id="description-char-count">0/50</span>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Full Address <span class="text-red-500">*</span>
                </label>
                <textarea name="address" rows="2" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                    placeholder="Full address including street, neighborhood, postal code"></textarea>
            </div>

            <!-- Room Details -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Room Details</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Room Type <span class="text-red-500">*</span>
                        </label>
                        <select name="room_type" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                            <option value="">Select room type</option>
                            <option value="private_room">Private Room</option>
                            <option value="shared_room">Shared Room</option>
                            <option value="entire_place">Entire Place</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Price per Night (MAD) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price_per_night" min="0" step="0.01" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                            placeholder="e.g., 200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Maximum Guests <span class="text-red-500">*</span>
                        </label>
                        <select name="max_guests" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                            <option value="">Select max guests</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'guest' : 'guests' }}</option>
                            @endfor
                            <option value="11">More than 10</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Languages -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Languages You Speak <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="Arabic" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Arabic</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="Berber/Amazigh" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Berber/Amazigh</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="French" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">French</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="English" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">English</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="Spanish" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Spanish</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="German" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">German</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="Italian" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Italian</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="languages[]" value="Other" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Other</span>
                    </label>
                </div>
            </div>

            <!-- Amenities -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Available Amenities <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="WiFi" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">WiFi</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Private Shower" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Private Shower</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Shared Bathroom" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Shared Bathroom</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Air Conditioning" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Air Conditioning</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Heating" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Heating</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Kitchen Access" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Kitchen Access</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Laundry" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Laundry</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Parking" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Parking</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Balcony/Terrace" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Balcony/Terrace</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Garden" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Garden</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Traditional Decor" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Traditional Decor</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="amenities[]" value="Meals Included" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                        <span class="ml-2 text-sm">Meals Included</span>
                    </label>
                </div>
            </div>

            <!-- House Rules -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    House Rules (Optional)
                </label>
                <div id="house-rules-container">
                    <div class="flex items-center space-x-2 mb-2">
                        <input type="text" name="house_rules[]" 
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                            placeholder="e.g., No smoking indoors">
                        <button type="button" onclick="removeRule(this)" class="text-red-600 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addRule()" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                    + Add Rule
                </button>
            </div>

            <!-- Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Photos (Optional - Maximum 5 images)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" onchange="handleImageUpload(this)">
                    <label for="images" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-gray-600">Click to upload images or drag and drop</p>
                        <p class="text-sm text-gray-500 mt-1">PNG, JPG, GIF up to 5MB each</p>
                    </label>
                </div>
                <div id="image-preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-4"></div>
            </div>

            <!-- Availability -->
            <div>
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Availability (Optional)</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Available From
                        </label>
                        <input type="date" name="available_from" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Available Until
                        </label>
                        <input type="date" name="available_until" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300">
                    </div>
                </div>
            </div>

            <!-- Special Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Special Notes (Optional)
                </label>
                <textarea name="special_notes" rows="3" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                    placeholder="Any additional information guests should know..."
                    oninput="updateCharacterCount(this, 'notes-char-count', 0, 1000)"></textarea>
                <div class="text-right text-sm text-gray-500 mt-1">
                    <span id="notes-char-count">0/1000</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('host.dashboard') }}" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                    Cancel
                </a>
                <button type="submit" 
                    class="btn-moroccan text-white px-8 py-3 rounded-lg font-medium transition-colors duration-300">
                    Create Announcement
                </button>
            </div>
        </form>
    </div>

    @vite('resources/js/app.js')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = message;
            
            alertContainer.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function updateCharacterCount(textarea, counterId, minChars, maxChars) {
            const count = textarea.value.length;
            const counter = document.getElementById(counterId);
            counter.textContent = `${count}/${minChars > 0 ? minChars : maxChars}`;
            
            if (minChars > 0 && count < minChars) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-green-500');
            } else if (count > maxChars) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-green-500');
            } else {
                counter.classList.add('text-green-500');
                counter.classList.remove('text-red-500');
            }
        }

        function addRule() {
            const container = document.getElementById('house-rules-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="house_rules[]" 
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-300"
                    placeholder="e.g., Quiet hours after 10 PM">
                <button type="button" onclick="removeRule(this)" class="text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            container.appendChild(div);
        }

        function removeRule(button) {
            button.closest('.flex').remove();
        }

        let selectedImages = [];

        function handleImageUpload(input) {
            const files = Array.from(input.files);
            
            if (selectedImages.length + files.length > 5) {
                showAlert('You can only upload a maximum of 5 images.', 'error');
                return;
            }

            files.forEach(file => {
                if (file.size > 5 * 1024 * 1024) {
                    showAlert(`Image ${file.name} is too large. Maximum size is 5MB.`, 'error');
                    return;
                }

                selectedImages.push(file);
                displayImagePreview(file, selectedImages.length - 1);
            });
        }

        function displayImagePreview(file, index) {
            const container = document.getElementById('image-preview-container');
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="image-preview">
                    <button type="button" onclick="removeImage(${index})" class="remove-image">×</button>
                `;
                container.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }

        function removeImage(index) {
            selectedImages.splice(index, 1);
            updateImagePreviews();
        }

        function updateImagePreviews() {
            const container = document.getElementById('image-preview-container');
            container.innerHTML = '';
            selectedImages.forEach((file, index) => {
                displayImagePreview(file, index);
            });
        }

        // Form submission
        document.getElementById('announcement-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Client-side validation
            const title = this.querySelector('input[name="title"]').value;
            const description = this.querySelector('textarea[name="description"]').value;
            const languages = this.querySelectorAll('input[name="languages[]"]:checked');
            const amenities = this.querySelectorAll('input[name="amenities[]"]:checked');
            
            let validationErrors = [];
            
            if (title.length < 3) {
                validationErrors.push('Title must be at least 3 characters long');
            }
            
            if (description.length < 50) {
                validationErrors.push('Description must be at least 50 characters long');
            }
            
            if (languages.length === 0) {
                validationErrors.push('Please select at least one language');
            }
            
            if (amenities.length === 0) {
                validationErrors.push('Please select at least one amenity');
            }
            
            if (validationErrors.length > 0) {
                showAlert('Please fix the following errors:<br><br>' + validationErrors.join('<br>'), 'error');
                return;
            }
            
            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Creating...';
            submitButton.disabled = true;
            
            try {
                const formData = new FormData(this);
                
                // Remove empty house rules
                const houseRulesInputs = this.querySelectorAll('input[name="house_rules[]"]');
                // First remove all house_rules from formData
                formData.delete('house_rules[]');
                // Then add only non-empty house rules
                houseRulesInputs.forEach((input, index) => {
                    if (input.value.trim() !== '') {
                        formData.append('house_rules[]', input.value.trim());
                    }
                });
                
                // Add selected images to form data
                selectedImages.forEach((file, index) => {
                    formData.append(`images[${index}]`, file);
                });
                
                const response = await fetch('{{ route("host.announcements.store") }}', {
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
                        window.location.href = '{{ route("host.dashboard") }}';
                    }, 1500);
                } else {
                    if (data.errors) {
                        let errorMessages = [];
                        for (const field in data.errors) {
                            const fieldName = field.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                            errorMessages.push(`${fieldName}: ${data.errors[field].join(', ')}`);
                        }
                        showAlert('Please fix the following errors:<br><br>' + errorMessages.join('<br>'), 'error');
                    } else {
                        showAlert(data.message || 'Failed to create announcement', 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'error');
            } finally {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });

        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="available_from"]').setAttribute('min', today);
            document.querySelector('input[name="available_until"]').setAttribute('min', today);
            
            // Update available_until minimum when available_from changes
            document.querySelector('input[name="available_from"]').addEventListener('change', function() {
                const availableUntil = document.querySelector('input[name="available_until"]');
                availableUntil.setAttribute('min', this.value);
                if (availableUntil.value && availableUntil.value < this.value) {
                    availableUntil.value = '';
                }
            });
        });

        // City input handling for searchable dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const cityInput = document.getElementById('announcementCityInput');
            const cityHidden = document.getElementById('announcementCityHidden');
            
            if (cityInput && cityHidden) {
                // Update hidden input when user selects a city
                cityInput.addEventListener('change', function() {
                    cityHidden.value = this.value;
                    
                    // Validate the city is in our list
                    const datalist = document.getElementById('announcementMoroccanCities');
                    const options = Array.from(datalist.options).map(opt => opt.value);
                    
                    if (!options.includes(this.value) && this.value !== '') {
                        // Reset if not valid
                        this.value = '';
                        cityHidden.value = '';
                        showAlert('Please select a city from the list', 'error');
                    }
                });
                
                // Update hidden input as user types
                cityInput.addEventListener('input', function() {
                    cityHidden.value = this.value;
                });
                
                // Also update when focus is lost
                cityInput.addEventListener('blur', function() {
                    // Wait a moment to ensure any selection is captured
                    setTimeout(() => {
                        const datalist = document.getElementById('announcementMoroccanCities');
                        const options = Array.from(datalist.options).map(opt => opt.value);
                        
                        if (!options.includes(this.value) && this.value !== '') {
                            this.value = '';
                            cityHidden.value = '';
                            showAlert('Please select a city from the list', 'error');
                        }
                    }, 200);
                });
            }
        });
    </script>
</body>
</html>
