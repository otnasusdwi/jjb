<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\PackageCategory;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get all active packages with tags for filtering
        $packages = TravelPackage::with('tags')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get destination tags with their galleries for experience section
        $destinationTags = \App\Models\Tag::active()
            ->ofType('destination')
            ->with(['galleries' => function($query) {
                $query->orderBy('order')->limit(3);
            }])
            ->ordered()
            ->get();

        return view('landing.index', compact('packages', 'destinationTags'));
    }

    public function showPackage($slug)
    {
        $package = TravelPackage::with(['tags', 'itineraries' => function($query) {
                $query->orderBy('day_number')->orderBy('order');
            }, 'inclusions', 'exclusions', 'galleries'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Group itineraries by day_number
        $groupedItineraries = $package->itineraries->groupBy('day_number');

        return view('landing.package', compact('package', 'groupedItineraries'));
    }
}
