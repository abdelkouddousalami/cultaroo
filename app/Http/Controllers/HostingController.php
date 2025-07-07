<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\HostingAnnouncement;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;

class HostingController extends Controller
{
    /**
     * Show the host dashboard.
     */
    public function showHostDashboard()
    {
        $user = Auth::user();
        
        if (!$user->isHost()) {
            return redirect()->route('profile')->with('error', 'Access denied. You need to be a host to access this page.');
        }

        $announcements = $user->hostingAnnouncements()->with('bookings')->get();
        $recentBookings = $user->hostBookings()->with(['guest', 'announcement'])->latest()->take(5)->get();
        $pendingBookings = $user->hostBookings()->where('status', 'pending')->with(['guest', 'announcement'])->get();

        $stats = [
            'total_announcements' => $announcements->count(),
            'active_announcements' => $announcements->where('is_active', true)->count(),
            'total_bookings' => $user->hostBookings()->count(),
            'pending_bookings' => $pendingBookings->count(),
            'confirmed_bookings' => $user->hostBookings()->where('status', 'confirmed')->count(),
            'total_earnings' => $user->hostBookings()->where('status', 'completed')->sum('total_price'),
        ];

        return view('host.dashboard', compact('announcements', 'recentBookings', 'pendingBookings', 'stats'));
    }

    /**
     * Show create announcement form.
     */
    public function showCreateAnnouncement()
    {
        $user = Auth::user();
        
        if (!$user->isHost()) {
            return redirect()->route('profile')->with('error', 'Access denied. You need to have a "Host" role to create announcements. Please submit a host application or register as a host.');
        }

        return view('host.create-announcement');
    }

