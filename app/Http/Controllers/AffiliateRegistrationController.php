<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AffiliateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AffiliateRegistrationController extends Controller
{
    /**
     * Show the affiliate registration form
     */
    public function create()
    {
        return view('auth.affiliate-register');
    }

    /**
     * Store a newly created affiliate registration
     */
    public function store(Request $request)
    {
        $request->validate([
            // Step 1: Personal Information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'birth_date' => ['required', 'date', 'before:today'],

            // Step 2: Documents
            'ktp_number' => ['required', 'string', 'max:20', 'unique:affiliate_profiles'],
            'ktp_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'npwp_number' => ['nullable', 'string', 'max:20'],
            'npwp_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],

            // Step 3: Banking Information
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder_name' => ['required', 'string', 'max:255'],
            'account_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],

            // Step 4: Additional
            'referral_code' => ['nullable', 'string', 'exists:affiliate_profiles,referral_code'],
            'terms' => ['required', 'accepted'],
        ]);

        try {
            DB::beginTransaction();

            // Generate temporary password from KTP number
            $password = substr($request->ktp_number, -8);

            // Create user account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'affiliate',
                'status' => 'pending',
                'affiliate_code' => User::generateAffiliateCode(),
            ]);

            // Handle file uploads
            $ktpPath = $this->uploadFile($request->file('ktp_file'), 'documents/ktp');
            $npwpPath = $request->hasFile('npwp_file')
                ? $this->uploadFile($request->file('npwp_file'), 'documents/npwp')
                : null;
            $accountPath = $this->uploadFile($request->file('account_file'), 'documents/account');

            // Create affiliate profile
            AffiliateProfile::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'whatsapp_number' => $request->whatsapp_number,
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'ktp_number' => $request->ktp_number,
                'ktp_file_path' => $ktpPath,
                'npwp_number' => $request->npwp_number,
                'npwp_file_path' => $npwpPath,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder_name' => $request->account_holder_name,
                'account_file_path' => $accountPath,
                'referral_code' => Str::random(8),
                'commission_rate' => 10.00, // Default commission rate
            ]);

            DB::commit();

            return redirect()->route('affiliate.register.success')
                ->with('success', 'Registration submitted successfully! Please wait for admin approval.')
                ->with('login_credentials', [
                    'email' => $user->email,
                    'password' => $password
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Show success page
     */
    public function success()
    {
        if (!session('success')) {
            return redirect()->route('affiliate.register');
        }

        return view('auth.affiliate-register-success');
    }

    /**
     * Upload file to storage
     */
    private function uploadFile($file, $path)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }
}
