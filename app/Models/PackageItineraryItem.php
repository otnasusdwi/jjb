<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItineraryItem extends Model
{
    protected $fillable = [
        'package_itinerary_id',
        'title',
        'order',
    ];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(PackageItinerary::class, 'package_itinerary_id');
    }
}