    /**
     * Store a new hosting announcement.
     */
    public function storeAnnouncement(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isHost()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. You need to have a "Host" role to create announcements. Please submit a host application or register as a host.'
            ], 403);
        }

        // Clean the request data - remove empty house rules
        $requestData = $request->all();
        if (isset($requestData['house_rules'])) {
            $requestData['house_rules'] = array_filter($requestData['house_rules'], function($rule) {
                return !empty(trim($rule));
            });
        }

        $validator = Validator::make($requestData, [
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'price_per_night' => 'required|numeric|min:1',
            'room_type' => 'required|in:private_room,shared_room,entire_place',
            'max_guests' => 'required|integer|min:1|max:10',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'languages' => 'required|array|min:1',
            'languages.*' => 'string|max:100',
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'string|max:100',
            'house_rules' => 'nullable|array',
            'house_rules.*' => 'nullable|string|max:200',
            'available_from' => 'nullable|date|after_or_equal:today',
            'available_until' => 'nullable|date|after:available_from',
            'special_notes' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $images = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('announcements/images', 'public');
                    $images[] = $path;
                }
            }

            $announcement = HostingAnnouncement::create([
                'host_id' => $user->id,
                'title' => $requestData['title'],
                'description' => $requestData['description'],
                'price_per_night' => $requestData['price_per_night'],
                'room_type' => $requestData['room_type'],
                'max_guests' => $requestData['max_guests'],
                'city' => $requestData['city'],
                'address' => $requestData['address'],
                'languages' => $requestData['languages'],
                'amenities' => $requestData['amenities'],
                'house_rules' => $requestData['house_rules'] ?? [],
                'images' => $images,
                'available_from' => $requestData['available_from'] ?? null,
                'available_until' => $requestData['available_until'] ?? null,
                'special_notes' => $requestData['special_notes'] ?? null,
                'is_active' => true,
            ]);

            Log::info('Hosting announcement created successfully', [
                'user_id' => $user->id,
                'announcement_id' => $announcement->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your hosting announcement has been created successfully!',
                'redirect' => route('host.dashboard')
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create hosting announcement', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create announcement. Please try again.'
            ], 500);
        }
    }

    /**
     * Show all hosting announcements (public listing page).
     */
    public function showListings(Request $request)
    {
        $query = HostingAnnouncement::with('host')
            ->where('is_active', true);

        // Apply filters
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', $request->room_type);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('languages')) {
            $languages = is_array($request->languages) ? $request->languages : [$request->languages];
            foreach ($languages as $language) {
                $query->whereJsonContains('languages', $language);
            }
        }

        if ($request->filled('amenities')) {
            $amenities = is_array($request->amenities) ? $request->amenities : [$request->amenities];
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        $announcements = $query->latest()->paginate(12);

        // Get unique cities for filter dropdown
        $cities = HostingAnnouncement::where('is_active', true)
            ->distinct()
            ->pluck('city')
            ->sort();

        return view('listings.index', compact('announcements', 'cities'));
    }

    /**
     * Show a specific announcement.
     */
    public function showAnnouncement(HostingAnnouncement $announcement)
    {
        if (!$announcement->is_active) {
            abort(404);
        }

        $announcement->load('host');
        
        return view('listings.show', compact('announcement'));
    }

    /**
     * Book an announcement.
     */
    public function bookAnnouncement(Request $request, HostingAnnouncement $announcement)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to make a booking.'
            ], 401);
        }

        if ($user->id === $announcement->host_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot book your own announcement.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests_count' => 'required|integer|min:1|max:' . $announcement->max_guests,
            'guest_message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check availability
        if (!$announcement->isAvailableForDates($request->check_in_date, $request->check_out_date)) {
            return response()->json([
                'success' => false,
                'message' => 'The selected dates are not available.'
            ], 400);
        }

        try {
            $checkIn = \Carbon\Carbon::parse($request->check_in_date);
            $checkOut = \Carbon\Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);
            $totalPrice = $nights * $announcement->price_per_night;

            $booking = Booking::create([
                'announcement_id' => $announcement->id,
                'guest_id' => $user->id,
                'host_id' => $announcement->host_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'guests_count' => $request->guests_count,
                'total_price' => $totalPrice,
                'guest_message' => $request->guest_message,
                'status' => 'pending',
            ]);

            Log::info('Booking created successfully', [
                'booking_id' => $booking->id,
                'guest_id' => $user->id,
                'host_id' => $announcement->host_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your booking request has been sent to the host!',
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create booking', [
                'user_id' => $user->id,
                'announcement_id' => $announcement->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Show booking details and chat.
     */
    public function showBooking(Booking $booking)
    {
        $user = Auth::user();

        if ($user->id !== $booking->guest_id && $user->id !== $booking->host_id) {
            abort(403);
        }

        $booking->load(['announcement', 'guest', 'host', 'messages.sender']);
        
        // Mark messages as read for current user
        $booking->messages()
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Respond to a booking (host only).
     */
    public function respondToBooking(Request $request, Booking $booking)
    {
        $user = Auth::user();

        if ($user->id !== $booking->host_id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'action' => 'required|in:confirm,cancel',
            'host_response' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $status = $request->action === 'confirm' ? 'confirmed' : 'cancelled';
            
            $booking->update([
                'status' => $status,
                'host_response' => $request->host_response,
                'confirmed_at' => $request->action === 'confirm' ? now() : null,
                'cancelled_at' => $request->action === 'cancel' ? now() : null,
            ]);

            $message = $request->action === 'confirm' 
                ? 'Booking confirmed successfully!' 
                : 'Booking cancelled.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to respond to booking', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Send a message in booking chat.
     */
    public function sendMessage(Request $request, Booking $booking)
    {
        $user = Auth::user();

        if ($user->id !== $booking->guest_id && $user->id !== $booking->host_id) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $receiverId = $user->id === $booking->guest_id ? $booking->host_id : $booking->guest_id;

            $message = Message::create([
                'booking_id' => $booking->id,
                'sender_id' => $user->id,
                'receiver_id' => $receiverId,
                'message' => $request->message,
            ]);

            $message->load('sender');

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send message', [
                'booking_id' => $booking->id,
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    /**
     * Store a new booking (general booking form)
     */
    public function storeBooking(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to make a booking.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'announcement_id' => 'required|exists:hosting_announcements,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests_count' => 'required|integer|min:1',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $announcement = HostingAnnouncement::findOrFail($request->announcement_id);

            if ($user->id === $announcement->host_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot book your own announcement.'
                ], 400);
            }

            if ($request->guests_count > $announcement->max_guests) {
                return response()->json([
                    'success' => false,
                    'message' => 'Number of guests exceeds the maximum allowed.'
                ], 400);
            }

            // Calculate total price
            $checkIn = Carbon::parse($request->check_in_date);
            $checkOut = Carbon::parse($request->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);
            $totalPrice = $nights * $announcement->price_per_night;

            // Create booking
            $booking = Booking::create([
                'guest_id' => $user->id,
                'host_id' => $announcement->host_id,
                'announcement_id' => $announcement->id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'guests_count' => $request->guests_count,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'guest_message' => $request->message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking request sent successfully! The host will review your request.',
                'booking_id' => $booking->id,
                'redirect' => route('bookings.show', $booking)
            ]);

        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'user_id' => $user->id,
                'announcement_id' => $request->announcement_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking. Please try again.'
            ], 500);
        }
    }

    /**
     * Send a direct message to a host
     */
    public function sendDirectMessage(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to send messages.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $receiver = User::findOrFail($request->receiver_id);

            if ($user->id === $receiver->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot send a message to yourself.'
                ], 400);
            }

            // Create message
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $receiver->id,
                'message' => $request->message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Message sending failed', [
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }
}
