<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TravelPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'full_description',
        'highlights',
        'includes',
        'excludes',
        'terms_conditions',
        'duration_days',
        'duration_nights',
        'price_adult',
        'price_child',
        'price_infant',
        'min_participants',
        'max_participants',
        'difficulty_level',
        'departure_city',
        'meeting_point',
        'transportation_details',
        'accommodation_details',
        'main_image_path',
        'gallery_images',
        'video_url',
        'virtual_tour_url',
        'commission_rate',
        'is_featured',
        'status',
        'seo_title',
        'seo_description',
        'keywords',
        'created_by',
    ];

    protected $casts = [
        'highlights' => 'array',
        'includes' => 'array',
        'excludes' => 'array',
        'gallery_images' => 'array',
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
        'price_infant' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name);
            }
        });

        static::updating(function ($package) {
            if ($package->isDirty('name') && empty($package->slug)) {
                $package->slug = Str::slug($package->name);
            }
        });
    }

    /**
     * Get the category for this package
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PackageCategory::class, 'category_id');
    }

    /**
     * Get the user who created this package
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get bookings for this package
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'package_id');
    }

    /**
     * Get all tags for this package
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'package_tag', 'travel_package_id', 'tag_id')
            ->withTimestamps();
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get formatted price for adults
     */
    public function getFormattedPriceAdultAttribute(): string
    {
        return 'IDR ' . number_format($this->price_adult, 0, ',', '.');
    }

    /**
     * Get formatted price for children
     */
    public function getFormattedPriceChildAttribute(): string
    {
        return $this->price_child ? 'IDR ' . number_format($this->price_child, 0, ',', '.') : 'N/A';
    }

    /**
     * Get formatted price for infants
     */
    public function getFormattedPriceInfantAttribute(): string
    {
        return $this->price_infant ? 'IDR ' . number_format($this->price_infant, 0, ',', '.') : 'N/A';
    }

    /**
     * Get duration string
     */
    public function getDurationStringAttribute(): string
    {
        return "{$this->duration_days} Days {$this->duration_nights} Nights";
    }

    /**
     * Get main image URL
     */
    public function getMainImageUrlAttribute(): string
    {
        return $this->main_image_path ? asset('storage/' . $this->main_image_path) : asset('images/package-placeholder.jpg');
    }

    /**
     * Calculate total price for booking
     */
    public function calculateTotalPrice(int $adults = 0, int $children = 0, int $infants = 0): float
    {
        $total = 0;
        $total += $adults * $this->price_adult;
        $total += $children * ($this->price_child ?? 0);
        $total += $infants * ($this->price_infant ?? 0);

        return $total;
    }

    /**
     * Calculate commission amount
     */
    public function calculateCommission(float $totalPrice): float
    {
        return $totalPrice * ($this->commission_rate / 100);
    }

    /**
     * Scope for active packages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for featured packages
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for searching packages
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('short_description', 'LIKE', "%{$search}%")
              ->orWhere('keywords', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope for price range
     */
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price_adult', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price_adult', '<=', $maxPrice);
        }

        return $query;
    }

    /**
     * Scope for difficulty level
     */
    public function scopeDifficulty($query, $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    /**
     * Check if package is available for booking
     */
    public function isAvailable(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get total bookings count
     */
    public function getTotalBookingsAttribute(): int
    {
        return $this->bookings()->count();
    }

    /**
     * Get confirmed bookings count
     */
    public function getConfirmedBookingsAttribute(): int
    {
        return $this->bookings()->where('booking_status', 'confirmed')->count();
    }
}
