<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageCategory;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function general()
    {
        $settings = SystemSetting::whereIn('key', [
            'company_name', 'company_address', 'company_phone', 'company_email',
            'company_website', 'company_logo', 'default_commission_rate',
            'minimum_payout_amount', 'payout_schedule', 'currency'
        ])->get()->keyBy('key');

        return view('admin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'company_phone' => 'required|string|max:20',
            'company_email' => 'required|email|max:255',
            'company_website' => 'nullable|url|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'default_commission_rate' => 'required|numeric|min:0|max:100',
            'minimum_payout_amount' => 'required|numeric|min:0',
            'payout_schedule' => 'required|in:weekly,biweekly,monthly',
            'currency' => 'required|string|max:10'
        ]);

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            $oldLogo = SystemSetting::where('key', 'company_logo')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }

            $logoPath = $request->file('company_logo')->store('settings', 'public');
            $this->updateSetting('company_logo', $logoPath);
        }

        // Update other settings
        $this->updateSetting('company_name', $request->company_name);
        $this->updateSetting('company_address', $request->company_address);
        $this->updateSetting('company_phone', $request->company_phone);
        $this->updateSetting('company_email', $request->company_email);
        $this->updateSetting('company_website', $request->company_website);
        $this->updateSetting('default_commission_rate', $request->default_commission_rate);
        $this->updateSetting('minimum_payout_amount', $request->minimum_payout_amount);
        $this->updateSetting('payout_schedule', $request->payout_schedule);
        $this->updateSetting('currency', $request->currency);

        // Clear cache
        Cache::forget('system_settings');

        return redirect()->route('admin.settings.general')
            ->with('success', 'General settings updated successfully!');
    }

    public function payment()
    {
        $settings = SystemSetting::whereIn('key', [
            'bank_accounts', 'payment_methods', 'payment_gateway_config',
            'auto_payment_verification', 'payment_notification_email'
        ])->get()->keyBy('key');

        return view('admin.settings.payment', compact('settings'));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'bank_accounts' => 'required|array|min:1',
            'bank_accounts.*.bank_name' => 'required|string|max:100',
            'bank_accounts.*.account_number' => 'required|string|max:50',
            'bank_accounts.*.account_name' => 'required|string|max:255',
            'payment_methods' => 'required|array|min:1',
            'payment_methods.*' => 'in:bank_transfer,credit_card,e_wallet,cash',
            'auto_payment_verification' => 'required|boolean',
            'payment_notification_email' => 'required|email'
        ]);

        $this->updateSetting('bank_accounts', json_encode($request->bank_accounts));
        $this->updateSetting('payment_methods', json_encode($request->payment_methods));
        $this->updateSetting('auto_payment_verification', $request->auto_payment_verification);
        $this->updateSetting('payment_notification_email', $request->payment_notification_email);

        Cache::forget('system_settings');

        return redirect()->route('admin.settings.payment')
            ->with('success', 'Payment settings updated successfully!');
    }

    public function email()
    {
        $settings = SystemSetting::whereIn('key', [
            'mail_driver', 'mail_host', 'mail_port', 'mail_username',
            'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
        ])->get()->keyBy('key');

        return view('admin.settings.email', compact('settings'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|in:smtp,sendmail,mailgun,ses',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255'
        ]);

        $this->updateSetting('mail_driver', $request->mail_driver);
        $this->updateSetting('mail_host', $request->mail_host);
        $this->updateSetting('mail_port', $request->mail_port);
        $this->updateSetting('mail_username', $request->mail_username);

        // Only update password if provided
        if ($request->filled('mail_password')) {
            $this->updateSetting('mail_password', encrypt($request->mail_password));
        }

        $this->updateSetting('mail_encryption', $request->mail_encryption);
        $this->updateSetting('mail_from_address', $request->mail_from_address);
        $this->updateSetting('mail_from_name', $request->mail_from_name);

        Cache::forget('system_settings');

        return redirect()->route('admin.settings.email')
            ->with('success', 'Email settings updated successfully!');
    }

    public function notifications()
    {
        $settings = SystemSetting::whereIn('key', [
            'email_notifications', 'sms_notifications', 'push_notifications',
            'notification_events', 'admin_notification_emails'
        ])->get()->keyBy('key');

        return view('admin.settings.notifications', compact('settings'));
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'email_notifications' => 'required|boolean',
            'sms_notifications' => 'required|boolean',
            'push_notifications' => 'required|boolean',
            'notification_events' => 'required|array|min:1',
            'notification_events.*' => 'in:booking_created,booking_confirmed,payment_received,commission_earned,affiliate_registered',
            'admin_notification_emails' => 'required|array|min:1',
            'admin_notification_emails.*' => 'email'
        ]);

        $this->updateSetting('email_notifications', $request->email_notifications);
        $this->updateSetting('sms_notifications', $request->sms_notifications);
        $this->updateSetting('push_notifications', $request->push_notifications);
        $this->updateSetting('notification_events', json_encode($request->notification_events));
        $this->updateSetting('admin_notification_emails', json_encode($request->admin_notification_emails));

        Cache::forget('system_settings');

        return redirect()->route('admin.settings.notifications')
            ->with('success', 'Notification settings updated successfully!');
    }

    public function categories()
    {
        $categories = PackageCategory::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.settings.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'is_active' => 'required|boolean'
        ]);

        PackageCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->is_active,
            'sort_order' => PackageCategory::max('sort_order') + 1
        ]);

        return redirect()->route('admin.settings.categories')
            ->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, PackageCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:package_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'is_active' => 'required|boolean'
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('admin.settings.categories')
            ->with('success', 'Category updated successfully!');
    }

    public function destroyCategory(PackageCategory $category)
    {
        // Check if category has packages
        if ($category->travelPackages()->count() > 0) {
            return redirect()->route('admin.settings.categories')
                ->with('error', 'Cannot delete category that has packages assigned to it.');
        }

        $category->delete();

        return redirect()->route('admin.settings.categories')
            ->with('success', 'Category deleted successfully!');
    }

    public function updateCategoryOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:package_categories,id'
        ]);

        foreach ($request->categories as $index => $categoryId) {
            PackageCategory::where('id', $categoryId)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function backup()
    {
        $backups = $this->getBackupFiles();
        return view('admin.settings.backup', compact('backups'));
    }

    public function createBackup(Request $request)
    {
        $request->validate([
            'include_uploads' => 'boolean'
        ]);

        try {
            // This is a simplified backup - in production you'd use a proper backup package
            $timestamp = date('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.sql";

            // Here you would implement actual database backup logic
            // For now, just create a placeholder
            Storage::disk('local')->put("backups/{$filename}", "-- Database backup created at " . now());

            return redirect()->route('admin.settings.backup')
                ->with('success', 'Backup created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.backup')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function downloadBackup($filename)
    {
        if (!Storage::disk('local')->exists("backups/{$filename}")) {
            abort(404, 'Backup file not found');
        }

        return Storage::disk('local')->download("backups/{$filename}");
    }

    public function deleteBackup($filename)
    {
        if (!Storage::disk('local')->exists("backups/{$filename}")) {
            return redirect()->route('admin.settings.backup')
                ->with('error', 'Backup file not found');
        }

        Storage::disk('local')->delete("backups/{$filename}");

        return redirect()->route('admin.settings.backup')
            ->with('success', 'Backup deleted successfully!');
    }

    public function system()
    {
        $systemInfo = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'queue_driver' => config('queue.default'),
            'mail_driver' => config('mail.default'),
            'timezone' => config('app.timezone'),
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug'),
            'storage_link' => file_exists(public_path('storage')),
        ];

        return view('admin.settings.system', compact('systemInfo'));
    }

    private function updateSetting($key, $value)
    {
        SystemSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    private function getBackupFiles()
    {
        $files = Storage::disk('local')->files('backups');
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => Storage::disk('local')->size($file),
                'modified' => Storage::disk('local')->lastModified($file)
            ];
        }

        return collect($backups)->sortByDesc('modified');
    }
}
