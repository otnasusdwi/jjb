<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItinerary extends Model
{
    protected $fillable = [
        'travel_package_id',
        'day_number',
        'title',
        'description',
        'order',
    ];

    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class, 'travel_package_id');
    }
}
