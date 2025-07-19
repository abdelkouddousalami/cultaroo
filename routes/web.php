<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\VerificationController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/our-book', function () {
    return view('our-book');
})->name('our-book');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/city/{city}', [CityController::class, 'show'])->name('city.show');

// Debug route to test host application endpoint
Route::post('/test-host-endpoint', function(Request $request) {
    Log::info('Test host endpoint called', ['data' => $request->all()]);
    return response()->json(['success' => true, 'message' => 'Test endpoint working', 'data' => $request->all()]);
})->middleware('auth');

Route::get('/auth', [AuthController::class, 'showAuthPage'])->name('auth');
Route::get('/login', [AuthController::class, 'showAuthPage'])->name('login');
Route::get('/register', [AuthController::class, 'showAuthPage'])->name('register');

// Authentication routes
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// OTP verification routes
Route::get('/verify-otp', [AuthController::class, 'showOtpVerification'])->name('auth.verify-otp-page');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resend-otp');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
    
    // Host application routes
    Route::post('/host-application', [AuthController::class, 'submitHostApplication'])->name('host-application.submit');
    
    // Message routes
    Route::post('/messages', [HostingController::class, 'sendDirectMessage'])->name('messages.send');
    
    // Verification routes
    Route::post('/verification/submit', [VerificationController::class, 'store'])->name('verification.store');
    Route::get('/verification/status', [VerificationController::class, 'status'])->name('verification.status');
    
    // Booking routes
    Route::post('/bookings', [HostingController::class, 'storeBooking'])->name('bookings.store');
    Route::post('/listings/{announcement}/book', [HostingController::class, 'bookAnnouncement'])->name('listings.book');
    Route::get('/bookings/{booking}', [HostingController::class, 'showBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/respond', [HostingController::class, 'respondToBooking'])->name('bookings.respond');
    Route::post('/bookings/{booking}/message', [HostingController::class, 'sendMessage'])->name('bookings.message');
    
    // Host routes
    Route::middleware('host')->group(function () {
        Route::get('/host/dashboard', [HostingController::class, 'showHostDashboard'])->name('host.dashboard');
        Route::get('/host/announcements/create', [HostingController::class, 'showCreateAnnouncement'])->name('host.announcements.create');
        Route::post('/host/announcements', [HostingController::class, 'storeAnnouncement'])->name('host.announcements.store');
    });
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AuthController::class, 'showAdminPanel'])->name('admin.panel');
        Route::post('/admin/users/{user}/role', [AuthController::class, 'updateUserRole'])->name('admin.update-role');
        Route::post('/admin/host-applications/{hostApplication}/review', [AuthController::class, 'reviewHostApplication'])->name('admin.review-host-application');
        
        // Debug route
        Route::get('/admin/debug', function() {
            return view('admin.debug');
        })->name('admin.debug');
        
        Route::get('/admin/verification-debug', function() {
            return view('admin.verification-debug');
        })->name('admin.verification-debug');
        
        Route::get('/admin/login-test', function() {
            return view('admin.login-test');
        })->name('admin.login-test');
        
        // Admin verification routes
        Route::get('/admin/verification-requests', [VerificationController::class, 'adminIndex'])->name('admin.verification-requests');
        Route::put('/admin/verification-requests/{verificationRequest}', [VerificationController::class, 'adminUpdate'])->name('admin.verification-requests.update');
    });
});

Route::get('/listings', [HostingController::class, 'showListings'])->name('listings.index');
Route::get('/listings/{announcement}', [HostingController::class, 'showAnnouncement'])->name('listings.show');