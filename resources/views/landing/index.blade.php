<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JJB Travel Services - Your Asia Dream's Come True</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-orange: #FF8C00;
            --dark-orange: #E67E00;
            --light-orange: #FFA500;
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
        
        /* Navbar */
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
        
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-orange) !important;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #FFF4E6 0%, #FFE5CC 100%);
            padding: 80px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .hero-description {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 2rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-orange);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-primary-custom:hover {
            background: var(--dark-orange);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 140, 0, 0.3);
        }
        
        /* Destination Slider */
        .destination-slider {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 400px;
        }
        
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        
        /* Section Titles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: var(--primary-orange);
        }
        
        /* Experience Cards */
        .experience-card {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            color: white;
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .experience-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(255, 140, 0, 0.4);
        }
        
        .experience-card.active {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 50px rgba(255, 140, 0, 0.6);
        }
        
        .experience-card.active::before {
            content: '✓';
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: white;
            color: var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .experience-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .experience-card .btn {
            margin-top: 1rem;
            background: white;
            color: var(--primary-orange);
            border: none;
            padding: 10px 30px;
            font-weight: 600;
            border-radius: 25px;
        }
        
        .experience-card .btn:hover {
            background: #f8f9fa;
        }
        
        /* Package Cards */
        .package-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
        }
        
        .package-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .package-image {
            height: 220px;
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .package-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .package-body {
            padding: 1.5rem;
        }
        
        .package-duration {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        
        .package-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .package-card .btn-outline-primary {
            border: 2px solid var(--primary-orange);
            color: var(--primary-orange);
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 25px;
            width: 100%;
        }
        
        .package-card .btn-outline-primary:hover {
            background: var(--primary-orange);
            color: white;
        }
        
        /* Video Section */
        .video-section {
            background: #f8f9fa;
            padding: 80px 0;
        }
        
        .video-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--text-light);
        }
        
        /* Itinerary Section */
        .itinerary-list {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .itinerary-item {
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
            font-size: 1.1rem;
            color: var(--text-dark);
            transition: all 0.3s;
        }
        
        .itinerary-item:last-child {
            border-bottom: none;
        }
        
        .itinerary-item:hover {
            color: var(--primary-orange);
            padding-left: 10px;
        }
        
        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--dark-orange) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        
        .contact-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .contact-section .btn {
            background: white;
            color: var(--primary-orange);
            padding: 15px 40px;
            font-weight: 600;
            border-radius: 50px;
            border: none;
            font-size: 1.1rem;
        }
        
        .contact-section .btn:hover {
            background: #f8f9fa;
        }
        
        /* Footer */
        footer {
            background: #2C2C2C;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        section {
            padding: 80px 0;
        }
        
        /* Filter Controls */
        .filter-controls {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .filter-badge {
            display: inline-block;
            padding: 10px 25px;
            background: var(--primary-orange);
            color: white;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .clear-filter {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
            margin-left: 15px;
            cursor: pointer;
        }
        
        .clear-filter:hover {
            text-decoration: underline;
        }
        
        .package-card.hidden {
            display: none;
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            display: none;
        }
        
        .no-results.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <strong>JJB</strong> Travel Services
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#experience">Experience</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <p class="hero-subtitle">Java Representative</p>
                    <h1 class="hero-title">Your Asia Dream's Come True: Indonesia</h1>
                    <p class="hero-description">
                        Experience with our expert in Java, Bali, Lombok and Labuan Bajo. 
                        Discover the authentic beauty of Indonesia with personalized tours designed for European travelers.
                    </p>
                    <a href="#packages" class="btn btn-primary-custom">Browse Packages</a>
                </div>
                <div class="col-lg-6">
                    <!-- Destination Carousel -->
                    <div id="destinationCarousel" class="carousel slide destination-slider" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.unsplash.com/photo-1555400082-e10adb7e5e1e?w=800&h=600&fit=crop" alt="Bali Temple">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&h=600&fit=crop" alt="Borobudur">
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1606158108378-64d7e18e6f42?w=800&h=600&fit=crop" alt="Komodo">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#destinationCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#destinationCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
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
                    <div class="experience-card" data-tag-id="{{ $tag->id }}" data-tag-slug="{{ $tag->slug }}" onclick="filterByTag({{ $tag->id }}, '{{ $tag->name }}')">
                        <h3>{{ strtoupper($tag->name) }}</h3>
                        <p>{{ $tag->description }}</p>
                        <span class="btn">Explore Packages</span>
                    </div>
                </div>
                @endforeach
                
                <div class="col-md-4">
                    <div class="experience-card" onclick="window.location.href='#contact'">
                        <h3>CUSTOM</h3>
                        <p>Tailored Experiences</p>
                        <span class="btn">Contact Us</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Our Packages</h2>
                <div id="filterDisplay" class="filter-controls" style="display: none;">
                    <span class="filter-badge">
                        Showing: <span id="filterText"></span>
                    </span>
                    <a class="clear-filter" onclick="clearFilter()">Show All</a>
                </div>
            </div>
            
            <div class="row g-4 mt-3" id="packagesContainer">
                @forelse($packages as $package)
                <div class="col-md-4 package-item" 
                     data-tag-ids="{{ $package->tags->pluck('id')->join(',') }}">
                    <div class="package-card">
                        <div class="package-image">
                            @if($package->main_image_path)
                                <img src="{{ asset('storage/' . $package->main_image_path) }}" alt="{{ $package->name }}">
                            @else
                                <span>{{ $package->name }}</span>
                            @endif
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
                                <span class="badge" style="background-color: {{ $tag->color }}; font-size: 0.7rem;">{{ $tag->icon }} {{ $tag->name }}</span>
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

    <!-- Video & Itinerary Section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="video-container">
                        VIDEO COMING SOON
                    </div>
                </div>
                
                <div class="col-lg-5">
                    <h3 class="mb-4" style="font-weight: 700;">Popular Itineraries</h3>
                    <div class="itinerary-list">
                        <div class="itinerary-item">1 Day Yogyakarta Tour</div>
                        <div class="itinerary-item">3 Days The Legacy</div>
                        <div class="itinerary-item">4 Days The Legacy</div>
                        <div class="itinerary-item">3 Days Bali Exotic</div>
                        <div class="itinerary-item">4 Days Bali Exotic</div>
                        <div class="itinerary-item">5 Days Bali Exotic</div>
                        <div class="itinerary-item">1 Day Lombok Paradise</div>
                        <div class="itinerary-item">1 Day Labuan Bajo</div>
                        <div class="itinerary-item">Long Trip Java - Bali</div>
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
            <a href="mailto:info@jjbtravelservices.com" class="btn">Contact Us</a>
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
    
    <!-- Smooth Scroll -->
    <script>
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
        
        function filterByTag(tagId, tagName) {
            currentTagId = tagId;
            
            // Update active state on experience cards
            document.querySelectorAll('.experience-card').forEach(card => {
                card.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Get all package items
            const packages = document.querySelectorAll('.package-item');
            let visibleCount = 0;
            
            packages.forEach(package => {
                const packageTagIds = package.getAttribute('data-tag-ids');
                const tagIdsArray = packageTagIds ? packageTagIds.split(',').map(id => id.trim()) : [];
                
                // Check if package has the selected tag
                if (tagIdsArray.includes(String(tagId))) {
                    package.classList.remove('hidden');
                    visibleCount++;
                } else {
                    package.classList.add('hidden');
                }
            });
            
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
            document.getElementById('packages').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        
        function clearFilter() {
            currentTagId = null;
            
            // Remove active state from all cards
            document.querySelectorAll('.experience-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Show all packages
            document.querySelectorAll('.package-item').forEach(package => {
                package.classList.remove('hidden');
            });
            
            // Hide filter display and no results
            document.getElementById('filterDisplay').style.display = 'none';
            document.getElementById('noResults').classList.remove('show');
        }
        
        // Browse Packages button also clears filter
        document.querySelector('a[href="#packages"]')?.addEventListener('click', function(e) {
            clearFilter();
        });
    </script>
</body>
</html>
