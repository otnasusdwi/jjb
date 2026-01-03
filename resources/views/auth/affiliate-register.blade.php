<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Affiliate Registration - {{ config('app.name', 'JJB Travel Bali') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .registration-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }
        .step::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 60%;
            right: -40%;
            height: 2px;
            background: #dee2e6;
            z-index: 1;
        }
        .step:last-child::after {
            display: none;
        }
        .step.active::after {
            background: #0d6efd;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #dee2e6;
            color: #6c757d;
            position: relative;
            z-index: 2;
        }
        .step.active .step-circle {
            background: #0d6efd;
            color: white;
        }
        .step.completed .step-circle {
            background: #198754;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="registration-card p-5">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="text-primary">
                            <i class="bi bi-airplane"></i>
                            JJB Travel Bali
                        </h2>
                        <h4 class="text-dark">Affiliate Registration</h4>
                        <p class="text-muted">Join our affiliate program and start earning commissions</p>
                    </div>

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active" id="step-1">
                            <div class="step-circle">1</div>
                            <small class="d-block mt-2">Personal Info</small>
                        </div>
                        <div class="step" id="step-2">
                            <div class="step-circle">2</div>
                            <small class="d-block mt-2">Documents</small>
                        </div>
                        <div class="step" id="step-3">
                            <div class="step-circle">3</div>
                            <small class="d-block mt-2">Banking</small>
                        </div>
                        <div class="step" id="step-4">
                            <div class="step-circle">4</div>
                            <small class="d-block mt-2">Finish</small>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('affiliate.register.store') }}" enctype="multipart/form-data" id="registrationForm">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div class="step-content" id="step-content-1">
                            <h5 class="mb-3">Personal Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required>
                                    @error('whatsapp_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Complete Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Birth Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date') }}" required>
                                @error('birth_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Step 2: Documents -->
                        <div class="step-content d-none" id="step-content-2">
                            <h5 class="mb-3">Documents Upload</h5>

                            <div class="mb-4">
                                <label for="ktp_number" class="form-label">KTP Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ktp_number" value="{{ old('ktp_number') }}" required>
                                @error('ktp_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="ktp_file" class="form-label">KTP File <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="ktp_file" accept=".jpg,.jpeg,.png,.pdf" required>
                                <div class="form-text">Upload your KTP scan (JPG, PNG, PDF max 5MB)</div>
                                @error('ktp_file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="npwp_number" class="form-label">NPWP Number (Optional)</label>
                                <input type="text" class="form-control" name="npwp_number" value="{{ old('npwp_number') }}">
                                @error('npwp_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="npwp_file" class="form-label">NPWP File (Optional)</label>
                                <input type="file" class="form-control" name="npwp_file" accept=".jpg,.jpeg,.png,.pdf">
                                <div class="form-text">Upload your NPWP scan if available (JPG, PNG, PDF max 5MB)</div>
                                @error('npwp_file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Step 3: Banking Information -->
                        <div class="step-content d-none" id="step-content-3">
                            <h5 class="mb-3">Banking Information</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                    <select class="form-control" name="bank_name" required>
                                        <option value="">Select Bank</option>
                                        <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>BCA</option>
                                        <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>BNI</option>
                                        <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>BRI</option>
                                        <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                        <option value="CIMB Niaga" {{ old('bank_name') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                        <option value="Other" {{ old('bank_name') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('bank_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_number" value="{{ old('account_number') }}" required>
                                    @error('account_number')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="account_holder_name" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="account_holder_name" value="{{ old('account_holder_name') }}" required>
                                <div class="form-text">Must match the name on your bank account</div>
                                @error('account_holder_name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="account_file" class="form-label">Bank Account Book/Statement <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="account_file" accept=".jpg,.jpeg,.png,.pdf" required>
                                <div class="form-text">Upload bank account book scan or statement (JPG, PNG, PDF max 5MB)</div>
                                @error('account_file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Step 4: Final Information -->
                        <div class="step-content d-none" id="step-content-4">
                            <h5 class="mb-3">Final Step</h5>

                            <div class="mb-4">
                                <label for="referral_code" class="form-label">Referral Code (Optional)</label>
                                <input type="text" class="form-control" name="referral_code" value="{{ old('referral_code') }}">
                                <div class="form-text">Enter referral code if you were referred by another affiliate</div>
                                @error('referral_code')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" target="_blank">Terms and Conditions</a> and
                                    <a href="#" target="_blank">Privacy Policy</a> <span class="text-danger">*</span>
                                </label>
                                @error('terms')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle"></i> Important Information:</h6>
                                <ul class="mb-0">
                                    <li>Your registration will be reviewed by our admin team</li>
                                    <li>Login credentials will be sent to your email after approval</li>
                                    <li>Your temporary password will be the last 8 digits of your KTP number</li>
                                    <li>Default commission rate is 10% (may be adjusted by admin)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                                <i class="bi bi-arrow-left"></i> Previous
                            </button>

                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                                    Next <i class="bi bi-arrow-right"></i>
                                </button>
                                <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                                    <i class="bi bi-check-circle"></i> Submit Registration
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center mt-4">
                        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function showStep(step) {
            // Hide all step contents
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.add('d-none');
            });

            // Show current step content
            document.getElementById(`step-content-${step}`).classList.remove('d-none');

            // Update step indicators
            document.querySelectorAll('.step').forEach((stepEl, index) => {
                stepEl.classList.remove('active', 'completed');
                if (index + 1 < step) {
                    stepEl.classList.add('completed');
                } else if (index + 1 === step) {
                    stepEl.classList.add('active');
                }
            });

            // Update navigation buttons
            document.getElementById('prevBtn').style.display = step > 1 ? 'block' : 'none';
            document.getElementById('nextBtn').style.display = step < totalSteps ? 'block' : 'none';
            document.getElementById('submitBtn').style.display = step === totalSteps ? 'block' : 'none';
        }

        function changeStep(direction) {
            if (direction === 1 && currentStep < totalSteps) {
                // Validate current step before proceeding
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else if (direction === -1 && currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        function validateStep(step) {
            const stepContent = document.getElementById(`step-content-${step}`);
            const requiredFields = stepContent.querySelectorAll('input[required], select[required], textarea[required]');

            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields before proceeding.');
            }

            return isValid;
        }

        // Initialize the form
        showStep(currentStep);

        // Remove validation styling when user types
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    </script>
</body>
</html>
