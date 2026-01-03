<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'email',
        'password',
        'role',
        'status',
        'affiliate_code',
        'phone',
        'whatsapp',
        'address',
        'city',
        'country',
        'bio',
        'commission_rate',
        'bank_details',
        'avatar',
        'admin_notes',
        'approved_at',
        'approved_by',
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
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if ($user->role === 'affiliate' && empty($user->affiliate_code)) {
                $user->affiliate_code = static::generateAffiliateCode();
            }
        });
    }

    /**
     * Generate unique affiliate code
     */
    public static function generateAffiliateCode(): string
    {
        do {
            $code = 'JJB' . str_pad(rand(1, 9999), 3, '0', STR_PAD_LEFT);
        } while (static::where('affiliate_code', $code)->exists());

        return $code;
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Check if user is affiliate
     */
    public function isAffiliate(): bool
    {
        return $this->role === 'affiliate';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get the affiliate profile
     */
    public function affiliateProfile(): HasOne
    {
        return $this->hasOne(AffiliateProfile::class);
    }

    /**
     * Get bookings created by this user
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'affiliate_id');
    }

    /**
     * Get commissions for this affiliate
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class, 'affiliate_id');
    }

    /**
     * Get travel packages created by this user
     */
    public function travelPackages(): HasMany
    {
        return $this->hasMany(TravelPackage::class, 'created_by');
    }

    /**
     * Get landing page settings for affiliate
     */
    public function landingPageSettings(): HasOne
    {
        return $this->hasOne(LandingPageSetting::class, 'affiliate_id');
    }

    /**
     * Get the full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Scope to get only affiliates
     */
    public function scopeAffiliates($query)
    {
        return $query->where('role', 'affiliate');
    }

    /**
     * Scope to get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
