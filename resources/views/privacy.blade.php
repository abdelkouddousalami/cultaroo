
@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 fade-in">
    <h1 class="text-3xl md:text-4xl font-bold mb-6 gradient-text-animated text-center">Privacy & Policy</h1>
    <p class="text-sm text-gray-500 text-center mb-8">Last Updated: July 10, 2025</p>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">🔐 Core Privacy Principles</h2>
        <h3 class="font-semibold text-orange-600 mb-2">Zero Financial Data Collection</h3>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>We never collect, store, or process:</li>
            <li class="ml-4">Credit/debit card numbers</li>
            <li class="ml-4">Bank account details</li>
            <li class="ml-4">CVV/CVC codes</li>
        </ul>
        <p class="mb-2">All payments are processed through PCI-DSS certified partners (PayPal/Paymob).</p>
        <h3 class="font-semibold text-orange-600 mb-2">Data Minimization</h3>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>We collect only essential information required for:</li>
            <li class="ml-4">Booking verification (name, email)</li>
            <li class="ml-4">Safety vetting (ID verification)</li>
            <li class="ml-4">Experience personalization (dietary preferences)</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">🛡️ Advanced Privacy Safeguards</h2>
        <h3 class="font-semibold text-orange-600 mb-2">A. Payment Processing Rules</h3>
        <div class="mb-2">
            <strong>Section 3.2: Financial Transactions</strong><br>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>All payments are processed externally via encrypted gateways</li>
                <li>We only receive:
                    <ul class="list-disc ml-6">
                        <li>✓ Transaction status (approved/denied)</li>
                        <li>✓ Transaction ID</li>
                        <li>✓ Amount paid</li>
                    </ul>
                </li>
                <li><strong>No payment instrument data</strong> is accessible to our systems</li>
            </ul>
        </div>
        <h3 class="font-semibold text-orange-600 mb-2">B. Biometric Data Protection</h3>
        <div class="mb-2">
            <strong>Section 4.7: Special Category Data</strong><br>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>We explicitly prohibit and prevent collection of:</li>
                <li class="ml-4">Facial recognition data</li>
                <li class="ml-4">Fingerprints</li>
                <li class="ml-4">Voiceprints</li>
                <li class="ml-4 italic">*Exception: Optional host family verification photos (user-uploaded)*</li>
            </ul>
        </div>
        <h3 class="font-semibold text-orange-600 mb-2">C. Behavioral Tracking Opt-Out</h3>
        <div class="mb-2">
            <strong>Section 6.3: Advertising Networks</strong><br>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>We use <strong>zero</strong> cross-site tracking cookies</li>
                <li>Opt-out of all analytics: <span class="bg-orange-100 px-2 py-1 rounded">[Disable Tracking Button]</span> in your profile</li>
                <li>We never sell data to third-party advertisers</li>
            </ul>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">⚖️ Legal Compliance Framework</h2>
        <table class="w-full text-left border border-orange-200 rounded-lg shadow-md text-base mb-4">
            <thead class="bg-orange-100">
                <tr>
                    <th class="py-3 px-4 font-semibold">Regulation</th>
                    <th class="py-3 px-4 font-semibold">Our Compliance</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr><td class="py-2 px-4">GDPR</td><td class="py-2 px-4">Data Protection Officer appointed<br>Standard Contractual Clauses for EU transfers</td></tr>
                <tr><td class="py-2 px-4">CCPA</td><td class="py-2 px-4">"Do Not Sell My Data" portal<br>Verified deletion requests in 45 days</td></tr>
                <tr><td class="py-2 px-4">PCI-DSS</td><td class="py-2 px-4">Payment data fully outsourced to Level 1 processors</td></tr>
                <tr><td class="py-2 px-4">HIPAA</td><td class="py-2 px-4">Medical data encryption (allergy info)</td></tr>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">🔍 Transparency Mechanisms</h2>
        <h3 class="font-semibold text-orange-600 mb-2">Real-Time Data Audit</h3>
        <p class="mb-2">Users can download live data report: <span class="bg-orange-100 px-2 py-1 rounded">[See What We Store]</span> button in privacy dashboard</p>
        <h3 class="font-semibold text-orange-600 mb-2">Breach Notification Promise</h3>
        <p class="mb-2">We will notify you within 72 hours of any data incident affecting your information</p>
        <h3 class="font-semibold text-orange-600 mb-2">Third-Party Vendors List</h3>
        <table class="w-full text-left border border-orange-200 rounded-lg shadow-md text-base mb-4">
            <thead class="bg-orange-100">
                <tr>
                    <th class="py-3 px-4 font-semibold">Vendor</th>
                    <th class="py-3 px-4 font-semibold">Purpose</th>
                    <th class="py-3 px-4 font-semibold">Data Shared</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <tr><td class="py-2 px-4">Paymob</td><td class="py-2 px-4">Payment Processing</td><td class="py-2 px-4">Transaction ID</td></tr>
                <tr><td class="py-2 px-4">Auth0</td><td class="py-2 px-4">Login</td><td class="py-2 px-4">Email, Name</td></tr>
                <tr><td class="py-2 px-4">Google Analytics</td><td class="py-2 px-4">Performance</td><td class="py-2 px-4">Anonymized IP</td></tr>
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">� Prohibited Data Practices</h2>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>Location Tracking: "We never collect continuous location data - only city-level booking information"</li>
            <li>Microphone/Camera Access: "The app requires NO microphone or camera permissions"</li>
            <li>Social Media Scraping: "We never import contacts or scan social profiles"</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">📜 Full Policy Highlights</h2>
        <h3 class="font-semibold text-orange-600 mb-2">Section 1: Data We Collect</h3>
        <div class="mb-2">
            <strong>1.1 User Profile:</strong>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>Name, email, phone number</li>
                <li>Dietary preferences (voluntary)</li>
            </ul>
            <strong>1.2 Booking Information:</strong>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>Travel dates</li>
                <li>Experience preferences</li>
            </ul>
            <strong>1.3 Explicitly Excluded:</strong>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>Financial instruments</li>
                <li>Genetic/biometric data</li>
                <li>Political/religious views</li>
            </ul>
        </div>
        <h3 class="font-semibold text-orange-600 mb-2">Section 5: Your Rights</h3>
        <div class="mb-2">
            <strong>5.1 Right to Financial Privacy:</strong> Request deletion of all payment references<br>
            <strong>5.2 Right to Anonymity:</strong> Book as 'Private Guest' (alias name visible to hosts)<br>
            <strong>5.3 Right to Data Portability:</strong> Export bookings to competitor platforms
        </div>
        <h3 class="font-semibold text-orange-600 mb-2">Section 7: Security Protocols</h3>
        <div class="mb-2">
            <strong>7.1 Payment Data Isolation:</strong>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>Payment pages hosted externally</li>
                <li>Iframe sandboxing with CSP protections</li>
            </ul>
            <strong>7.2 Zero-Knowledge Architecture:</strong>
            <ul class="list-disc ml-6 text-gray-700 mb-2">
                <li>End-to-end encrypted messages</li>
                <li>Hosts see only necessary guest info</li>
            </ul>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">⚠️ Violation Consequences</h2>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>For Employees: "Attempting to access payment data = Immediate termination + $50,000 legal penalty"</li>
            <li>For Hosts: "Requesting off-platform payments = Permanent ban + forfeiture of earnings"</li>
            <li>For Users: "Fraudulent chargebacks = Account suspension + $25 investigation fee"</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">🌐 Global Privacy Addendums</h2>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li><strong>EU/UK Residents:</strong> Data processed under GDPR Article 6(1)(b), Right to lodge complaints with supervisory authority</li>
            <li><strong>California Residents:</strong> Annual CCPA report available at privacy.culturoo.com/ccpa, Opt-out of data sales via <span class="bg-orange-100 px-2 py-1 rounded">[Do Not Sell Form]</span></li>
            <li><strong>Moroccan Residents:</strong> Compliance with Law 09-08, Data processed at local Casablanca servers</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">✅ User Verification Tools</h2>
        <h3 class="font-semibold text-orange-600 mb-2">Privacy Health Check</h3>
        <img src="https://i.imgur.com/5Ykz7Fd.png" alt="Privacy Health Check" class="w-full max-w-md mx-auto mb-4 rounded-xl border-2 border-orange-200">
        <p class="mb-2">Real-time privacy scoring system in user profiles</p>
        <h3 class="font-semibold text-orange-600 mb-2">Automated Data Purge</h3>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>[ ] Enable auto-delete:
                <ul class="list-disc ml-6">
                    <li>▢ After booking completion</li>
                    <li>▢ After 6 months inactive</li>
                    <li>▢ On demand</li>
                </ul>
            </li>
        </ul>
        <h3 class="font-semibold text-orange-600 mb-2">Anonymous Mode</h3>
        <p class="mb-2">Book as 'Mystery Guest' - hosts see only:</p>
        <ul class="list-disc ml-6 text-gray-700 mb-4">
            <li>Nationality</li>
            <li>Dietary needs</li>
            <li>Experience preferences</li>
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-orange-700 mb-4">📥 Contact Our Privacy Team</h2>
        <div class="mb-2">
            <strong>Data Protection Officer:</strong><br>
            Dr. Leila Ahmed<br>
            <a href="mailto:dpo@culturoo.com" class="text-orange-600 underline">dpo@culturoo.com</a><br>
            +212 600-123456 (9AM-5PM GMT)
        </div>
        <div class="mb-2">
            <strong>Breach Reporting:</strong><br>
            <a href="mailto:security@culturoo.com" class="text-orange-600 underline">security@culturoo.com</a> (24/7 monitored)
        </div>
        <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded mb-4 text-orange-700 font-semibold">
            Our Binding Promise:<br>
            "We profit from experiences, not your data."
        </div>
    </div>
</div>
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
@endsection
