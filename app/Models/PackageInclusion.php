<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageInclusion extends Model
{
    protected $fillable = [
        'travel_package_id',
        'description',
        'order',
    ];

    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class, 'travel_package_id');
    }
}
