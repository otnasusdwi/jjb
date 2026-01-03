<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AffiliateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'whatsapp_number',
        'address',
        'birth_date',
        'ktp_number',
        'ktp_file_path',
        'npwp_number',
        'npwp_file_path',
        'bank_name',
        'account_number',
        'account_holder_name',
        'account_file_path',
        'commission_rate',
        'referral_code',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'commission_rate' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->referral_code)) {
                $profile->referral_code = static::generateReferralCode();
            }
        });
    }

    /**
     * Generate unique referral code
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = 'REF' . Str::random(6);
        } while (static::where('referral_code', $code)->exists());

        return strtoupper($code);
    }

    /**
     * Get the user that owns this profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved this profile
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if profile is approved
     */
    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    /**
     * Check if profile has KTP document
     */
    public function hasKtp(): bool
    {
        return !empty($this->ktp_file_path);
    }

    /**
     * Check if profile has NPWP document
     */
    public function hasNpwp(): bool
    {
        return !empty($this->npwp_file_path);
    }

    /**
     * Check if profile has bank account document
     */
    public function hasBankAccount(): bool
    {
        return !empty($this->account_file_path);
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentage(): int
    {
        $fields = [
            'phone', 'whatsapp_number', 'address', 'birth_date', 'ktp_number',
            'ktp_file_path', 'bank_name', 'account_number', 'account_holder_name'
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        return round(($completed / count($fields)) * 100);
    }

    /**
     * Scope for approved profiles
     */
    public function scopeApproved($query)
    {
        return $query->whereNotNull('approved_at');
    }

    /**
     * Scope for pending profiles
     */
    public function scopePending($query)
    {
        return $query->whereNull('approved_at')->whereNull('rejection_reason');
    }

    /**
     * Scope for rejected profiles
     */
    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejection_reason');
    }
}
