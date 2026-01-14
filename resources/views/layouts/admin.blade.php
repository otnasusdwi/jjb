<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'JJB Travel Bali') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- RemixIcon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar-menu .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 6px;
            margin: 2px 0;
        }
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .avatar-sm {
            height: 40px;
            width: 40px;
        }
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
        }
        .page-title-box {
            padding: 20px 0;
        }
        .badge-secondary { background-color: #6c757d; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #0dcaf0; color: #000; }
        .badge-success { background-color: #198754; }
        .badge-danger { background-color: #dc3545; }

        @media (max-width: 991.98px) {
            .main-content { margin-left: 0; }
            .sidebar { position: fixed; z-index: 1000; transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }

        .dropdown-item {
            color: #333;
        }

        .dropdown-item:hover,
        .dropdown-item.active {
            background-color: #e9ecef;
            color: #333;
        }

        .dropdown-divider {
            border-top: 1px solid #dee2e6;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar position-fixed" style="width: 250px;">
            <div class="p-4">
                <h4 class="text-white mb-4">
                    <i class="ri-plane-line me-2"></i>
                    JJB Travel Admin
                </h4>

                <ul class="nav flex-column sidebar-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="ri-dashboard-line me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.affiliates.*') ? 'active' : '' }}"
                           href="#" id="affiliatesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-group-line me-2"></i>
                            Affiliates
                            @if(\App\Models\User::affiliates()->where('status', 'pending')->count() > 0)
                                <span class="badge bg-warning ms-2">
                                    {{ \App\Models\User::affiliates()->where('status', 'pending')->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="affiliatesDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.affiliates.index') ? 'active' : '' }}"
                                   href="{{ route('admin.affiliates.index') }}">
                                    <i class="ri-team-line me-2"></i>All Affiliates
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.affiliates.pending') ? 'active' : '' }}"
                                   href="{{ route('admin.affiliates.pending') }}">
                                    <i class="ri-time-line me-2"></i>Pending Applications
                                    @if(\App\Models\User::affiliates()->where('status', 'pending')->count() > 0)
                                        <span class="badge bg-warning ms-2">
                                            {{ \App\Models\User::affiliates()->where('status', 'pending')->count() }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.affiliates.create') }}">
                                    <i class="ri-user-add-line me-2"></i>Add New Affiliate
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.packages.*', 'admin.tags.*', 'admin.hero-banners.*', 'admin.about.*') ? 'active' : '' }}"
                           href="#" id="landingPageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-global-line me-2"></i>
                            Landing Page
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="landingPageDropdown">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}"
                                   href="{{ route('admin.packages.index') }}">
                                    <i class="ri-gift-line me-2"></i>Packages
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}"
                                   href="{{ route('admin.tags.index') }}">
                                    <i class="ri-price-tag-3-line me-2"></i>Tags
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.hero-banners.*') ? 'active' : '' }}"
                                   href="{{ route('admin.hero-banners.index') }}">
                                    <i class="ri-slideshow-line me-2"></i>Hero Banners
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.about.index') ? 'active' : '' }}"
                                   href="{{ route('admin.about.index') }}">
                                    <i class="ri-file-text-line me-2"></i>About Page Content
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('admin.about.team.*') ? 'active' : '' }}"
                                   href="{{ route('admin.about.team.index') }}">
                                    <i class="ri-team-line me-2"></i>Team Members
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                           href="{{ route('admin.bookings.index') }}">
                            <i class="ri-calendar-line me-2"></i>
                            Bookings
                            @if(\App\Models\Booking::where('booking_status', 'pending')->count() > 0)
                                <span class="badge bg-warning ms-2">
                                    {{ \App\Models\Booking::where('booking_status', 'pending')->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
                           href="{{ route('admin.payments.index') }}">
                            <i class="ri-money-dollar-circle-line me-2"></i>
                            Payments
                            @if(\App\Models\Payment::where('status', 'pending')->count() > 0)
                                <span class="badge bg-info ms-2">
                                    {{ \App\Models\Payment::where('status', 'pending')->count() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                           href="{{ route('admin.reports.index') }}">
                            <i class="ri-bar-chart-line me-2"></i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                           href="{{ route('admin.settings.index') }}">
                            <i class="ri-settings-line me-2"></i>
                            Settings
                        </a>
                    </li> -->
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content flex-grow-1">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-outline-primary d-lg-none me-2" type="button" onclick="toggleSidebar()">
                        <i class="ri-menu-line"></i>
                    </button>

                    <div class="navbar-nav ms-auto">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="avatar-sm me-2">
                                    <span class="avatar-title bg-primary text-white rounded-circle">
                                        {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : 'G' }}
                                    </span>
                                </span>
                                {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
