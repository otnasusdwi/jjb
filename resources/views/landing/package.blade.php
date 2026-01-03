<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $package->name }} - JJB Travel Services</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-orange: #FF8C00;
            --dark-orange: #E67E00;
            --text-dark: #2C2C2C;
            --text-light: #666;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-orange) !important;
        }
        
        .package-header {
            background: linear-gradient(135deg, #FFF4E6 0%, #FFE5CC 100%);
            padding: 80px 0 40px;
        }
        
        .package-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .package-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        .package-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
        }
        
        .price-box {
            background: var(--primary-orange);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            position: sticky;
            top: 100px;
        }
        
        .price-box h3 {
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
        
        .btn-book {
            background: white;
            color: var(--primary-orange);
            font-weight: 700;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
        }
        
        .btn-book:hover {
            background: #f8f9fa;
        }
        
        .highlight-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .highlight-item:last-child {
            border-bottom: none;
        }
        
        footer {
            background: #2C2C2C;
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <strong>JJB</strong> Travel Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#packages">All Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Package Header -->
    <section class="package-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="package-title">{{ $package->name }}</h1>
                    <div class="package-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            {{ $package->duration_days }} Days @if($package->duration_nights > 0) / {{ $package->duration_nights }} Nights @endif
                        </div>
                        @if($package->category)
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                            </svg>
                            {{ $package->category->name }}
                        </div>
                        @endif
                    </div>
                    <p class="lead">{{ $package->short_description }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Package Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if($package->main_image_path)
                    <img src="{{ asset('storage/' . $package->main_image_path) }}" alt="{{ $package->name }}" class="package-image mb-5">
                    @endif
                    
                    <!-- Description -->
                    <div class="mb-5">
                        <h2 class="section-title">About This Tour</h2>
                        <div>{!! nl2br(e($package->full_description)) !!}</div>
                    </div>

                    <!-- Highlights -->
                    @if($package->highlights)
                    <div class="mb-5">
                        <h2 class="section-title">Tour Highlights</h2>
                        <div class="bg-light p-4 rounded">
                            @foreach(json_decode($package->highlights) as $highlight)
                            <div class="highlight-item">
                                ✓ {{ $highlight }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Includes -->
                    @if($package->includes)
                    <div class="mb-5">
                        <h2 class="section-title">What's Included</h2>
                        <div class="bg-light p-4 rounded">
                            @foreach(json_decode($package->includes) as $include)
                            <div class="highlight-item">
                                ✓ {{ $include }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Excludes -->
                    @if($package->excludes)
                    <div class="mb-5">
                        <h2 class="section-title">What's Not Included</h2>
                        <div class="bg-light p-4 rounded">
                            @foreach(json_decode($package->excludes) as $exclude)
                            <div class="highlight-item">
                                ✗ {{ $exclude }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="price-box">
                        <h3>Pricing</h3>
                        
                        @if($package->price_adult)
                        <div class="price-item">
                            <span>Adult</span>
                            <strong>Rp {{ number_format($package->price_adult, 0, ',', '.') }}</strong>
                        </div>
                        @endif
                        
                        @if($package->price_child)
                        <div class="price-item">
                            <span>Child</span>
                            <strong>Rp {{ number_format($package->price_child, 0, ',', '.') }}</strong>
                        </div>
                        @endif
                        
                        @if($package->price_infant)
                        <div class="price-item">
                            <span>Infant</span>
                            <strong>Rp {{ number_format($package->price_infant, 0, ',', '.') }}</strong>
                        </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('home') }}#contact" class="btn btn-book">Contact to Book</a>
                        </div>

                        @if($package->min_participants)
                        <div class="text-white mt-3 text-center">
                            <small>Minimum {{ $package->min_participants }} participants</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-2"><strong>JJB Travel Services</strong></p>
            <p class="mb-0">Java Representative - Your trusted partner for Indonesian adventures</p>
            <p class="mt-3">&copy; {{ date('Y') }} JJB Travel Services. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
