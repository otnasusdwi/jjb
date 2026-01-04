<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registration Success - {{ config('app.name', 'JJB Travel Bali') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .success-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="success-card p-5 text-center">
                    <!-- Success Icon -->
                    <div class="success-icon">
                        <i class="bi bi-check-lg text-white" style="font-size: 2rem;"></i>
                    </div>

                    <!-- Header -->
                    <h2 class="text-success mb-3">Registration Submitted!</h2>
                    <p class="text-muted mb-4">
                        Thank you for your interest in joining JJB Travel Bali affiliate program.
                    </p>

                    <!-- Success Message -->
                    <div class="alert alert-success">
                        <h6><i class="bi bi-info-circle"></i> What happens next?</h6>
                        <ul class="text-start mb-0">
                            <li>Our admin team will review your application within 1-2 business days</li>
                            <li>You will receive an email notification about the status of your application</li>
                            <li>If approved, you'll get login credentials to access your affiliate dashboard</li>
                        </ul>
                    </div>

                    @if(session('login_credentials'))
                    <div class="alert alert-info">
                        <h6><i class="bi bi-key"></i> Login Credentials</h6>
                        <p class="mb-2">Once approved, you can login with:</p>
                        <div class="text-start">
                            <strong>Email:</strong> {{ session('login_credentials')['email'] }}<br>
                            <strong>Password:</strong> {{ session('login_credentials')['password'] }}
                        </div>
                        <small class="text-muted">Please save these credentials for future reference</small>
                    </div>
                    @endif

                    <!-- Contact Information -->
                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h6 class="card-title">Need Assistance?</h6>
                            <p class="card-text small">
                                If you have any questions, please contact our support team:
                            </p>
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <i class="bi bi-envelope"></i>
                                    <small class="d-block">Email</small>
                                    <a href="mailto:admin@jjbtravelbali.com" class="small">admin@jjbtravelbali.com</a>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-whatsapp"></i>
                                    <small class="d-block">WhatsApp</small>
                                    <a href="https://wa.me/6281399491466" class="small">+62 813-9949-1466</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary me-2">
                            <i class="bi bi-house"></i> Back to Home
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
