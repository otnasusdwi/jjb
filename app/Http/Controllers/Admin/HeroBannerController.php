<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HeroBannerController extends Controller
{
    /**
     * Display a listing of hero banners.
     */
    public function index()
    {
        $heroBanners = HeroBanner::orderBy('order')->paginate(10);
        return view('admin.hero-banners.index', compact('heroBanners'));
    }

    /**
     * Show the form for creating a new hero banner.
     */
    public function create()
    {
        return view('admin.hero-banners.create');
    }

    /**
     * Store a newly created hero banner in storage.
     */
    public function store(Request $request)
    {
        // Disable string max validation for base64 images as they can be large
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subtitle' => 'nullable|string|max:255',
            'image_data' => 'nullable|string|max:10000000',  // Allow up to 10MB base64
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->has('image_data') && !empty($request->image_data)) {
            $imagePath = $this->saveBase64Image($request->image_data, 'hero');
        } elseif ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hero', 'public');
        }

        if (!$imagePath) {
            return back()->withErrors(['image' => 'Please provide an image.']);
        }

        HeroBanner::create([
            'title' => $request->title,
            'description' => $request->description,
            'subtitle' => $request->subtitle,
            'image_path' => $imagePath,
            'order' => $request->order ?? HeroBanner::max('order') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner created successfully.');
    }

    /**
     * Display the specified hero banner.
     */
    public function show(HeroBanner $heroBanner)
    {
        return view('admin.hero-banners.show', compact('heroBanner'));
    }

    /**
     * Show the form for editing the specified hero banner.
     */
    public function edit(HeroBanner $heroBanner)
    {
        return view('admin.hero-banners.edit', compact('heroBanner'));
    }

    /**
     * Update the specified hero banner in storage.
     */
    public function update(Request $request, HeroBanner $heroBanner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subtitle' => 'nullable|string|max:255',
            'image_data' => 'nullable|string|max:10000000',  // Allow up to 10MB base64
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $heroBanner->title = $request->title;
        $heroBanner->description = $request->description;
        $heroBanner->subtitle = $request->subtitle;
        $heroBanner->order = $request->order ?? $heroBanner->order;
        $heroBanner->is_active = $request->has('is_active');

        // Handle image update
        if ($request->has('image_data') && !empty($request->image_data)) {
            // Delete old image
            if ($heroBanner->image_path) {
                Storage::disk('public')->delete($heroBanner->image_path);
            }
            $heroBanner->image_path = $this->saveBase64Image($request->image_data, 'hero');
        } elseif ($request->hasFile('image')) {
            // Delete old image
            if ($heroBanner->image_path) {
                Storage::disk('public')->delete($heroBanner->image_path);
            }
            $heroBanner->image_path = $request->file('image')->store('hero', 'public');
        }

        $heroBanner->save();

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner updated successfully.');
    }

    /**
     * Remove the specified hero banner from storage.
     */
    public function destroy(HeroBanner $heroBanner)
    {
        // Delete image from storage
        if ($heroBanner->image_path) {
            Storage::disk('public')->delete($heroBanner->image_path);
        }

        $heroBanner->delete();

        return redirect()->route('admin.hero-banners.index')
            ->with('success', 'Hero banner deleted successfully.');
    }

    /**
     * Save base64 image string to storage with compression (16:9 aspect ratio).
     */
    private function saveBase64Image(string $data, string $directory, int $quality = 70): string
    {
        if (str_contains($data, ',')) {
            $data = explode(',', $data, 2)[1];
        }
        $binary = base64_decode($data);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($binary);
        // Ensure 16:9 aspect ratio
        $image = $image->scale(width: 1920, height: 1080);
        $encoded = $image->encodeByExtension('jpg', quality: $quality);
        $filename = uniqid('hero_') . '.jpg';
        $path = trim($directory, '/') . '/' . $filename;
        Storage::disk('public')->put($path, (string) $encoded);
        return $path;
    }
}
