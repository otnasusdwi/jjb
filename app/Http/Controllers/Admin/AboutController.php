<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Str;

class AboutController extends Controller
{
    // About Page Methods
    public function index()
    {
        $aboutPage = AboutPage::firstOrCreate([], [
            'title' => 'About Us',
            'description' => '',
            'mission' => '',
            'vision' => '',
            'story' => '',
        ]);
        
        return view('admin.about.index', compact('aboutPage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'story' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'ceo_name' => 'nullable|string|max:255',
            'ceo_position' => 'nullable|string|max:255',
            'ceo_message' => 'nullable|string',
            'ceo_image' => 'nullable|string',
        ]);

        $aboutPage = AboutPage::firstOrFail();
        $data = $request->except(['hero_image', 'ceo_image']);

        if ($request->filled('hero_image')) {
            // Delete old image
            if ($aboutPage->hero_image) {
                Storage::disk('public')->delete($aboutPage->hero_image);
            }
            
            $imagePath = $this->saveBase64Image($request->hero_image, 'about', 85);
            $data['hero_image'] = $imagePath;
        }

        if ($request->filled('ceo_image')) {
            // Delete old CEO image
            if ($aboutPage->ceo_image) {
                Storage::disk('public')->delete($aboutPage->ceo_image);
            }
            
            $imagePath = $this->saveBase64Image($request->ceo_image, 'about', 90);
            $data['ceo_image'] = $imagePath;
        }

        $aboutPage->update($data);

        return redirect()->route('admin.about.index')
            ->with('success', 'About page updated successfully.');
    }

    // Team Members Methods
    public function teamIndex()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        return view('admin.about.team', compact('teamMembers'));
    }

    public function teamCreate()
    {
        return view('admin.about.team-create');
    }

    public function teamStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string',
            'image' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->filled('image')) {
            $imagePath = $this->saveBase64Image($request->image, 'team', 90);
            $data['image'] = $imagePath;
        }

        TeamMember::create($data);

        return redirect()->route('admin.about.team')
            ->with('success', 'Team member added successfully.');
    }

    public function teamEdit(TeamMember $teamMember)
    {
        return view('admin.about.team-edit', compact('teamMember'));
    }

    public function teamUpdate(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|string',
            'image' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = $request->except('image');

        if ($request->filled('image')) {
            // Delete old image
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            
            $imagePath = $this->saveBase64Image($request->image, 'team', 90);
            $data['image'] = $imagePath;
        }

        $teamMember->update($data);

        return redirect()->route('admin.about.team')
            ->with('success', 'Team member updated successfully.');
    }

    public function teamDestroy(TeamMember $teamMember)
    {
        // Delete image
        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }
        
        $teamMember->delete();

        return redirect()->route('admin.about.team')
            ->with('success', 'Team member deleted successfully.');
    }

    public function teamToggleStatus(TeamMember $teamMember)
    {
        $teamMember->is_active = !$teamMember->is_active;
        $teamMember->save();

        return response()->json(['success' => true]);
    }

    public function teamReorder(Request $request)
    {
        $order = $request->input('order');
        
        foreach ($order as $index => $id) {
            TeamMember::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    private function saveBase64Image(string $data, string $directory, int $quality = 90): string
    {
        if (str_contains($data, ',')) {
            $data = explode(',', $data, 2)[1];
        }
        $binary = base64_decode($data);
        $manager = new ImageManager(new Driver());
        $image = $manager->read($binary);
        $encoded = $image->encodeByExtension('jpg', quality: $quality);
        $filename = uniqid('about_') . '.jpg';
        $path = trim($directory, '/') . '/' . $filename;
        Storage::disk('public')->put($path, (string) $encoded);
        return $path;
    }
}
