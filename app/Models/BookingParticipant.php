<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'participant_type',
        'full_name',
        'age',
        'gender',
        'special_needs',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    /**
     * Get the booking for this participant
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get formatted age with type
     */
    public function getFormattedAgeAttribute(): string
    {
        return "{$this->age} years ({$this->participant_type})";
    }

    /**
     * Scope for participant type
     */
    public function scopeType($query, $type)
    {
        return $query->where('participant_type', $type);
    }
}
