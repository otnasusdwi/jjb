<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'affiliate')
            ->with(['bookings', 'commissions'])
            ->withCount(['bookings'])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('affiliate_code', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $affiliates = $query->paginate(20);

        // Calculate statistics
        $stats = [
            'total_affiliates' => User::where('role', 'affiliate')->count(),
            'active_affiliates' => User::where('role', 'affiliate')->where('status', 'active')->count(),
            'pending_affiliates' => User::where('role', 'affiliate')->where('status', 'pending')->count(),
            'total_commissions' => 'IDR ' . number_format(0, 0, ',', '.'), // You can calculate real commissions here
        ];

        return view('admin.affiliates.index', compact('affiliates', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.affiliates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'affiliate_code' => ['nullable', 'string', 'unique:users', 'max:20'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'bank_details' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:pending,active,inactive'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $affiliateData = $request->except(['password', 'password_confirmation', 'avatar', 'email_verified']);

        // Set role and password
        $affiliateData['role'] = 'affiliate';
        $affiliateData['password'] = Hash::make($request->password);

        // Generate affiliate code if not provided
        if (empty($affiliateData['affiliate_code'])) {
            $affiliateData['affiliate_code'] = $this->generateAffiliateCode();
        }

        // Handle email verification
        if ($request->has('email_verified')) {
            $affiliateData['email_verified_at'] = now();
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $affiliateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $affiliate = User::create($affiliateData);

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $affiliate)
    {
        // Load relationships
        $affiliate->load([
            'bookings' => function($query) {
                $query->latest()->limit(10);
            },
            'commissions' => function($query) {
                $query->latest()->limit(10);
            }
        ]);

        return view('admin.affiliates.show', compact('affiliate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $affiliate)
    {
        return view('admin.affiliates.edit', compact('affiliate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $affiliate)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $affiliate->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'affiliate_code' => ['nullable', 'string', 'unique:users,affiliate_code,' . $affiliate->id, 'max:20'],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'bank_details' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:pending,active,inactive,suspended'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $affiliateData = $request->except(['password', 'password_confirmation', 'avatar', 'email_verified']);

        // Update password if provided
        if ($request->filled('password')) {
            $affiliateData['password'] = Hash::make($request->password);
        }

        // Handle email verification
        if ($request->has('email_verified') && !$affiliate->email_verified_at) {
            $affiliateData['email_verified_at'] = now();
        } elseif (!$request->has('email_verified') && $affiliate->email_verified_at) {
            $affiliateData['email_verified_at'] = null;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($affiliate->avatar) {
                Storage::disk('public')->delete($affiliate->avatar);
            }
            $affiliateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $affiliate->update($affiliateData);

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $affiliate)
    {
        // Delete avatar if exists
        if ($affiliate->avatar) {
            Storage::disk('public')->delete($affiliate->avatar);
        }

        $affiliate->delete();

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate deleted successfully.');
    }

    /**
     * Approve affiliate
     */
    public function approve(User $affiliate)
    {
        $affiliate->update([
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()
            ->with('success', 'Affiliate approved successfully.');
    }

    /**
     * Suspend affiliate
     */
    public function suspend(User $affiliate)
    {
        $affiliate->update(['status' => 'suspended']);

        return redirect()->back()
            ->with('success', 'Affiliate suspended successfully.');
    }

    /**
     * Bulk action for affiliates
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'affiliate_ids' => 'required|string',
            'action' => 'required|in:approve,suspend,delete',
        ]);

        $affiliateIds = json_decode($request->affiliate_ids);
        $affiliates = User::whereIn('id', $affiliateIds)->where('role', 'affiliate')->get();

        switch ($request->action) {
            case 'approve':
                $affiliates->each(function($affiliate) {
                    $affiliate->update([
                        'status' => 'active',
                        'approved_at' => now(),
                        'approved_by' => auth()->id(),
                    ]);
                });
                $message = 'Affiliates approved successfully.';
                break;

            case 'suspend':
                $affiliates->each(function($affiliate) {
                    $affiliate->update(['status' => 'suspended']);
                });
                $message = 'Affiliates suspended successfully.';
                break;

            case 'delete':
                $affiliates->each(function($affiliate) {
                    if ($affiliate->avatar) {
                        Storage::disk('public')->delete($affiliate->avatar);
                    }
                    $affiliate->delete();
                });
                $message = 'Affiliates deleted successfully.';
                break;
        }

        return redirect()->route('admin.affiliates.index')
            ->with('success', $message);
    }

    /**
     * Send message to affiliate
     */
    public function sendMessage(Request $request, User $affiliate)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'send_email' => 'boolean',
        ]);

        // Here you can implement email sending logic
        // For now, just redirect back with success message

        return redirect()->back()
            ->with('success', 'Message sent to affiliate successfully.');
    }

    /**
     * Generate unique affiliate code
     */
    private function generateAffiliateCode(): string
    {
        do {
            $code = 'JJB' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
        } while (User::where('affiliate_code', $code)->exists());

        return $code;
    }
}
