<x-auth-layout>
    <x-slot name="title">Login</x-slot>

    <!-- Auth Header -->
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-plane fa-2x text-white"></i>
        </div>
        <h4 class="mb-0 fw-bold">Welcome Back!</h4>
        <p class="mb-0 opacity-75">Sign in to your JJB Travel Bali account</p>
    </div>

    <!-- Auth Body -->
    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="form-floating">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="name@example.com"
                       required
                       autofocus
                       autocomplete="username">
                <label for="email">
                    <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                </label>
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-floating">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Password"
                       required
                       autocomplete="current-password">
                <label for="password">
                    <i class="fas fa-lock me-2 text-muted"></i>Password
                </label>
                @error('password')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           id="remember_me"
                           name="remember">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        <i class="fas fa-key me-1"></i>Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </div>

            <!-- Divider -->
            <div class="text-center my-4">
                <div class="d-flex align-items-center">
                    <hr class="flex-grow-1">
                    <span class="mx-3 text-muted fw-500">or</span>
                    <hr class="flex-grow-1">
                </div>
            </div>

            <!-- Additional Links -->
            <div class="text-center">
                <p class="text-muted mb-0">
                    Don't have an account?
                    <a href="{{ route('affiliate.register') }}" class="forgot-password">
                        <i class="fas fa-user-plus me-1"></i>Register as Affiliate
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-auth-layout>
