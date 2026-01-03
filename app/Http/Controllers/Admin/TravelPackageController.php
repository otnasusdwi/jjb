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
        $packages = TravelPackage::with(['category', 'tags'])
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('location', 'like', '%' . request('search') . '%');
            })
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
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
            'category_id' => 'required|exists:package_categories,id',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,moderate,challenging,difficult',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'highlights' => 'nullable|array',
            'includes' => 'nullable|array',
            'excludes' => 'nullable|array',
            'terms_conditions' => 'nullable|string',
            'departure_city' => 'required|string|max:255',
            'meeting_point' => 'required|string',
            'location' => 'required|string|max:255',
            'main_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'status' => 'required|in:draft,active,inactive,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $package = new TravelPackage();
        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->category_id = $request->category_id;
        $package->duration_days = $request->duration_days;
        $package->duration_nights = $request->duration_nights;
        $package->difficulty_level = $request->difficulty_level;
        $package->min_participants = $request->min_participants;
        $package->max_participants = $request->max_participants;
        $package->adult_price = $request->adult_price;
        $package->child_price = $request->child_price;
        $package->infant_price = $request->infant_price;
        $package->commission_rate = $request->commission_rate;
        $package->short_description = $request->short_description;
        $package->description = $request->description;
        $package->highlights = $request->highlights ? json_encode($request->highlights) : null;
        $package->includes = $request->includes ? json_encode($request->includes) : null;
        $package->excludes = $request->excludes ? json_encode($request->excludes) : null;
        $package->terms_conditions = $request->terms_conditions;
        $package->departure_city = $request->departure_city;
        $package->meeting_point = $request->meeting_point;
        $package->location = $request->location;
        $package->status = $request->status;

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $imagePath = $request->file('main_image')->store('packages', 'public');
            $package->main_image = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('packages/gallery', 'public');
            }
            $package->gallery = json_encode($galleryImages);
        }

        $package->save();

        // Sync tags
        if ($request->has('tags')) {
            $package->tags()->sync($request->tags);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Travel package created successfully!');
    }

    public function show(TravelPackage $package)
    {
        $package->load(['category', 'bookings.user', 'tags']);
        return view('admin.packages.show', compact('package'));
    }

    public function edit(TravelPackage $package)
    {
        $categories = PackageCategory::orderBy('name')->get();
        $tags = \App\Models\Tag::active()->ordered()->get()->groupBy('type');
        $package->load('tags');
        return view('admin.packages.edit', compact('package', 'categories', 'tags'));
    }

    public function update(Request $request, TravelPackage $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:package_categories,id',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'difficulty_level' => 'required|in:easy,moderate,challenging,difficult',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'adult_price' => 'required|numeric|min:0',
            'child_price' => 'nullable|numeric|min:0',
            'infant_price' => 'nullable|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'highlights' => 'nullable|array',
            'includes' => 'nullable|array',
            'excludes' => 'nullable|array',
            'terms_conditions' => 'nullable|string',
            'departure_city' => 'required|string|max:255',
            'meeting_point' => 'required|string',
            'location' => 'required|string|max:255',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'status' => 'required|in:draft,active,inactive,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $package->name = $request->name;
        $package->slug = Str::slug($request->name);
        $package->category_id = $request->category_id;
        $package->duration_days = $request->duration_days;
        $package->duration_nights = $request->duration_nights;
        $package->difficulty_level = $request->difficulty_level;
        $package->min_participants = $request->min_participants;
        $package->max_participants = $request->max_participants;
        $package->adult_price = $request->adult_price;
        $package->child_price = $request->child_price;
        $package->infant_price = $request->infant_price;
        $package->commission_rate = $request->commission_rate;
        $package->short_description = $request->short_description;
        $package->description = $request->description;
        $package->highlights = $request->highlights ? json_encode($request->highlights) : null;
        $package->includes = $request->includes ? json_encode($request->includes) : null;
        $package->excludes = $request->excludes ? json_encode($request->excludes) : null;
        $package->terms_conditions = $request->terms_conditions;
        $package->departure_city = $request->departure_city;
        $package->meeting_point = $request->meeting_point;
        $package->location = $request->location;
        $package->status = $request->status;

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($package->main_image) {
                Storage::disk('public')->delete($package->main_image);
            }
            $imagePath = $request->file('main_image')->store('packages', 'public');
            $package->main_image = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($package->gallery) {
                $oldGallery = json_decode($package->gallery, true);
                foreach ($oldGallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('packages/gallery', 'public');
            }
            $package->gallery = json_encode($galleryImages);
        }

        $package->save();

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
        if ($package->main_image) {
            Storage::disk('public')->delete($package->main_image);
        }
        if ($package->gallery) {
            $galleryImages = json_decode($package->gallery, true);
            foreach ($galleryImages as $image) {
                Storage::disk('public')->delete($image);
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
