<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp_code',
        'expires_at',
        'is_verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Check if the OTP is expired
     */
    public function isExpired()
    {
        return $this->expires_at < Carbon::now();
    }

    /**
     * Check if the OTP is valid
     */
    public function isValid($code)
    {
        return $this->otp_code === $code && !$this->isExpired() && !$this->is_verified;
    }

    /**
     * Mark as verified
     */
    public function markAsVerified()
    {
        $this->update(['is_verified' => true]);
    }
}