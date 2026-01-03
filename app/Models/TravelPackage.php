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
        'name',
        'slug',
        'category',
        'description',
        'location',
        'duration',
        'max_participants',
        'difficulty_level',
        'currency',
        'price',
        'child_price',
        'featured_image',
        'gallery_images',
        'status',
        'meta_title',
        'meta_description',
        'keywords',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'child_price' => 'decimal:2',
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
     * Get bookings for this package
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'package_id');
    }

    /**
     * Get itineraries for this package
     */
    public function itineraries(): HasMany
    {
        return $this->hasMany(PackageItinerary::class, 'travel_package_id')
            ->orderBy('day_number')
            ->orderBy('order');
    }

    /**
     * Get inclusions for this package
     */
    public function inclusions(): HasMany
    {
        return $this->hasMany(PackageInclusion::class, 'travel_package_id')
            ->orderBy('order');
    }

    /**
     * Get exclusions for this package
     */
    public function exclusions(): HasMany
    {
        return $this->hasMany(PackageExclusion::class, 'travel_package_id')
            ->orderBy('order');
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
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->currency === 'USD') {
            return '$' . number_format($this->price, 2, '.', ',');
        }
        return 'IDR ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted child price
     */
    public function getFormattedChildPriceAttribute(): string
    {
        if (!$this->child_price) return 'N/A';
        
        if ($this->currency === 'USD') {
            return '$' . number_format($this->child_price, 2, '.', ',');
        }
        return 'IDR ' . number_format($this->child_price, 0, ',', '.');
    }

    /**
     * Get duration string
     */
    public function getDurationStringAttribute(): string
    {
        return "{$this->duration} Days";
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : asset('images/package-placeholder.jpg');
    }

    /**
     * Calculate total price for booking
     */
    public function calculateTotalPrice(int $adults = 0, int $children = 0): float
    {
        $total = 0;
        $total += $adults * $this->price;
        $total += $children * ($this->child_price ?? $this->price);

        return $total;
    }

    /**
     * Scope for active packages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for searching packages
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('keywords', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope for price range
     */
    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
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
