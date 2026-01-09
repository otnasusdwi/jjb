<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\PackageCategory;
use App\Models\HeroBanner;
use App\Models\AboutPage;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get active hero banners ordered by display order
        $heroBanners = HeroBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

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

        return view('landing.index', compact('heroBanners', 'packages', 'destinationTags'));
    }

    public function showPackage($slug)
    {
        $package = TravelPackage::with(['tags', 'itineraries.items', 'inclusions', 'exclusions', 'galleries'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('landing.package', compact('package'));
    }

    public function about()
    {
        $aboutPage = AboutPage::first();
        $teamMembers = TeamMember::where('is_active', true)->orderBy('order')->get();

        return view('landing.about', compact('aboutPage', 'teamMembers'));
    }
}
