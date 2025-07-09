<?php

use Illuminate\Support\Facades\Route;
use App\Services\OTPService;

Route::get('/test-email', function () {
    try {
        $otpService = new OTPService();
        $verification = $otpService->generateAndSendOTP('abdoalami.ru@gmail.com');
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent successfully!',
            'otp_code' => $verification->otp_code, // Only for testing
            'expires_at' => $verification->expires_at
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to send email: ' . $e->getMessage()
        ]);
    }
});
