<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PackageCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'sort_order',
        'status',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get travel packages for this category
     */
    public function travelPackages(): HasMany
    {
        return $this->hasMany(TravelPackage::class, 'category_id');
    }

    /**
     * Get active travel packages
     */
    public function activeTravelPackages(): HasMany
    {
        return $this->travelPackages()->where('status', 'active');
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for ordered categories
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Check if category has active packages
     */
    public function hasActivePackages(): bool
    {
        return $this->activeTravelPackages()->count() > 0;
    }

    /**
     * Get total packages count
     */
    public function getPackagesCountAttribute(): int
    {
        return $this->travelPackages()->count();
    }
}
