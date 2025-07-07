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
    </style>
</head>
<body class="bg-gray-50 moroccan-pattern">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="{{ asset('images/logos/logo.png') }}" alt="Culturoo">
                        <span class="ml-3 text-2xl font-bold gradient-text font-playfair">Culturoo</span>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-orange-600 transition-colors">Home</a>
                    <a href="{{ url('/listings') }}" class="text-gray-700 hover:text-orange-600 transition-colors">Host Families</a>
                    <a href="{{ url('/contact') }}" class="text-orange-600 font-medium">Contact</a>
                    <a href="{{ url('/auth') }}" class="btn-moroccan text-white px-6 py-2 rounded-full font-medium">Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section flex items-center justify-center text-white text-center">
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
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center mb-4">
                        <img class="h-8 w-auto" src="{{ asset('images/logos/logo.png') }}" alt="Culturoo">
                        <span class="ml-3 text-xl font-bold gradient-text font-playfair">Culturoo</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Experience authentic Moroccan culture with local host families. 
                        Create memories that last a lifetime.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Twitter</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ url('/listings') }}" class="text-gray-400 hover:text-white transition-colors">Host Families</a></li>
                        <li><a href="{{ url('/auth') }}" class="text-gray-400 hover:text-white transition-colors">Sign Up</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Safety</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 Culturoo. All rights reserved.</p>
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
                    alert(result.message);
                    // Reset form
                    this.reset();
                } else {
                    alert(result.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            })
            .finally(() => {
                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

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
    </script>
</body>
</html>
