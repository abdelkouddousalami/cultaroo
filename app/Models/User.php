<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'user_type',
        'role',
        'phone',
        'bio',
        'country',
        'city',
        'date_of_birth',
        'gender',
        'languages',
        'interests',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'languages' => 'array',
            'interests' => 'array',
            'is_verified' => 'boolean',
            'last_active_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's age.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the user's profile picture URL.
     */
    public function getProfilePictureUrlAttribute(): string
    {
        return $this->profile_picture 
            ? asset('storage/' . $this->profile_picture)
            : asset('images/default-avatar.png');
    }

    /**
     * Scope to filter by user type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('user_type', $type)->orWhere('user_type', 'both');
    }

    /**
     * Scope to get verified users only.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Get the user's host application.
     */
    public function hostApplication()
    {
        return $this->hasOne(HostApplication::class);
    }

    /**
     * Get hosting announcements created by this user.
     */
    public function hostingAnnouncements()
    {
        return $this->hasMany(HostingAnnouncement::class, 'host_id');
    }

    /**
     * Get bookings where this user is the guest.
     */
    public function guestBookings()
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    /**
     * Get bookings where this user is the host.
     */
    public function hostBookings()
    {
        return $this->hasMany(Booking::class, 'host_id');
    }

    /**
     * Get messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by this user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Check if user has submitted a host application.
     */
    public function hasHostApplication(): bool
    {
        return $this->hostApplication !== null;
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a host.
     */
    public function isHost(): bool
    {
        return $this->role === 'host';
    }

    /**
     * Check if user is a visitor.
     */
    public function isVisitor(): bool
    {
        return $this->role === 'visitor';
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get role display name.
     */
    public function getRoleDisplayAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'host' => 'Host Family',
            'visitor' => 'Visitor',
            default => 'Visitor'
        };
    }

    /**
     * Get role color for badges.
     */
    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'red',
            'host' => 'green',
            'visitor' => 'blue',
            default => 'gray'
        };
    }

    /**
     * Scope to filter by role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
