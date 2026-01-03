<x-auth-layout>
    <x-slot name="title">Forgot Password</x-slot>

    <!-- Auth Header -->
    <div class="auth-header">
        <div class="auth-logo">
            <img src="{{ asset('jjb.png') }}" alt="JJB Travel Bali" style="width: 60px; height: 60px; object-fit: contain;">
        </div>
        <h4 class="mb-0 fw-bold">Forgot Password?</h4>
        <p class="mb-0 opacity-75">No problem! We'll send you a reset link</p>
    </div>

    <!-- Auth Body -->
    <div class="auth-body">
        <!-- Description -->
        <div class="alert alert-info d-flex align-items-start mb-4">
            <i class="fas fa-info-circle me-2 mt-1"></i>
            <div>
                <small>Enter your email address and we'll send you a password reset link that will allow you to choose a new one.</small>
            </div>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Field -->
            <div class="form-floating mb-4">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="name@example.com"
                       required
                       autofocus>
                <label for="email">
                    <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                </label>
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="forgot-password">
                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                </a>
            </div>
        </form>
    </div>
</x-auth-layout>
