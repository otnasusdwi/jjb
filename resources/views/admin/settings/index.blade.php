@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="page-title mb-1">System Settings</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Settings</li>
            </ol>
        </div>
    </div>
</div>

<!-- Settings Navigation -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Settings Menu</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.settings.general') }}" class="list-group-item list-group-item-action">
                    <i class="ri-settings-line me-2"></i> General Settings
                </a>
                <a href="{{ route('admin.settings.payment') }}" class="list-group-item list-group-item-action">
                    <i class="ri-money-dollar-circle-line me-2"></i> Payment Settings
                </a>
                <a href="{{ route('admin.settings.email') }}" class="list-group-item list-group-item-action">
                    <i class="ri-mail-line me-2"></i> Email Settings
                </a>
                <a href="{{ route('admin.settings.notifications') }}" class="list-group-item list-group-item-action">
                    <i class="ri-notification-line me-2"></i> Notifications
                </a>
                <a href="{{ route('admin.settings.categories') }}" class="list-group-item list-group-item-action">
                    <i class="ri-folder-line me-2"></i> Package Categories
                </a>
                <a href="{{ route('admin.settings.backup') }}" class="list-group-item list-group-item-action">
                    <i class="ri-database-line me-2"></i> Backup & Restore
                </a>
                <a href="{{ route('admin.settings.system') }}" class="list-group-item list-group-item-action">
                    <i class="ri-computer-line me-2"></i> System Information
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <!-- Quick Settings Overview -->
        <div class="row">
            <!-- General Settings Card -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">General Settings</h5>
                                <p class="text-muted">Configure company information, commission rates, and basic system settings.</p>
                                <a href="{{ route('admin.settings.general') }}" class="btn btn-primary btn-sm">
                                    <i class="ri-settings-line me-1"></i> Configure
                                </a>
                            </div>
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-primary text-primary rounded">
                                    <i class="ri-settings-line" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Settings Card -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Payment Settings</h5>
                                <p class="text-muted">Manage payment methods, bank accounts, and commission payout settings.</p>
                                <a href="{{ route('admin.settings.payment') }}" class="btn btn-success btn-sm">
                                    <i class="ri-money-dollar-circle-line me-1"></i> Configure
                                </a>
                            </div>
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-success text-success rounded">
                                    <i class="ri-money-dollar-circle-line" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Settings Card -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Email Settings</h5>
                                <p class="text-muted">Configure SMTP settings, email templates, and automated notifications.</p>
                                <a href="{{ route('admin.settings.email') }}" class="btn btn-info btn-sm">
                                    <i class="ri-mail-line me-1"></i> Configure
                                </a>
                            </div>
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-info text-info rounded">
                                    <i class="ri-mail-line" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notification Settings Card -->
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Notifications</h5>
                                <p class="text-muted">Control notification preferences and automated alert settings.</p>
                                <a href="{{ route('admin.settings.notifications') }}" class="btn btn-warning btn-sm">
                                    <i class="ri-notification-line me-1"></i> Configure
                                </a>
                            </div>
                            <div class="avatar-sm">
                                <div class="avatar-title bg-soft-warning text-warning rounded">
                                    <i class="ri-notification-line" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">System Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Application Status</label>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">Online</span>
                                <span class="text-muted">All systems operational</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Database Connection</label>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">Connected</span>
                                <span class="text-muted">MySQL {{ config('database.default') }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Storage Link</label>
                            <div class="d-flex align-items-center">
                                @if(file_exists(public_path('storage')))
                                    <span class="badge bg-success me-2">Linked</span>
                                    <span class="text-muted">Storage accessible</span>
                                @else
                                    <span class="badge bg-danger me-2">Not Linked</span>
                                    <span class="text-muted">Run: php artisan storage:link</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Laravel Version</label>
                            <div class="text-muted">{{ app()->version() }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">PHP Version</label>
                            <div class="text-muted">{{ PHP_VERSION }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Environment</label>
                            <div class="d-flex align-items-center">
                                @if(config('app.env') === 'production')
                                    <span class="badge bg-danger me-2">Production</span>
                                @else
                                    <span class="badge bg-warning me-2">{{ ucfirst(config('app.env')) }}</span>
                                @endif
                                <span class="text-muted">{{ config('app.env') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('admin.settings.categories') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="ri-folder-line me-1"></i> Manage Categories
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.settings.backup') }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="ri-database-line me-1"></i> Create Backup
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.settings.system') }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="ri-computer-line me-1"></i> System Info
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
