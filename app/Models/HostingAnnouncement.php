<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'title',
        'description',
        'price_per_night',
        'currency',
        'room_type',
        'max_guests',
        'city',
        'address',
        'languages',
        'amenities',
        'house_rules',
        'images',
        'is_active',
        'available_from',
        'available_until',
        'special_notes',
    ];

    protected $casts = [
        'languages' => 'array',
        'amenities' => 'array',
        'house_rules' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
        'available_from' => 'date',
        'available_until' => 'date',
        'price_per_night' => 'decimal:2',
    ];

    /**
     * Get the host who created this announcement.
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Get all bookings for this announcement.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'announcement_id');
    }

    /**
     * Get the room type display name.
     */
    public function getRoomTypeDisplayAttribute()
    {
        return match($this->room_type) {
            'private_room' => 'Private Room',
            'shared_room' => 'Shared Room',
            'entire_place' => 'Entire Place',
            default => ucfirst(str_replace('_', ' ', $this->room_type))
        };
    }

    /**
     * Check if the announcement is available for given dates.
     */
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->is_active) {
            return false;
        }

        // Check if dates are within available range
        if ($this->available_from && $checkIn < $this->available_from) {
            return false;
        }

        if ($this->available_until && $checkOut > $this->available_until) {
            return false;
        }

        // Check for conflicting bookings
        $conflictingBookings = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($subQuery) use ($checkIn, $checkOut) {
                          $subQuery->where('check_in_date', '<=', $checkIn)
                                   ->where('check_out_date', '>=', $checkOut);
                      });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Get the first image for the announcement.
     */
    public function getFirstImageAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }
}
