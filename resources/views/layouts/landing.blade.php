<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
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
        
        /* Footer */
        footer {
            background: #2C2C2C;
            color: #999;
            padding: 60px 0 0;
            margin-top: 0;
        }
        
        .footer-brand {
            color: var(--primary-orange);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .footer-desc {
            color: #999;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .footer-contact p {
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .footer-contact i {
            color: var(--primary-orange);
            margin-right: 0.5rem;
        }
        
        .footer-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: #999;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary-orange);
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: #3a3a3a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: var(--primary-orange);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid #3a3a3a;
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
        }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
        }

        /* WhatsApp Popup */
        .whatsapp-popup {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 320px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            z-index: 999;
            display: none;
            overflow: hidden;
        }

        .whatsapp-popup.show {
            display: block;
            animation: slideUp 0.3s;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .whatsapp-popup-header {
            background: #25D366;
            color: white;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .whatsapp-popup-avatar {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #25D366;
        }

        .whatsapp-popup-info h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .whatsapp-popup-info p {
            margin: 0;
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .whatsapp-popup-body {
            padding: 1.5rem;
        }

        .whatsapp-popup-message {
            background: #f0f0f0;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .whatsapp-popup-btn {
            display: block;
            width: 100%;
            background: #25D366;
            color: white;
            text-align: center;
            padding: 0.875rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .whatsapp-popup-btn:hover {
            background: #1da851;
            color: white;
        }

        .whatsapp-popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        @yield('custom-styles')
    </style>
    
    @yield('head')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('jjb-orange-hitam.png') }}" alt="JJB Travel Services" style="height: 50px;">
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
                        <a class="nav-link" href="{{ route('home') }}#experience">Experience</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#packages">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- WhatsApp Floating Button -->
    <div class="whatsapp-float" onclick="toggleWhatsAppPopup()">
        <i class="bi bi-whatsapp"></i>
    </div>

    <!-- WhatsApp Popup -->
    <div class="whatsapp-popup" id="whatsappPopup">
        <div class="whatsapp-popup-header">
            <button class="whatsapp-popup-close" onclick="toggleWhatsAppPopup()">&times;</button>
            <div class="whatsapp-popup-avatar">
                <i class="bi bi-headset"></i>
            </div>
            <div class="whatsapp-popup-info">
                <h4>JJB Travel Services</h4>
                <p>Typically replies instantly</p>
            </div>
        </div>
        <div class="whatsapp-popup-body">
            <div class="whatsapp-popup-message">
                <strong>Hi there! 👋</strong><br>
                How can we help you plan your Indonesian adventure today?
            </div>
            <a href="https://wa.me/{{ config('contact.whatsapp_number') }}?text={{ urlencode('Hi, I would like to know more about your travel packages') }}" target="_blank" class="whatsapp-popup-btn">
                <i class="bi bi-whatsapp"></i> Start Chat
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <img src="{{ asset('jjb.png') }}" alt="JJB Travel Services" style="height: 50px; padding-bottom: 10px;">
                    <p class="footer-desc">Your trusted partner for Indonesian adventures. Java Representative.</p>
                    <div class="footer-contact">
                        <p><i class="bi bi-telephone"></i> +62 813-9949-1466</p>
                        <p><i class="bi bi-geo-alt"></i> Yogyakarta, Indonesia</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#home">Home</a></li>
                        <li><a href="{{ route('home') }}#experience">Experience</a></li>
                        <li><a href="{{ route('home') }}#packages">Packages</a></li>
                        <li><a href="{{ route('home') }}#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Popular Destinations</h4>
                    <ul class="footer-links">
                        <li><a href="#">Bali</a></li>
                        <li><a href="#">Java</a></li>
                        <li><a href="#">Lombok</a></li>
                        <li><a href="#">Komodo</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="footer-title">Follow Us</h4>
                    <p class="footer-desc">Stay connected for latest travel updates and special offers.</p>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} JJB Travel Services. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- WhatsApp Script -->
    <script>
        // WhatsApp Popup Toggle
        function toggleWhatsAppPopup() {
            const popup = document.getElementById('whatsappPopup');
            popup.classList.toggle('show');
        }

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('whatsappPopup');
            const floatBtn = document.querySelector('.whatsapp-float');
            
            if (popup.classList.contains('show') && 
                !popup.contains(event.target) && 
                !floatBtn.contains(event.target)) {
                popup.classList.remove('show');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
