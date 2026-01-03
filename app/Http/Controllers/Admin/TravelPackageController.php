<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelPackage;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TravelPackageController extends Controller
{
    public function index()
    {
        $packages = TravelPackage::with('tags')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('location', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($query) {
                $query->where('category', request('category'));
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = PackageCategory::orderBy('name')->get();

        return view('admin.packages.index', compact('packages', 'categories'));
    }

    public function create()
    {
        $categories = PackageCategory::orderBy('name')->get();
        $tags = \App\Models\Tag::active()->ordered()->get()->groupBy('type');
        return view('admin.packages.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:30',
            'max_participants' => 'nullable|integer|min:1|max:100',
            'difficulty_level' => 'nullable|in:easy,moderate,challenging',
            'currency' => 'required|in:IDR,USD',
            'price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string|max:255',
            'exclusions' => 'nullable|array',
            'exclusions.*' => 'string|max:255',
            'status' => 'required|in:draft,active,inactive',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255',
        ]);

        $package = new TravelPackage();
        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->category = $request->category;
        $package->description = $request->description;
        $package->location = $request->location;
        $package->duration = $request->duration;
        $package->max_participants = $request->max_participants;
        $package->difficulty_level = $request->difficulty_level;
        $package->currency = $request->currency;
        $package->price = $request->price;
        $package->child_price = $request->child_price;
        $package->status = $request->status;
        
        // Handle SEO fields
        $package->meta_title = $request->meta_title;
        $package->meta_description = $request->meta_description;
        $package->keywords = $request->keywords;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('packages', 'public');
            $package->featured_image = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = $file->store('packages/gallery', 'public');
                }
            }
            $package->gallery_images = !empty($galleryImages) ? json_encode($galleryImages) : null;
        }

        $package->save();

        // Handle itinerary - save to package_itineraries table
        if ($request->has('itinerary') && is_array($request->itinerary)) {
            foreach ($request->itinerary as $dayNumber => $items) {
                if (is_array($items)) {
                    foreach ($items as $order => $item) {
                        if (!empty($item['title'])) {
                            $package->itineraries()->create([
                                'day_number' => $dayNumber,
                                'title' => $item['title'],
                                'description' => $item['description'] ?? '',
                                'order' => $order,
                            ]);
                        }
                    }
                }
            }
        }
        
        // Handle inclusions - save to package_inclusions table
        if ($request->has('inclusions') && is_array($request->inclusions)) {
            $order = 0;
            foreach ($request->inclusions as $description) {
                if (!empty(trim($description))) {
                    $package->inclusions()->create([
                        'description' => trim($description),
                        'order' => $order++,
                    ]);
                }
            }
        }
        
        // Handle exclusions - save to package_exclusions table
        if ($request->has('exclusions') && is_array($request->exclusions)) {
            $order = 0;
            foreach ($request->exclusions as $description) {
                if (!empty(trim($description))) {
                    $package->exclusions()->create([
                        'description' => trim($description),
                        'order' => $order++,
                    ]);
                }
            }
        }

        // Sync tags
        if ($request->has('tags')) {
            $package->tags()->sync($request->tags);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Travel package created successfully!');
    }

    public function show(TravelPackage $package)
    {
        $package->load(['bookings.user', 'tags']);
        return view('admin.packages.show', compact('package'));
    }

    public function edit(TravelPackage $package)
    {
        $categories = PackageCategory::orderBy('name')->get();
        $tags = \App\Models\Tag::active()->ordered()->get()->groupBy('type');
        $package->load(['tags', 'itineraries', 'inclusions', 'exclusions']);
        return view('admin.packages.edit', compact('package', 'categories', 'tags'));
    }

    public function update(Request $request, TravelPackage $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:30',
            'max_participants' => 'nullable|integer|min:1|max:100',
            'difficulty_level' => 'nullable|in:easy,moderate,challenging',
            'currency' => 'required|in:IDR,USD',
            'price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'string|max:255',
            'exclusions' => 'nullable|array',
            'exclusions.*' => 'string|max:255',
            'status' => 'required|in:draft,active,inactive',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'keywords' => 'nullable|string|max:255',
        ]);

        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->category = $request->category;
        $package->description = $request->description;
        $package->location = $request->location;
        $package->duration = $request->duration;
        $package->max_participants = $request->max_participants;
        $package->difficulty_level = $request->difficulty_level;
        $package->currency = $request->currency;
        $package->price = $request->price;
        $package->child_price = $request->child_price;
        $package->status = $request->status;
        
        // Handle SEO fields
        $package->meta_title = $request->meta_title;
        $package->meta_description = $request->meta_description;
        $package->keywords = $request->keywords;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($package->featured_image) {
                Storage::disk('public')->delete($package->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('packages', 'public');
            $package->featured_image = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($package->gallery_images) {
                $oldGallery = json_decode($package->gallery_images, true);
                if (is_array($oldGallery)) {
                    foreach ($oldGallery as $oldImage) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $galleryImages[] = $file->store('packages/gallery', 'public');
                }
            }
            $package->gallery_images = !empty($galleryImages) ? json_encode($galleryImages) : null;
        }

        $package->save();

        // Delete existing itineraries, inclusions, exclusions
        $package->itineraries()->delete();
        $package->inclusions()->delete();
        $package->exclusions()->delete();

        // Handle itinerary - save to package_itineraries table
        if ($request->has('itinerary') && is_array($request->itinerary)) {
            foreach ($request->itinerary as $dayNumber => $items) {
                if (is_array($items)) {
                    foreach ($items as $order => $item) {
                        if (!empty($item['title'])) {
                            $package->itineraries()->create([
                                'day_number' => $dayNumber,
                                'title' => $item['title'],
                                'description' => $item['description'] ?? '',
                                'order' => $order,
                            ]);
                        }
                    }
                }
            }
        }
        
        // Handle inclusions - save to package_inclusions table
        if ($request->has('inclusions') && is_array($request->inclusions)) {
            $order = 0;
            foreach ($request->inclusions as $description) {
                if (!empty(trim($description))) {
                    $package->inclusions()->create([
                        'description' => trim($description),
                        'order' => $order++,
                    ]);
                }
            }
        }
        
        // Handle exclusions - save to package_exclusions table
        if ($request->has('exclusions') && is_array($request->exclusions)) {
            $order = 0;
            foreach ($request->exclusions as $description) {
                if (!empty(trim($description))) {
                    $package->exclusions()->create([
                        'description' => trim($description),
                        'order' => $order++,
                    ]);
                }
            }
        }

        // Sync tags
        if ($request->has('tags')) {
            $package->tags()->sync($request->tags);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Travel package updated successfully!');
    }

    public function destroy(TravelPackage $package)
    {
        // Check if package has bookings
        if ($package->bookings()->count() > 0) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Cannot delete package that has bookings. Archive it instead.');
        }

        // Delete images
        if ($package->featured_image) {
            Storage::disk('public')->delete($package->featured_image);
        }
        if ($package->gallery_images) {
            $galleryImages = json_decode($package->gallery_images, true);
            if (is_array($galleryImages)) {
                foreach ($galleryImages as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Travel package deleted successfully!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,archive,delete',
            'selected_packages' => 'required|array|min:1',
            'selected_packages.*' => 'exists:travel_packages,id'
        ]);

        $packages = TravelPackage::whereIn('id', $request->selected_packages);

        switch ($request->action) {
            case 'activate':
                $packages->update(['status' => 'active']);
                $message = 'Selected packages activated successfully!';
                break;
            case 'deactivate':
                $packages->update(['status' => 'inactive']);
                $message = 'Selected packages deactivated successfully!';
                break;
            case 'archive':
                $packages->update(['status' => 'archived']);
                $message = 'Selected packages archived successfully!';
                break;
            case 'delete':
                // Check for bookings before deleting
                $packagesWithBookings = $packages->whereHas('bookings')->count();
                if ($packagesWithBookings > 0) {
                    return redirect()->route('admin.packages.index')
                        ->with('error', 'Cannot delete packages that have bookings.');
                }
                $packages->delete();
                $message = 'Selected packages deleted successfully!';
                break;
        }

        return redirect()->route('admin.packages.index')
            ->with('success', $message);
    }
}
