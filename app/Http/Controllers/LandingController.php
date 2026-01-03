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
        $packages = TravelPackage::with(['category', 'tags'])
            ->where('status', 'active')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get destination tags for experience section
        $destinationTags = \App\Models\Tag::active()
            ->ofType('destination')
            ->ordered()
            ->get();

        return view('landing.index', compact('packages', 'destinationTags'));
    }

    public function showPackage($slug)
    {
        $package = TravelPackage::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('landing.package', compact('package'));
    }
}
