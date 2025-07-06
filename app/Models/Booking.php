<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'guest_id',
        'host_id',
        'check_in_date',
        'check_out_date',
        'guests_count',
        'total_price',
        'status',
        'guest_message',
        'host_response',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the announcement being booked.
     */
    public function announcement()
    {
        return $this->belongsTo(HostingAnnouncement::class, 'announcement_id');
    }

    /**
     * Get the guest who made the booking.
     */
    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    /**
     * Get the host of the booking.
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Get all messages for this booking.
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'booking_id');
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending Confirmation',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get the status color for UI.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'completed' => 'blue',
            default => 'gray'
        };
    }

    /**
     * Calculate the number of nights.
     */
    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    /**
     * Check if booking is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if booking is confirmed.
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if booking is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
