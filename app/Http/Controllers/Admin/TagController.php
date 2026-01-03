<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'type' => 'required|in:destination,activity,theme,duration',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Tag::create([
            'name' => $request->name,
            'type' => $request->type,
            'color' => $request->color ?? '#FF8C00',
            'icon' => $request->icon,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

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
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'type' => 'required|in:destination,activity,theme,duration',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:10',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $tag->update([
            'name' => $request->name,
            'type' => $request->type,
            'color' => $request->color ?? '#FF8C00',
            'icon' => $request->icon,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

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
}
