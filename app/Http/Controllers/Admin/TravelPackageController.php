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
            'duration_days' => 'required|integer|min:1|max:30',
            'duration_nights' => 'nullable|integer|min:0|max:30',
            'max_participants' => 'nullable|integer|min:1|max:100',
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
        $package->duration_days = $request->duration_days;
        $package->duration_nights = $request->duration_nights;
        $package->max_participants = $request->max_participants;
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
            $order = 0;
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $imagePath = $file->store('packages/gallery', 'public');
                    $package->galleries()->create([
                        'image_path' => $imagePath,
                        'order' => $order++,
                    ]);
                }
            }
        }

        $package->save();

        // Handle itinerary - save to package_itineraries table (parent-child structure)
        if ($request->has('itinerary') && is_array($request->itinerary)) {
            foreach ($request->itinerary as $dayNumber => $dayData) {
                $dayTitle = isset($dayData['day_title']) ? $dayData['day_title'] : null;
                
                // Create parent day itinerary
                $dayItinerary = $package->itineraries()->create([
                    'day_number' => $dayNumber,
                    'day_title' => $dayTitle,
                ]);
                
                // Create child items for this day
                if (isset($dayData['items']) && is_array($dayData['items'])) {
                    foreach ($dayData['items'] as $order => $item) {
                        if (!empty($item['title'])) {
                            $dayItinerary->items()->create([
                                'title' => $item['title'],
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
        // Eager-load itinerary parents with their items for display
        $package->load(['bookings.user', 'tags', 'itineraries.items']);
        return view('admin.packages.show', compact('package'));
    }

    public function edit(TravelPackage $package)
    {
        $categories = PackageCategory::orderBy('name')->get();
        $tags = \App\Models\Tag::active()->ordered()->get()->groupBy('type');
        $package->load(['tags', 'itineraries', 'inclusions', 'exclusions', 'galleries']);
        return view('admin.packages.edit', compact('package', 'categories', 'tags'));
    }

    public function update(Request $request, TravelPackage $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1|max:30',
            'duration_nights' => 'nullable|integer|min:0|max:30',
            'max_participants' => 'nullable|integer|min:1|max:100',
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
        $package->duration_days = $request->duration_days;
        $package->duration_nights = $request->duration_nights;
        $package->max_participants = $request->max_participants;
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

        // Handle gallery image deletions
        if ($request->has('delete_galleries') && is_array($request->delete_galleries)) {
            foreach ($request->delete_galleries as $galleryId) {
                $gallery = $package->galleries()->find($galleryId);
                if ($gallery) {
                    Storage::disk('public')->delete($gallery->image_path);
                    $gallery->delete();
                }
            }
        }

        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            $order = $package->galleries()->count(); // Continue from existing count
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $imagePath = $file->store('packages/gallery', 'public');
                    $package->galleries()->create([
                        'image_path' => $imagePath,
                        'order' => $order++,
                    ]);
                }
            }
        }

        $package->save();

        // Delete existing itineraries, inclusions, exclusions
        $package->itineraries()->delete();
        $package->inclusions()->delete();
        $package->exclusions()->delete();

        // Handle itinerary - save to package_itineraries table (parent-child structure)
        if ($request->has('itinerary') && is_array($request->itinerary)) {
            foreach ($request->itinerary as $dayNumber => $dayData) {
                $dayTitle = isset($dayData['day_title']) ? $dayData['day_title'] : null;
                
                // Create parent day itinerary
                $dayItinerary = $package->itineraries()->create([
                    'day_number' => $dayNumber,
                    'day_title' => $dayTitle,
                ]);
                
                // Create child items for this day
                if (isset($dayData['items']) && is_array($dayData['items'])) {
                    foreach ($dayData['items'] as $order => $item) {
                        if (!empty($item['title'])) {
                            $dayItinerary->items()->create([
                                'title' => $item['title'],
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

        // Delete gallery images from storage
        foreach ($package->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Travel package deleted successfully.');
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
