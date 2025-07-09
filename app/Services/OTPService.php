<?php

namespace App\Services;

use App\Models\EmailVerification;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OTPService
{
    /**
     * Generate and send OTP code
     */
    public function generateAndSendOTP($email)
    {
        // Generate 6-digit OTP
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete any existing OTP for this email
        EmailVerification::where('email', $email)->delete();
        
        // Create new OTP record
        $verification = EmailVerification::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10), // OTP expires in 10 minutes
            'is_verified' => false
        ]);
        
        // Send OTP email
        Mail::to($email)->send(new OTPMail($otpCode));
        
        return $verification;
    }
    
    /**
     * Verify OTP code
     */
    public function verifyOTP($email, $code)
    {
        $verification = EmailVerification::where('email', $email)
            ->where('is_verified', false)
            ->first();
        
        if (!$verification) {
            return false;
        }
        
        if ($verification->isValid($code)) {
            $verification->markAsVerified();
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if email has verified OTP
     */
    public function isEmailVerified($email)
    {
        return EmailVerification::where('email', $email)
            ->where('is_verified', true)
            ->exists();
    }
}