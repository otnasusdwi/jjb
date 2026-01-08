@extends('layouts.landing')

@section('head')
    <!-- SEO Meta Tags -->
    <title>{{ $package->seo_title ?? $package->name }} - JJB Travel Services</title>
    <meta name="description" content="{{ $package->seo_description ?? $package->short_description ?? substr(strip_tags($package->description), 0, 160) }}">
    <meta name="keywords" content="{{ $package->seo_keywords ?? '' }}">
    <meta name="author" content="JJB Travel Services">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ route('package.show', $package->slug) }}">
    
    <!-- Open Graph Meta Tags (Social Media) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $package->seo_title ?? $package->name }}">
    <meta property="og:description" content="{{ $package->seo_description ?? $package->short_description ?? substr(strip_tags($package->description), 0, 160) }}">
    <meta property="og:url" content="{{ route('package.show', $package->slug) }}">
    @if($package->featured_image)
    <meta property="og:image" content="{{ asset('storage/' . $package->featured_image) }}">
    <meta property="og:image:type" content="image/jpeg">
    @endif
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $package->seo_title ?? $package->name }}">
    <meta name="twitter:description" content="{{ $package->seo_description ?? $package->short_description ?? substr(strip_tags($package->description), 0, 160) }}">
    @if($package->featured_image)
    <meta name="twitter:image" content="{{ asset('storage/' . $package->featured_image) }}">
    @endif
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#FF8C00">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="stylesheet" href="{{ asset('css/landing-package.css') }}">
@endsection

@section('custom-styles')
@endsection

@section('custom-styles')
@endsection

@section('content')

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
                        <div class="content-card">
                            <!-- Duration Badges -->
                            <div class="duration-badges">
                                <div class="duration-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zm2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527z"/>
                                    </svg>
                                    {{ $package->duration_days }} D {{ $package->duration_nights }} N
                                </div>
                                @if($package->min_participants)
                                <div class="duration-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                    </svg>
                                    {{ $package->min_participants }}+ Person
                                </div>
                                @endif
                            </div>

                            <!-- Description -->
                            <div style="line-height: 1.8; color: var(--text-light); margin-bottom: 2rem;">
                                {!! nl2br(e($package->description)) !!}
                            </div>

                            <!-- Package Details Table -->
                            <div class="info-table">
                                @if($package->location)
                                <div class="info-row">
                                    <div class="info-label">Destination</div>
                                    <div class="info-value">{{ $package->location }}</div>
                                </div>
                                @endif

                                @if($package->departure_location)
                                <div class="info-row">
                                    <div class="info-label">Departure</div>
                                    <div class="info-value">{{ $package->departure_location }}</div>
                                </div>
                                @endif

                                @if($package->departure_time)
                                <div class="info-row">
                                    <div class="info-label">Departure Time</div>
                                    <div class="info-value">{{ $package->departure_time }}</div>
                                </div>
                                @endif

                                @if($package->return_time)
                                <div class="info-row">
                                    <div class="info-label">Return Time</div>
                                    <div class="info-value">{{ $package->return_time }}</div>
                                </div>
                                @endif

                                @if($package->dress_code)
                                <div class="info-row">
                                    <div class="info-label">Dress Code</div>
                                    <div class="info-value">{{ $package->dress_code }}</div>
                                </div>
                                @endif

                                @if($package->inclusions && $package->inclusions->count() > 0)
                                <div class="info-row">
                                    <div class="info-label">Included</div>
                                    <div class="info-value">
                                        @foreach($package->inclusions as $inclusion)
                                        <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; align-items: flex-start;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#4ecdc4" viewBox="0 0 16 16" style="flex-shrink: 0; margin-top: 0.25rem;">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                            </svg>
                                            <div style="flex: 1;">
                                                <div style="color: #2C2C2C; line-height: 1.6; font-size: 1rem;">{{ $inclusion->description }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if($package->exclusions && $package->exclusions->count() > 0)
                                <div class="info-row">
                                    <div class="info-label">Not Included</div>
                                    <div class="info-value">
                                        @foreach($package->exclusions as $exclusion)
                                        <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; align-items: flex-start;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#dc3545" viewBox="0 0 16 16" style="flex-shrink: 0; margin-top: 0.25rem;">
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                            <div style="flex: 1;">
                                                <div style="color: #2C2C2C; line-height: 1.6; font-size: 1rem;">{{ $exclusion->description }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

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
                    </div>

                    <!-- Tab Content: Itinerary -->
                    <div id="tab-itinerary" class="tab-content-panel">
                        @if($package->itineraries && $package->itineraries->count() > 0)
                        <div class="content-card">
                            <h2 class="section-title">Itinerary</h2>
                            <div class="timeline">
                                @foreach($package->itineraries as $itinerary)
                                <div class="timeline-item">
                                    <div class="day-number">{{ $itinerary->day_number }}</div>
                                    <div class="timeline-content">
                                        <h3>Day {{ $itinerary->day_number }}@if($itinerary->day_title) - {{ $itinerary->day_title }}@endif</h3>
                                        @if($itinerary->items && $itinerary->items->count() > 0)
                                        <ul class="activity-list">
                                            @foreach($itinerary->items as $item)
                                            <li>{{ $item->title }}</li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p class="text-muted mb-0">No items available for this day.</p>
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
                        
                        @if($package->price)
                        <div class="price-item">
                            <span>Adult</span>
                            <strong>{{ $package->currency }} {{ number_format($package->price, 0, ',', '.') }}</strong>
                        </div>
                        @endif
                        
                        @if($package->child_price)
                        <div class="price-item">
                            <span>Child</span>
                            <strong>{{ $package->currency }} {{ number_format($package->child_price, 0, ',', '.') }}</strong>
                        </div>
                        @endif

                        <div class="mt-4">
                            <a href="https://wa.me/{{ config('contact.whatsapp_number') }}?text={{ urlencode('Hi, I am interested in booking: ' . $package->name) }}" target="_blank" class="btn btn-book">Contact to Book</a>
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
@endsection

@section('scripts')
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
@endsection
