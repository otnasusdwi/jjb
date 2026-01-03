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
            position: relative;
            min-height: 500px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .package-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.9) 0%, rgba(44, 44, 44, 0.85) 100%);
            z-index: 1;
        }

        .package-header-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .package-header-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 80px 0 40px;
        }
        
        .package-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .package-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255,255,255,0.95);
            font-weight: 500;
            background: rgba(255,255,255,0.1);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            backdrop-filter: blur(10px);
        }

        .lead {
            color: rgba(255,255,255,0.95);
            font-size: 1.1rem;
            line-height: 1.6;
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
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .highlight-item:last-child {
            border-bottom: none;
        }

        .content-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .accordion-item {
            border: none;
            margin-bottom: 1rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .accordion-button {
            background: linear-gradient(135deg, #FFF4E6 0%, #FFE5CC 100%);
            color: var(--text-dark);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
        }

        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            color: white;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .accordion-body {
            padding: 1.5rem;
            background: #fafafa;
        }

        .tag-badge {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        footer {
            background: #2C2C2C;
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-top: 80px;
        }

        @media (max-width: 768px) {
            .package-title {
                font-size: 2rem;
            }
            .price-box {
                position: relative;
                top: 0;
                margin-top: 2rem;
            }
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
        @if($package->featured_image)
        <div class="package-header-bg" style="background-image: url('{{ asset('storage/' . $package->featured_image) }}');"></div>
        @endif
        <div class="package-header-content w-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
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
                                {{ ucfirst($package->category) }}
                            </div>
                            @endif
                            @if($package->location)
                            <div class="meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                                {{ $package->location }}
                            </div>
                            @endif
                        </div>
                        @if($package->short_description)
                        <p class="lead">{{ $package->short_description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Package Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Gallery Carousel -->
                    @if($package->galleries && $package->galleries->count() > 0)
                    <div id="packageGallery" class="carousel slide mb-5" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($package->galleries->sortBy('order') as $index => $gallery)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption ?? $package->name }}" class="package-image">
                                @if($gallery->caption)
                                <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); padding: 1rem; border-radius: 10px; bottom: 20px;">
                                    <p class="mb-0">{{ $gallery->caption }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @if($package->galleries->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#packageGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#packageGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        @endif
                    </div>
                    @elseif($package->main_image_path)
                    <img src="{{ asset('storage/' . $package->main_image_path) }}" alt="{{ $package->name }}" class="package-image mb-5">
                    @endif

                    <!-- Tags -->
                    @if($package->tags && $package->tags->count() > 0)
                    <div class="content-card">
                        <h2 class="section-title">Tour Categories</h2>
                        <div>
                            @foreach($package->tags as $tag)
                            <span class="tag-badge" style="background-color: {{ $tag->color ?? '#FF8C00' }}; color: white;">
                                {{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Description -->
                    <div class="content-card">
                        <h2 class="section-title">About This Tour</h2>
                        <div style="line-height: 1.8; color: var(--text-light);">{!! nl2br(e($package->description)) !!}</div>
                    </div>

                    <!-- Itinerary -->
                    @if($package->itineraries && $package->itineraries->count() > 0)
                    <div class="content-card">
                        <h2 class="section-title">Day-by-Day Itinerary</h2>
                        <div class="accordion" id="itineraryAccordion">
                            @foreach($package->itineraries as $itinerary)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#itinerary{{ $itinerary->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                    <strong>Day {{ $itinerary->day_number }}: {{ $itinerary->title }}</strong>
                                    </button>
                                </h2>
                                <div id="itinerary{{ $itinerary->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#itineraryAccordion">
                                    <div class="accordion-body">
                                        <p>{{ $itinerary->description }}</p>
                                        
                                        @if($itinerary->meals || $itinerary->accommodation)
                                        <div class="mt-3 pt-3 border-top">
                                            @if($itinerary->breakfast || $itinerary->lunch || $itinerary->dinner)
                                            <p class="mb-2">
                                                <strong>🍽️ Meals:</strong> 
                                                @php
                                                    $meals = [];
                                                    if ($itinerary->breakfast) $meals[] = 'Breakfast';
                                                    if ($itinerary->lunch) $meals[] = 'Lunch';
                                                    if ($itinerary->dinner) $meals[] = 'Dinner';
                                                @endphp
                                                {{ implode(', ', $meals) ?: 'As per schedule' }}
                                            </p>
                                            @endif
                                            @if($itinerary->accommodation)
                                            <p class="mb-0">
                                                <strong>🏨 Accommodation:</strong> {{ $itinerary->accommodation }}
                                            </p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Inclusions -->
                    @if($package->inclusions && $package->inclusions->count() > 0)
                    <div class="content-card">
                        <h2 class="section-title">What's Included</h2>
                        <div class="bg-light p-4 rounded" style="border-left: 4px solid var(--primary-orange);">
                            @foreach($package->inclusions as $inclusion)
                            <div class="highlight-item">
                                <strong>✓ {{ $inclusion->title }}</strong>
                                @if($inclusion->description)
                                <br><small class="text-muted">{{ $inclusion->description }}</small>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Exclusions -->
                    @if($package->exclusions && $package->exclusions->count() > 0)
                    <div class="content-card">
                        <h2 class="section-title">What's Not Included</h2>
                        <div class="bg-light p-4 rounded" style="border-left: 4px solid #dc3545;">
                            @foreach($package->exclusions as $exclusion)
                            <div class="highlight-item">
                                <strong>✗ {{ $exclusion->title }}</strong>
                                @if($exclusion->description)
                                <br><small class="text-muted">{{ $exclusion->description }}</small>
                                @endif
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
