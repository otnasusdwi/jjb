@extends('layouts.landing')

@section('head')
    <title>JJB Travel Services - Your Asia Dream's Come True</title>
    <link rel="stylesheet" href="{{ asset('css/landing-index.css') }}">
@endsection

@section('custom-styles')
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-background-carousel">
            @forelse($heroBanners as $banner)
            <div class="hero-bg-item {{ $loop->first ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $banner->image_path) }}');"></div>
            @empty
            <!-- Fallback to static images if no banners exist -->
            <div class="hero-bg-item active" style="background-image: url('{{ asset('images/hero/hero-1.jpg') }}');"></div>
            <div class="hero-bg-item" style="background-image: url('{{ asset('images/hero/hero-2.jpg') }}');"></div>
            <div class="hero-bg-item" style="background-image: url('{{ asset('images/hero/hero-3.jpg') }}');"></div>
            @endforelse
        </div>
        <div class="hero-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7 col-xl-6 mb-4 mb-lg-0">
                    <p class="hero-subtitle">Java Representative</p>
                    <h1 class="hero-title">Your Asia Dream's Come True: Indonesia</h1>
                    <p class="hero-description">
                        Experience with our expert in Java, Bali, Lombok and Labuan Bajo. 
                        Discover the authentic beauty of Indonesia with personalized tours designed for European travelers.
                    </p>
                    <a href="#packages" class="btn btn-primary-custom">Browse Packages</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience">
        <div class="container">
            <h2 class="section-title">Experience</h2>
            
            <div class="row g-4 mt-3">
                @foreach($destinationTags as $tag)
                <div class="col-md-4">
                    <div class="experience-card" data-tag-id="{{ $tag->id }}" data-tag-slug="{{ $tag->slug }}" onclick="filterByTag(event, {{ $tag->id }}, '{{ $tag->name }}')">
                        @if($tag->galleries && $tag->galleries->count() > 0)
                        <div class="experience-card-gallery">
                            <div id="carousel{{ $tag->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                                <div class="carousel-inner">
                                    @foreach($tag->galleries as $index => $gallery)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $tag->name }}">
                                    </div>
                                    @endforeach
                                </div>
                                @if($tag->galleries->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $tag->id }}" data-bs-slide="prev" style="width: 5%; background: rgba(0,0,0,0.3);">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $tag->id }}" data-bs-slide="next" style="width: 5%; background: rgba(0,0,0,0.3);">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="experience-card-content">
                            <h3>{{ strtoupper($tag->name) }}</h3>
                            <p>{{ $tag->description ?? ucfirst($tag->name) . ' Island packages' }}</p>
                            <button class="btn">Explore Packages</button>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="col-md-4">
                    <div class="experience-card" onclick="window.location.href='#contact'">
                        <div class="experience-card-gallery">
                            <div id="carouselCustom" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/custom/custom-1.jpg') }}" alt="Custom Tour">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/custom/custom-2.jpg') }}" alt="Custom Tour">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('images/custom/custom-3.jpg') }}" alt="Custom Tour">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselCustom" data-bs-slide="prev" style="width: 5%; background: rgba(0,0,0,0.3);">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselCustom" data-bs-slide="next" style="width: 5%; background: rgba(0,0,0,0.3);">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </div>
                        <div class="experience-card-content">
                            <h3>CUSTOM</h3>
                            <p>Tailored Experiences</p>
                            <button class="btn">Contact Us</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="section-title mb-0">Our Packages</h2>
                <div class="d-flex align-items-center gap-3">
                    <!-- Dropdown Filter -->
                    <select id="tagFilter" class="form-select" style="width: 200px; border-radius: 25px; border: 2px solid var(--primary-orange); color: var(--primary-orange); font-weight: 600;" onchange="filterByDropdown()">
                        <option value="">All Destinations</option>
                        @foreach($destinationTags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Active Filter Display -->
                    <div id="filterDisplay" class="filter-controls d-flex align-items-center gap-2" style="display: none;">
                        <span class="filter-badge">
                            Showing: <span id="filterText"></span>
                        </span>
                        <a class="clear-filter" onclick="clearFilter()">Show All</a>
                    </div>
                </div>
            </div>
            
            <div class="row g-4 mt-3" id="packagesContainer">
                @forelse($packages as $package)
                <div class="col-md-4 package-item" 
                     data-tag-ids="{{ $package->tags->pluck('id')->join(',') }}">
                    <div class="package-card">
                        <div class="package-image">
                            @if($package->featured_image)
                                <img src="{{ asset('storage/' . $package->featured_image) }}" alt="{{ $package->name }}">
                            @elseif($package->main_image_path)
                                <img src="{{ asset('storage/' . $package->main_image_path) }}" alt="{{ $package->name }}">
                            @else
                                <span>{{ $package->name }}</span>
                            @endif
                            <div class="package-info-tooltip">
                                <h4>{{ $package->name }}</h4>
                                <p>{{ Str::limit($package->short_description, 60) }}</p>
                            </div>
                        </div>
                        <div class="package-body">
                            <div class="package-duration">
                                {{ $package->duration_days }} {{ $package->duration_days > 1 ? 'Days' : 'Day' }}
                                @if($package->duration_nights > 0)
                                    / {{ $package->duration_nights }} {{ $package->duration_nights > 1 ? 'Nights' : 'Night' }}
                                @endif
                            </div>
                            <h3 class="package-title">{{ $package->name }}</h3>
                            <p class="text-muted mb-3">{{ Str::limit($package->short_description, 80) }}</p>
                            @if($package->tags->count() > 0)
                            <div class="mb-3">
                                @foreach($package->tags->take(3) as $tag)
                                <span class="badge" style="background-color: {{ $tag->color }}; font-size: 0.7rem;">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            @endif
                            <a href="{{ route('package.show', $package->slug) }}" class="btn btn-outline-primary">
                                See Itinerary
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Sample Packages if no data -->
                <div class="col-md-4 package-item" data-destination="yogyakarta heritage tour" data-category="java" data-location="yogyakarta">
                    <div class="package-card">
                        <div class="package-image">
                            <span>Classic Yogyakarta</span>
                        </div>
                        <div class="package-body">
                            <div class="package-duration">1 Day</div>
                            <h3 class="package-title">Yogyakarta Heritage Tour</h3>
                            <p class="text-muted mb-3">Explore the cultural heart of Java in one day</p>
                            <a href="#contact" class="btn btn-outline-primary">See Itinerary</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 package-item" data-destination="java legacy experience" data-category="java" data-location="java">
                    <div class="package-card">
                        <div class="package-image">
                            <span>The Legacy</span>
                        </div>
                        <div class="package-body">
                            <div class="package-duration">3 Days / 2 Nights</div>
                            <h3 class="package-title">Java Legacy Experience</h3>
                            <p class="text-muted mb-3">Ancient temples and cultural immersion</p>
                            <a href="#contact" class="btn btn-outline-primary">See Itinerary</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 package-item" data-destination="bali exotic paradise" data-category="bali" data-location="bali">
                    <div class="package-card">
                        <div class="package-image">
                            <span>Bali Exotic</span>
                        </div>
                        <div class="package-body">
                            <div class="package-duration">4 Days / 3 Nights</div>
                            <h3 class="package-title">Bali Exotic Paradise</h3>
                            <p class="text-muted mb-3">Island paradise with cultural experiences</p>
                            <a href="#contact" class="btn btn-outline-primary">See Itinerary</a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            
            <!-- No Results Message -->
            <div class="no-results" id="noResults">
                <i class="ri-search-line" style="font-size: 3rem; color: var(--text-light);"></i>
                <h4 class="mt-3">No packages found</h4>
                <p class="text-muted">Try selecting a different destination or <a href="#" onclick="clearFilter()" class="text-decoration-none">view all packages</a></p>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="video-container">
                        VIDEO COMING SOON
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2>Ready to Start Your Indonesian Adventure?</h2>
            <p class="mb-4">Contact us today to plan your perfect journey</p>
            <a href="https://wa.me/{{ config('contact.whatsapp_number') }}?text={{ urlencode('Hi, I would like to know more about your travel packages') }}" target="_blank" class="btn">Contact Us</a>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Hero Background Carousel
        let currentBgIndex = 0;
        const bgItems = document.querySelectorAll('.hero-bg-item');
        
        function changeHeroBackground() {
            bgItems[currentBgIndex].classList.remove('active');
            currentBgIndex = (currentBgIndex + 1) % bgItems.length;
            bgItems[currentBgIndex].classList.add('active');
        }
        
        // Auto change every 5 seconds
        setInterval(changeHeroBackground, 5000);
        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Package Filtering with Tags
        let currentTagId = null;
        
        function filterByDropdown() {
            const dropdown = document.getElementById('tagFilter');
            const selectedOption = dropdown.options[dropdown.selectedIndex];
            const tagId = selectedOption.value;
            const tagName = selectedOption.text;
            
            if (!tagId) {
                clearFilter();
                return;
            }
            
            applyFilter(tagId, tagName);
        }
        
        function filterByTag(event, tagId, tagName) {
            // Prevent default and stop propagation
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Update dropdown selection
            const dropdown = document.getElementById('tagFilter');
            if (dropdown) {
                dropdown.value = tagId;
            }
            
            // Update active state on experience cards
            document.querySelectorAll('.experience-card').forEach(card => {
                card.classList.remove('active');
            });
            
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }
            
            applyFilter(tagId, tagName);
        }
        
        function applyFilter(tagId, tagName) {
            currentTagId = tagId;
            
            // Get all package items
            const packages = document.querySelectorAll('.package-item');
            let visibleCount = 0;
            
            console.log('Filtering by tag:', tagId, tagName);
            
            packages.forEach(package => {
                const packageTagIds = package.getAttribute('data-tag-ids');
                console.log('Package tags:', packageTagIds);
                
                if (!packageTagIds) {
                    package.classList.add('hidden');
                    package.style.display = 'none';
                    return;
                }
                
                const tagIdsArray = packageTagIds.split(',').map(id => id.trim());
                
                // Check if package has the selected tag
                if (tagIdsArray.includes(String(tagId))) {
                    package.classList.remove('hidden');
                    package.style.display = '';
                    visibleCount++;
                    console.log('Showing package:', package.querySelector('.package-title')?.textContent);
                } else {
                    package.classList.add('hidden');
                    package.style.display = 'none';
                }
            });
            
            console.log('Visible packages:', visibleCount);
            
            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0) {
                noResults.classList.add('show');
            } else {
                noResults.classList.remove('show');
            }
            
            // Update filter display
            const filterDisplay = document.getElementById('filterDisplay');
            const filterText = document.getElementById('filterText');
            filterDisplay.style.display = 'block';
            filterText.textContent = tagName;
            
            // Smooth scroll to packages section
            setTimeout(() => {
                const packagesSection = document.getElementById('packages');
                if (packagesSection) {
                    packagesSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
        }
        
        function clearFilter() {
            currentTagId = null;
            
            // Reset dropdown
            const dropdown = document.getElementById('tagFilter');
            if (dropdown) {
                dropdown.value = '';
            }
            
            // Remove active state from all cards
            document.querySelectorAll('.experience-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Show all packages
            document.querySelectorAll('.package-item').forEach(package => {
                package.classList.remove('hidden');
                package.style.display = '';
            });
            
            // Hide filter display and no results
            const filterDisplay = document.getElementById('filterDisplay');
            const noResults = document.getElementById('noResults');
            
            if (filterDisplay) {
                filterDisplay.style.display = 'none';
            }
            if (noResults) {
                noResults.classList.remove('show');
            }
        }
        
        // Browse Packages button also clears filter
        document.querySelector('a[href="#packages"]')?.addEventListener('click', function(e) {
            clearFilter();
        });
    </script>
@endsection
