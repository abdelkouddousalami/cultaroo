<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\HostApplication;
use App\Models\VerificationRequest;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the authentication page.
     */
    public function showAuthPage()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }
        return view('auth');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:traveler,host,both',
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return back()->withErrors($validator)->withInput()->with('error', 'Please check the form for errors.');
        }

        try {
            // Store user data in session for later use after OTP verification
            session([
                'pending_user_data' => [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'user_type' => $request->user_type,
                    'role' => $this->determineRole($request->user_type),
                ]
            ]);

            // Generate and send OTP
            $otpService = new OTPService();
            $otpService->generateAndSendOTP($request->email);

            // Check if the request expects JSON (for AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration initiated! Please check your email for verification code.',
                    'redirect' => route('auth.verify-otp-page') . '?email=' . urlencode($request->email)
                ]);
            }
            
            // For regular form submission, redirect to OTP verification
            return redirect()->route('auth.verify-otp-page', ['email' => $request->email])
                ->with('success', 'Please check your email for verification code.');

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'data' => $request->except(['password', 'password_confirmation'])
            ]);
            
            $errorMessage = 'Registration failed. Please try again.';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }
            
            return back()->withInput()->with('error', $errorMessage);
        }
    }

    /**
     * Determine user role based on user type.
     */
    private function determineRole($userType)
    {
        return match($userType) {
            'host' => 'host',
            'traveler' => 'visitor',
            default => 'visitor'
        };
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Update last active timestamp
            /** @var User $user */
            $user = Auth::user();
            $user->last_active_at = now();
            $user->save();

            // Redirect based on user role
            $redirectRoute = $user->role === 'admin' ? 'admin.panel' : 'profile';
            $redirectUrl = route($redirectRoute);

            // Debug logging
            Log::info('User login successful', [
                'user_id' => $user->id,
                'user_role' => $user->role,
                'redirect_route' => $redirectRoute,
                'redirect_url' => $redirectUrl
            ]);

            // Check if the request expects JSON (for AJAX)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'user' => Auth::user(),
                    'redirect' => $redirectUrl
                ]);
            }
            
            // For regular form submission, use flash message
            return redirect($redirectUrl)->with('success', 'Welcome back! You have been logged in successfully.');
        }

        // Debug logging for failed login
        Log::warning('Login attempt failed', [
            'email' => $credentials['email'],
            'ip' => $request->ip()
        ]);

        $errorMessage = 'Invalid credentials. Please check your email and password.';
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 401);
        }
        
        return back()->withErrors([
            'email' => $errorMessage,
        ])->with('error', $errorMessage);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Check if this is an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
                'redirect' => route('auth')
            ]);
        }

        // For regular form submission, redirect directly
        return redirect()->route('auth');
    }

    /**
     * Show the user profile page.
     */
    public function showProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('auth');
        }

        $user = Auth::user();
        
        // Redirect admins to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.panel');
        }
        
        // Get user's bookings (as guest)
        $bookings = $user->guestBookings()->with(['host', 'announcement'])->orderBy('created_at', 'desc')->get();
        
        // Get user's host bookings (as host)
        $hostBookings = $user->hostBookings()->with(['guest', 'announcement'])->orderBy('created_at', 'desc')->get();
        
        // Get user's host application
        $hostApplication = $user->hostApplication;

        return view('profile', [
            'user' => $user,
            'bookings' => $bookings,
            'hostBookings' => $hostBookings,
            'hostApplication' => $hostApplication
        ]);
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'user_type' => 'nullable|in:traveler,host',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'languages' => 'nullable|string',
            'interests' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updateData = [];
            
            // Only update fields that are provided in the request
            if ($request->filled('first_name')) {
                $updateData['first_name'] = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $updateData['last_name'] = $request->last_name;
            }
            if ($request->filled('first_name') || $request->filled('last_name')) {
                $firstName = $request->filled('first_name') ? $request->first_name : $user->first_name;
                $lastName = $request->filled('last_name') ? $request->last_name : $user->last_name;
                $updateData['name'] = trim($firstName . ' ' . $lastName);
            }
            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }
            if ($request->filled('user_type')) {
                $updateData['user_type'] = $request->user_type;
            }
            if ($request->filled('phone')) {
                $updateData['phone'] = $request->phone;
            }
            if ($request->filled('bio')) {
                $updateData['bio'] = $request->bio;
            }
            if ($request->filled('country')) {
                $updateData['country'] = $request->country;
            }
            if ($request->filled('city')) {
                $updateData['city'] = $request->city;
            }
            if ($request->filled('date_of_birth')) {
                $updateData['date_of_birth'] = $request->date_of_birth;
            }
            if ($request->filled('gender')) {
                $updateData['gender'] = $request->gender;
            }
            if ($request->filled('languages')) {
                $updateData['languages'] = explode(',', $request->languages);
            }
            if ($request->filled('interests')) {
                $updateData['interests'] = explode(',', $request->interests);
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profile_pictures', $filename, 'public');
                $updateData['profile_picture'] = $path;
            }

            /** @var User $user */
            $user = Auth::user();
            
            // Only update if there are changes to make
            if (!empty($updateData)) {
                // Update each field individually
                foreach ($updateData as $field => $value) {
                    $user->$field = $value;
                }
                $user->save();
            } else if (!$request->hasFile('profile_picture')) {
                // If no data to update and no file uploaded, return error
                return response()->json([
                    'success' => false,
                    'message' => 'No data provided to update.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => $user->refresh()
            ]);

        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Profile update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change user password.
     */
    public function changePassword(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 400);
        }

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Password change failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Submit host application.
     */
    public function submitHostApplication(Request $request)
    {
        // Debug logging
        Log::info('Host application submission started', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'no email',
            'request_data' => $request->except(['national_id_document', 'house_ownership_document']),
            'has_national_id' => $request->hasFile('national_id_document'),
            'has_ownership_doc' => $request->hasFile('house_ownership_document'),
        ]);

        if (!Auth::check()) {
            Log::warning('Host application attempt without authentication');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        // Check if user already has an application
        if ($user->hostApplication) {
            Log::info('User already has host application', ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted a host application.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'national_id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'city' => 'required|string|max:255',
            'languages' => 'required|array|min:1',
            'languages.*' => 'string|max:100',
            'family_members_count' => 'required|integer|min:1|max:20',
            'house_ownership_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'motivation' => 'required|string|min:50|max:2000',
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'string|max:100',
        ]);

        if ($validator->fails()) {
            Log::warning('Host application validation failed', [
                'user_id' => $user->id,
                'errors' => $validator->errors()->toArray()
            ]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Log::info('Storing host application files', ['user_id' => $user->id]);
            
            // Store uploaded files
            $nationalIdPath = $request->file('national_id_document')->store('host-applications/national-ids', 'public');
            $ownershipDocPath = $request->file('house_ownership_document')->store('host-applications/ownership-docs', 'public');

            Log::info('Files stored successfully', [
                'user_id' => $user->id,
                'national_id_path' => $nationalIdPath,
                'ownership_doc_path' => $ownershipDocPath
            ]);

            // Create host application
            $application = HostApplication::create([
                'user_id' => $user->id,
                'national_id_document' => $nationalIdPath,
                'city' => $request->city,
                'languages' => $request->languages,
                'family_members_count' => $request->family_members_count,
                'house_ownership_document' => $ownershipDocPath,
                'motivation' => $request->motivation,
                'amenities' => $request->amenities,
                'status' => 'pending',
            ]);

            Log::info('Host application created successfully', [
                'user_id' => $user->id,
                'application_id' => $application->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your host application has been submitted successfully! We will review it and get back to you soon.'
            ]);

        } catch (\Exception $e) {
            Log::error('Host application submission failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit application. Please try again.'
            ], 500);
        }
    }

    /**
     * Show the admin panel.
     */
    public function showAdminPanel()
    {
        $users = User::with('verificationRequests')->orderBy('created_at', 'desc')->paginate(20);
        $hostApplications = HostApplication::with('user')->orderBy('created_at', 'desc')->paginate(10);
        
        // Dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_visitors' => User::where('role', 'visitor')->count(),
            'total_hosts' => User::where('role', 'host')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_applications' => HostApplication::where('status', 'pending')->count(),
            'approved_applications' => HostApplication::where('status', 'approved')->count(),
            'rejected_applications' => HostApplication::where('status', 'rejected')->count(),
            'total_applications' => HostApplication::count(),
            'pending_verifications' => VerificationRequest::where('status', 'pending')->count(),
            'approved_verifications' => VerificationRequest::where('status', 'approved')->count(),
            'rejected_verifications' => VerificationRequest::where('status', 'rejected')->count(),
            'total_verifications' => VerificationRequest::count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'recent_applications' => HostApplication::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('admin.panel', compact('users', 'hostApplications', 'stats'));
    }

    /**
     * Update user role.
     */
    public function updateUserRole(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:visitor,host,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "User role updated to {$user->role_display} successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user role. Please try again.'
            ], 500);
        }
    }

    /**
     * Review host application.
     */
    public function reviewHostApplication(Request $request, HostApplication $hostApplication)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $hostApplication->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
            ]);

            // If approved, update user role to host
            if ($request->status === 'approved') {
                $hostApplication->user->update(['role' => 'host']);
            }

            return response()->json([
                'success' => true,
                'message' => "Host application {$request->status} successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to review host application. Please try again.'
            ], 500);
        }
    }

    /**
     * Show OTP verification page
     */
    public function showOtpVerification(Request $request)
    {
        $email = $request->get('email');
        
        if (!$email || !session('pending_user_data')) {
            return redirect()->route('auth')->with('error', 'Invalid verification request.');
        }

        return view('verify-otp', ['email' => $email]);
    }

    /**
     * Verify OTP code and complete registration
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code format.'
            ], 422);
        }

        try {
            $otpService = new OTPService();
            
            // Verify OTP
            if (!$otpService->verifyOTP($request->email, $request->otp_code)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired verification code.'
                ]);
            }

            // Get pending user data from session
            $pendingUserData = session('pending_user_data');
            if (!$pendingUserData || $pendingUserData['email'] !== $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification request.'
                ]);
            }

            // Add email verification timestamp to user data
            $pendingUserData['email_verified_at'] = now();

            // Create the user with email verification timestamp
            $user = User::create($pendingUserData);

            // Clear pending user data
            session()->forget('pending_user_data');

            // Log the user in
            Auth::login($user);

            // Redirect based on user role
            $redirectRoute = $user->role === 'admin' ? 'admin.panel' : 'profile';

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully! Welcome to Culturoo!',
                'redirect' => route($redirectRoute),
                'verification_time' => $user->email_verified_at->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            Log::error('OTP verification failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.'
            ], 422);
        }

        try {
            // Check if there's pending user data for this email
            $pendingUserData = session('pending_user_data');
            if (!$pendingUserData || $pendingUserData['email'] !== $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid resend request.'
                ]);
            }

            $otpService = new OTPService();
            $otpService->generateAndSendOTP($request->email);

            return response()->json([
                'success' => true,
                'message' => 'Verification code resent successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('OTP resend failed', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to resend verification code. Please try again.'
            ], 500);
        }
    }
}
