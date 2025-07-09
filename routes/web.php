<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HostingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/our-book', function () {
    return view('our-book');
})->name('our-book');

Route::get('/city/{city}', [CityController::class, 'show'])->name('city.show');

Route::get('/test-host-app', function () {
    return view('test-host-application');
})->middleware('auth');

Route::get('/simple-test', function () {
    return view('simple-test');
})->middleware('auth');

Route::get('/test-route', function () {
    return response()->json(['success' => true, 'message' => 'Test route working']);
})->middleware('auth');

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
    
    // Test route for debugging
    Route::get('/test/host-create', function () {
        return view('host.create-announcement');
    })->name('test.host.create');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AuthController::class, 'showAdminPanel'])->name('admin.panel');
        Route::post('/admin/users/{user}/role', [AuthController::class, 'updateUserRole'])->name('admin.update-role');
        Route::post('/admin/host-applications/{hostApplication}/review', [AuthController::class, 'reviewHostApplication'])->name('admin.review-host-application');
    });
});

// Public routes
Route::get('/listings', [HostingController::class, 'showListings'])->name('listings.index');
Route::get('/listings/{announcement}', [HostingController::class, 'showAnnouncement'])->name('listings.show');

// Test email route (remove this after testing)
Route::get('/test-mail-config', function () {
    try {
        $testEmail = 'abdoalami.ru@gmail.com';
        Mail::raw('This is a test email from Culturoo to verify SMTP configuration.', function ($message) use ($testEmail) {
            $message->to($testEmail)
                    ->subject('Culturoo SMTP Test')
                    ->from('abdoalami.ru@gmail.com', 'Culturoo');
        });
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully to ' . $testEmail
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send email: ' . $e->getMessage()
        ]);
    }
});

// Test route to check user email verification status (remove after testing)
Route::get('/test-verification-status/{email}', function ($email) {
    try {
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'email' => $user->email,
                'name' => $user->name,
                'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->toDateTimeString() : null,
                'is_verified' => $user->hasVerifiedEmail(),
                'verification_status' => $user->email_verification_status,
                'created_at' => $user->created_at->toDateTimeString()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
});
