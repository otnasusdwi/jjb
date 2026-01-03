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

        .timeline {
            position: relative;
            padding-left: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 80px;
            padding-bottom: 3rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 26px;
            top: 60px;
            bottom: -20px;
            width: 2px;
            border-left: 2px dashed #4ecdc4;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .day-number {
            position: absolute;
            left: 0;
            top: 0;
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #4ecdc4 0%, #44b3aa 100%);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.4);
        }

        .timeline-content h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        .activity-item {
            margin-bottom: 1.5rem;
        }

        .activity-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .activity-description {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        .activity-extras {
            margin-top: 1rem;
        }

        .activity-extras .activity-item {
            margin-bottom: 0.75rem;
        }

        .activity-extras .activity-title {
            font-size: 1rem;
            font-weight: 500;
        }

        .timeline-description {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .timeline-details {
            list-style: none;
            padding-left: 0;
        }

        .timeline-details li {
            padding: 0.5rem 0;
            color: var(--text-light);
            position: relative;
            padding-left: 1.5rem;
        }

        .timeline-details li::before {
            content: '■';
            position: absolute;
            left: 0;
            color: var(--text-dark);
            font-size: 0.8rem;
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

        .tab-navigation {
            background: white;
            border-radius: 15px;
            padding: 0.5rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            display: flex;
            gap: 0.5rem;
        }

        .tab-button {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            background: transparent;
            color: var(--text-light);
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tab-button:hover {
            background: rgba(255, 140, 0, 0.1);
            color: var(--primary-orange);
        }

        .tab-button.active {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
        }

        .tab-content-panel {
            display: none;
        }

        .tab-content-panel.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: transform 0.3s;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 1rem;
            font-size: 0.9rem;
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
                    <!-- Tab Navigation -->
                    <div class="tab-navigation">
                        <button class="tab-button active" onclick="switchTab('information')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            INFORMATION
                        </button>
                        <button class="tab-button" onclick="switchTab('itinerary')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                            ITINERARY
                        </button>
                        <button class="tab-button" onclick="switchTab('gallery')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            GALLERY
                        </button>
                    </div>

                    <!-- Tab Content: Information -->
                    <div id="tab-information" class="tab-content-panel active">
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

                    <!-- Tab Content: Itinerary -->
                    <div id="tab-itinerary" class="tab-content-panel">
                        @if(isset($groupedItineraries) && $groupedItineraries->count() > 0)
                        <div class="content-card">
                            <h2 class="section-title">Itinerary</h2>
                            <div class="timeline">
                                @foreach($groupedItineraries as $dayNumber => $dayItineraries)
                                <div class="timeline-item">
                                    <div class="day-number">{{ $dayNumber }}</div>
                                    <div class="timeline-content">
                                        <h3>Day {{ $dayNumber }}</h3>
                                        
                                        @foreach($dayItineraries as $itinerary)
                                        <div class="activity-item">
                                            <h4 class="activity-title">{{ $itinerary->title }}</h4>
                                            @if($itinerary->description)
                                            <p class="activity-description">{{ $itinerary->description }}</p>
                                            @endif
                                        </div>
                                        @endforeach

                                        @php
                                            // Get meals and accommodation from any itinerary in this day
                                            $firstItinerary = $dayItineraries->first();
                                        @endphp
                                        @if($firstItinerary && ($firstItinerary->breakfast || $firstItinerary->lunch || $firstItinerary->dinner || $firstItinerary->accommodation))
                                        <div class="activity-extras">
                                            @if($firstItinerary->accommodation)
                                            <div class="activity-item">
                                                <h4 class="activity-title">🏨 {{ $firstItinerary->accommodation }}</h4>
                                            </div>
                                            @endif
                                            @if($firstItinerary->breakfast)
                                            <div class="activity-item">
                                                <h4 class="activity-title">🍳 Breakfast</h4>
                                            </div>
                                            @endif
                                            @if($firstItinerary->lunch)
                                            <div class="activity-item">
                                                <h4 class="activity-title">🍽️ Lunch</h4>
                                            </div>
                                            @endif
                                            @if($firstItinerary->dinner)
                                            <div class="activity-item">
                                                <h4 class="activity-title">🍷 Dinner</h4>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="content-card text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted mb-3" viewBox="0 0 16 16">
                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                            <h4>No Itinerary Available</h4>
                            <p class="text-muted">Detailed itinerary will be provided upon booking.</p>
                        </div>
                        @endif
                    </div>

                    <!-- Tab Content: Gallery -->
                    <div id="tab-gallery" class="tab-content-panel">
                        @if($package->galleries && $package->galleries->count() > 0)
                        <div class="content-card">
                            <h2 class="section-title">Photo Gallery</h2>
                            <div class="gallery-grid">
                                @foreach($package->galleries->sortBy('order') as $gallery)
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption ?? $package->name }}">
                                    @if($gallery->caption)
                                    <div class="gallery-caption">
                                        {{ $gallery->caption }}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="content-card text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="text-muted mb-3" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            <h4>No Gallery Available</h4>
                            <p class="text-muted">Photos will be added soon.</p>
                        </div>
                        @endif
                    </div>
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
    
    <!-- Tab Switching Script -->
    <script>
        function switchTab(tabName) {
            // Hide all tab content panels
            document.querySelectorAll('.tab-content-panel').forEach(panel => {
                panel.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById('tab-' + tabName).classList.add('active');
            
            // Add active class to clicked button
            event.currentTarget.classList.add('active');
            
            // Scroll to top of content
            window.scrollTo({
                top: document.querySelector('.tab-navigation').offsetTop - 100,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>
