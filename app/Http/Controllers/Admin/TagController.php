<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('type'), function ($query) {
                $query->where('type', request('type'));
            })
            ->orderBy('type')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if request was truncated (file size too large)
        if ($request->server('CONTENT_LENGTH') > (int) ini_get('post_max_size') * 1024 * 1024) {
            return back()->withInput()
                ->with('error', 'Upload failed: Total file size exceeds server limit. Please reduce file sizes or upload fewer images.');
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:tags,name',
                'type' => 'required|in:destination,activity,theme,duration',
                'color' => 'nullable|string|max:7',
                'description' => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gallery_images_data' => 'nullable|array',
                'gallery_images_data.*' => 'nullable|string',
                'gallery_captions.*' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        }

        $tag = Tag::create([
            'name' => $request->name,
            'type' => $request->type,
            'color' => $request->color ?? '#FF8C00',
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle gallery images for destination type only
        if ($request->type === 'destination') {
            $order = 0;
            $captions = $request->input('gallery_captions', []);
            $uploadedCount = 0;
            $failedFiles = [];

            // First process cropped base64 images
            if ($request->has('gallery_images_data') && is_array($request->gallery_images_data)) {
                foreach ($request->gallery_images_data as $index => $data) {
                    if (!$data) continue;
                    try {
                        $imagePath = $this->saveBase64Image($data, 'tags/gallery');
                        $tag->galleries()->create([
                            'image_path' => $imagePath,
                            'caption' => $captions[$index] ?? null,
                            'order' => $order++,
                        ]);
                        $uploadedCount++;
                    } catch (\Exception $e) {
                        \Log::error('Failed to save base64 gallery image: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            // Then process regular file uploads
            if ($request->hasFile('gallery_images')) {
                $files = $request->file('gallery_images');
                foreach ($files as $index => $file) {
                    if ($file && $file->isValid()) {
                        try {
                            if ($file->getSize() > 2048 * 1024) {
                                $failedFiles[] = $file->getClientOriginalName() . ' (exceeds 2MB)';
                                continue;
                            }
                            $imagePath = $file->store('tags/gallery', 'public');
                            $tag->galleries()->create([
                                'image_path' => $imagePath,
                                'caption' => $captions[$index] ?? null,
                                'order' => $order++,
                            ]);
                            $uploadedCount++;
                        } catch (\Exception $e) {
                            \Log::error('Failed to upload gallery image: ' . $e->getMessage());
                            $failedFiles[] = $file->getClientOriginalName();
                            continue;
                        }
                    }
                }
            }
            
            if ($uploadedCount > 0) {
                $message = "Tag created successfully with {$uploadedCount} gallery images!";
                if (count($failedFiles) > 0) {
                    $message .= " Failed to upload: " . implode(', ', $failedFiles);
                }
                return redirect()->route('admin.tags.index')
                    ->with('success', $message);
            } elseif (count($failedFiles) > 0) {
                return redirect()->route('admin.tags.index')
                    ->with('error', 'Tag created but gallery upload failed: ' . implode(', ', $failedFiles));
            }
        }

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $packages = $tag->packages()
            ->with('category')
            ->when(request('search'), function($query) {
                $query->where('title', 'like', '%' . request('search') . '%');
            })
            ->paginate(15);

        return view('admin.tags.show', compact('tag', 'packages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $tag->load('galleries');
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        // Check if request was truncated (file size too large)
        if ($request->server('CONTENT_LENGTH') > (int) ini_get('post_max_size') * 1024 * 1024) {
            return back()->withInput()
                ->with('error', 'Upload failed: Total file size exceeds server limit. Please reduce file sizes or upload fewer images.');
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
                'type' => 'required|in:destination,activity,theme,duration',
                'color' => 'nullable|string|max:7',
                'description' => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gallery_images_data' => 'nullable|array',
                'gallery_images_data.*' => 'nullable|string',
                'gallery_captions.*' => 'nullable|string|max:255',
                'existing_gallery_captions.*' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        }

        $tag->update([
            'name' => $request->name,
            'type' => $request->type,
            'color' => $request->color ?? '#FF8C00',
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        // Handle gallery caption updates for existing galleries
        if ($request->type === 'destination' && $request->has('existing_gallery_captions')) {
            foreach ($request->existing_gallery_captions as $galleryId => $caption) {
                $gallery = $tag->galleries()->find($galleryId);
                if ($gallery) {
                    $gallery->update(['caption' => $caption]);
                }
            }
        }

        // Handle gallery deletions for destination type
        if ($request->type === 'destination' && $request->has('delete_galleries') && is_array($request->delete_galleries)) {
            foreach ($request->delete_galleries as $galleryId) {
                $gallery = $tag->galleries()->find($galleryId);
                if ($gallery) {
                    Storage::disk('public')->delete($gallery->image_path);
                    $gallery->delete();
                }
            }
        }

        // Handle new gallery images for destination type only
        if ($request->type === 'destination') {
            $order = $tag->galleries()->count();
            $captions = $request->input('gallery_captions', []);
            $uploadedCount = 0;
            $failedFiles = [];

            if ($request->has('gallery_images_data') && is_array($request->gallery_images_data)) {
                foreach ($request->gallery_images_data as $index => $data) {
                    if (!$data) continue;
                    try {
                        $imagePath = $this->saveBase64Image($data, 'tags/gallery');
                        $tag->galleries()->create([
                            'image_path' => $imagePath,
                            'caption' => $captions[$index] ?? null,
                            'order' => $order++,
                        ]);
                        $uploadedCount++;
                    } catch (\Exception $e) {
                        \Log::error('Failed to save base64 gallery image: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            if ($request->hasFile('gallery_images')) {
                $files = $request->file('gallery_images');
                foreach ($files as $index => $file) {
                    if ($file && $file->isValid()) {
                        try {
                            if ($file->getSize() > 2048 * 1024) {
                                $failedFiles[] = $file->getClientOriginalName() . ' (exceeds 2MB)';
                                continue;
                            }
                            $imagePath = $file->store('tags/gallery', 'public');
                            $tag->galleries()->create([
                                'image_path' => $imagePath,
                                'caption' => $captions[$index] ?? null,
                                'order' => $order++,
                            ]);
                            $uploadedCount++;
                        } catch (\Exception $e) {
                            \Log::error('Failed to upload gallery image: ' . $e->getMessage());
                            $failedFiles[] = $file->getClientOriginalName();
                            continue;
                        }
                    }
                }
            }
            
            if ($uploadedCount > 0) {
                $message = "Tag updated successfully with {$uploadedCount} new gallery images!";
                if (count($failedFiles) > 0) {
                    $message .= " Failed to upload: " . implode(', ', $failedFiles);
                }
                return redirect()->route('admin.tags.index')
                    ->with('success', $message);
            } elseif (count($failedFiles) > 0) {
                return redirect()->route('admin.tags.index')
                    ->with('error', 'Tag updated but some gallery uploads failed: ' . implode(', ', $failedFiles));
            }
        }

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Check if tag is used by packages
        if ($tag->packages()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'Cannot delete tag that is assigned to packages. Please remove it from packages first.');
        }

        // Delete gallery images from storage
        foreach ($tag->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }

    /**
     * Toggle tag active status
     */
    public function toggleStatus(Tag $tag)
    {
        $tag->update(['is_active' => !$tag->is_active]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag status updated successfully!');
    }

    /**
     * Delete a gallery image via AJAX
     */
    public function deleteGallery(Tag $tag, $galleryId)
    {
        $gallery = $tag->galleries()->find($galleryId);
        
        if (!$gallery) {
            return response()->json(['success' => false, 'message' => 'Gallery not found'], 404);
        }

        // Delete file from storage
        Storage::disk('public')->delete($gallery->image_path);
        
        // Delete from database
        $gallery->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    private function saveBase64Image(string $data, string $directory, int $quality = 80): string
    {
        if (str_contains($data, ',')) {
            $data = explode(',', $data, 2)[1];
        }
        $binary = base64_decode($data);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($binary);
        $encoded = $image->encodeByExtension('jpg', quality: $quality);
        $filename = uniqid('tag_') . '.jpg';
        $path = trim($directory, '/') . '/' . $filename;
        Storage::disk('public')->put($path, (string) $encoded);
        return $path;
    }
}
