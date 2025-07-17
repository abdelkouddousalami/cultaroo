<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VerificationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Submit a verification request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|in:carte_nationale,passport',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        // Check if user already has a pending verification request
        $existingRequest = Auth::user()->verificationRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a verification request that is pending or approved.'
            ]);
        }

        // Store the uploaded document
        $documentPath = $request->file('document')->store('verification_documents', 'public');

        // Create verification request
        $verificationRequest = VerificationRequest::create([
            'user_id' => Auth::id(),
            'document_type' => $request->document_type,
            'document_path' => $documentPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Verification request submitted successfully. We will review it shortly.',
            'request_id' => $verificationRequest->id
        ]);
    }

    /**
     * Get user's verification status.
     */
    public function status()
    {
        $user = Auth::user();
        $latestRequest = $user->latestVerificationRequest;

        return response()->json([
            'has_request' => $user->hasVerificationRequest(),
            'is_verified' => $user->isIdentityVerified(),
            'latest_request' => $latestRequest ? [
                'id' => $latestRequest->id,
                'status' => $latestRequest->status,
                'document_type' => $latestRequest->document_type_display,
                'submitted_at' => $latestRequest->created_at->format('M d, Y'),
                'admin_notes' => $latestRequest->admin_notes,
            ] : null
        ]);
    }

    /**
     * Admin: Get all verification requests.
     */
    public function adminIndex()
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $requests = VerificationRequest::with(['user', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.verification-requests', compact('requests'));
    }

    /**
     * Admin: Update verification request status.
     */
    public function adminUpdate(Request $request, VerificationRequest $verificationRequest)
    {
        // Debug logging
        Log::info('VerificationController::adminUpdate called', [
            'request_data' => $request->all(),
            'verification_request_id' => $verificationRequest->id,
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role ?? 'none'
        ]);

        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            Log::warning('Unauthorized access attempt to verification update', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()->role ?? 'none'
            ]);
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $verificationRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Update user's verification status
        if ($request->status === 'approved') {
            $verificationRequest->user->update(['is_verified' => true]);
        } elseif ($request->status === 'rejected') {
            $verificationRequest->user->update(['is_verified' => false]);
        }

        Log::info('Verification request updated successfully', [
            'verification_request_id' => $verificationRequest->id,
            'new_status' => $request->status,
            'reviewed_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Verification request updated successfully.'
        ]);
    }
}
