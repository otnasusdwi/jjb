<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TravelPackageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\AffiliateRegistrationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/package/{slug}', [LandingController::class, 'showPackage'])->name('package.show');

// Redirect dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match($user->role) {
        'super_admin', 'admin' => redirect()->route('admin.dashboard'),
        'affiliate' => redirect()->route('affiliate.dashboard'),
        default => redirect()->route('home'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Affiliate Registration Routes
Route::prefix('register/affiliate')->group(function () {
    Route::get('/', [AffiliateRegistrationController::class, 'create'])->name('affiliate.register');
    Route::post('/', [AffiliateRegistrationController::class, 'store'])->name('affiliate.register.store');
    Route::get('/success', [AffiliateRegistrationController::class, 'success'])->name('affiliate.register.success');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin,super_admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Affiliate Management
    Route::prefix('affiliates')->name('affiliates.')->group(function () {
        Route::get('/', [AdminAffiliateController::class, 'index'])->name('index');
        Route::get('/pending', [AdminDashboardController::class, 'pendingAffiliates'])->name('pending');
        Route::get('/create', [AdminAffiliateController::class, 'create'])->name('create');
        Route::post('/', [AdminAffiliateController::class, 'store'])->name('store');
        Route::get('/{affiliate}', [AdminAffiliateController::class, 'show'])->name('show');
        Route::get('/{affiliate}/edit', [AdminAffiliateController::class, 'edit'])->name('edit');
        Route::put('/{affiliate}', [AdminAffiliateController::class, 'update'])->name('update');
        Route::delete('/{affiliate}', [AdminAffiliateController::class, 'destroy'])->name('destroy');
        Route::post('/{affiliate}/approve', [AdminAffiliateController::class, 'approve'])->name('approve');
        Route::post('/{affiliate}/suspend', [AdminAffiliateController::class, 'suspend'])->name('suspend');
        Route::post('/bulk-action', [AdminAffiliateController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/{affiliate}/message', [AdminAffiliateController::class, 'sendMessage'])->name('message');
    });

    // Travel Packages
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [TravelPackageController::class, 'index'])->name('index');
        Route::get('/create', [TravelPackageController::class, 'create'])->name('create');
        Route::post('/', [TravelPackageController::class, 'store'])->name('store');
        Route::get('/{package}', [TravelPackageController::class, 'show'])->name('show');
        Route::get('/{package}/edit', [TravelPackageController::class, 'edit'])->name('edit');
        Route::put('/{package}', [TravelPackageController::class, 'update'])->name('update');
        Route::delete('/{package}', [TravelPackageController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [TravelPackageController::class, 'bulkAction'])->name('bulk-action');
    });

    // Tags Management
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('/{tag}', [TagController::class, 'show'])->name('show');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('destroy');
        Route::post('/{tag}/toggle-status', [TagController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('index');
        Route::get('/pending', [AdminBookingController::class, 'pending'])->name('pending');
        Route::get('/{booking}', [AdminBookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [AdminBookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [AdminBookingController::class, 'update'])->name('update');
        Route::delete('/{booking}', [AdminBookingController::class, 'destroy'])->name('destroy');
        Route::post('/{booking}/approve', [AdminBookingController::class, 'approve'])->name('approve');
        Route::post('/{booking}/reject', [AdminBookingController::class, 'reject'])->name('reject');
        Route::get('/export/csv', [AdminBookingController::class, 'export'])->name('export');
        Route::post('/bulk-action', [AdminBookingController::class, 'bulkAction'])->name('bulk-action');
    });

    // Payments
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/pending', [AdminPaymentController::class, 'pending'])->name('pending');
        Route::get('/{payment}', [AdminPaymentController::class, 'show'])->name('show');
        Route::post('/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('verify');
        Route::post('/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('reject');
        Route::get('/{payment}/download-proof', [AdminPaymentController::class, 'downloadProof'])->name('download-proof');
        Route::post('/bulk-verify', [AdminPaymentController::class, 'bulkVerify'])->name('bulk-verify');
        Route::get('/export/csv', [AdminPaymentController::class, 'exportPayments'])->name('export');

        // Commission Management
        Route::get('/commissions', [AdminPaymentController::class, 'commissions'])->name('commissions.index');
        Route::get('/commissions/summary', [AdminPaymentController::class, 'commissionSummary'])->name('commissions.summary');
        Route::post('/commissions/payout', [AdminPaymentController::class, 'processCommissionPayout'])->name('commissions.payout');

        // Payment Reports
        Route::get('/report', [AdminPaymentController::class, 'paymentReport'])->name('report');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'dashboard'])->name('index');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('/affiliates', [ReportController::class, 'affiliatePerformance'])->name('affiliates');
        Route::get('/packages', [ReportController::class, 'packagePerformance'])->name('packages');
        Route::get('/customers', [ReportController::class, 'customerAnalytics'])->name('customers');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');

        // General Settings
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');

        // Payment Settings
        Route::get('/payment', [SettingsController::class, 'payment'])->name('payment');
        Route::post('/payment', [SettingsController::class, 'updatePayment'])->name('payment.update');

        // Email Settings
        Route::get('/email', [SettingsController::class, 'email'])->name('email');
        Route::post('/email', [SettingsController::class, 'updateEmail'])->name('email.update');

        // Notification Settings
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');

        // Category Management
        Route::get('/categories', [SettingsController::class, 'categories'])->name('categories');
        Route::post('/categories', [SettingsController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [SettingsController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [SettingsController::class, 'destroyCategory'])->name('categories.destroy');
        Route::post('/categories/reorder', [SettingsController::class, 'updateCategoryOrder'])->name('categories.reorder');

        // Backup & System
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup', [SettingsController::class, 'createBackup'])->name('backup.create');
        Route::get('/backup/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('backup.download');
        Route::delete('/backup/{filename}', [SettingsController::class, 'deleteBackup'])->name('backup.delete');
        Route::get('/system', [SettingsController::class, 'system'])->name('system');
    });
});

// Affiliate Routes
Route::prefix('affiliate')->middleware(['auth', 'role:affiliate'])->name('affiliate.')->group(function () {
    Route::get('/dashboard', [AffiliateDashboardController::class, 'index'])->name('dashboard');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
