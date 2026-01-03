<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'package_id',
        'affiliate_id',
        'booking_source',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_ktp_number',
        'participants_adult',
        'participants_child',
        'participants_infant',
        'travel_date',
        'return_date',
        'total_amount',
        'commission_amount',
        'booking_status',
        'payment_status',
        'payment_method',
        'payment_proof_path',
        'down_payment_amount',
        'down_payment_date',
        'full_payment_date',
        'special_requests',
        'affiliate_notes',
        'admin_notes',
        'cancellation_reason',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_date' => 'date',
        'down_payment_date' => 'date',
        'full_payment_date' => 'date',
        'approved_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'down_payment_amount' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = static::generateBookingCode();
            }
        });
    }

    /**
     * Generate unique booking code
     */
    public static function generateBookingCode(): string
    {
        $date = Carbon::now()->format('ymd');
        do {
            $code = 'JJB' . $date . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Get the travel package for this booking
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'package_id');
    }

    /**
     * Get the affiliate who created this booking
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get the user who created this booking
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved this booking
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get booking participants
     */
    public function participants(): HasMany
    {
        return $this->hasMany(BookingParticipant::class);
    }

    /**
     * Get booking payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(BookingPayment::class);
    }

    /**
     * Get payment records (for payment verification)
     */
    public function paymentRecords(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get commission records
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Get total participants count
     */
    public function getTotalParticipantsAttribute(): int
    {
        return $this->participants_adult + $this->participants_child + $this->participants_infant;
    }

    /**
     * Get remaining payment amount
     */
    public function getRemainingPaymentAttribute(): float
    {
        return $this->total_amount - $this->down_payment_amount;
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        return 'IDR ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get formatted commission amount
     */
    public function getFormattedCommissionAmountAttribute(): string
    {
        return 'IDR ' . number_format($this->commission_amount, 0, ',', '.');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->booking_status) {
            'draft' => 'badge-secondary',
            'pending' => 'badge-warning',
            'confirmed' => 'badge-info',
            'paid' => 'badge-success',
            'completed' => 'badge-success',
            'cancelled' => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    /**
     * Get payment status badge class
     */
    public function getPaymentStatusBadgeClassAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'badge-warning',
            'down_payment' => 'badge-info',
            'paid' => 'badge-success',
            'refunded' => 'badge-danger',
            default => 'badge-secondary',
        };
    }

    /**
     * Check if booking can be edited
     */
    public function canBeEdited(): bool
    {
        return in_array($this->booking_status, ['draft', 'pending']);
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return !in_array($this->booking_status, ['completed', 'cancelled']);
    }

    /**
     * Check if booking is overdue
     */
    public function isOverdue(): bool
    {
        return $this->travel_date < Carbon::today() && $this->booking_status !== 'completed';
    }

    /**
     * Scope for booking status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('booking_status', $status);
    }

    /**
     * Scope for payment status
     */
    public function scopePaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    /**
     * Scope for affiliate bookings
     */
    public function scopeForAffiliate($query, $affiliateId)
    {
        return $query->where('affiliate_id', $affiliateId);
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('travel_date', [$startDate, $endDate]);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('booking_code', 'LIKE', "%{$search}%")
              ->orWhere('customer_name', 'LIKE', "%{$search}%")
              ->orWhere('customer_email', 'LIKE', "%{$search}%")
              ->orWhere('customer_phone', 'LIKE', "%{$search}%");
        });
    }
}
