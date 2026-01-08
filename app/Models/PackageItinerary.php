<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PackageItinerary extends Model
{
    protected $fillable = [
        'travel_package_id',
        'day_number',
        'day_title',
    ];

    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'travel_package_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PackageItineraryItem::class, 'package_itinerary_id')->orderBy('order');
    }
}
