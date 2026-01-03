@extends('layouts.admin')

@section('title', 'Add New Affiliate')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Add New Affiliate</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.affiliates.index') }}">Affiliates</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.affiliates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp Number</label>
                                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                                           id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}">
                                    @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                           id="city" name="city" value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select @error('country') is-invalid @enderror" id="country" name="country">
                                        <option value="">Select Country</option>
                                        <option value="Indonesia" {{ old('country') === 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="Malaysia" {{ old('country') === 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                        <option value="Singapore" {{ old('country') === 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                        <option value="Thailand" {{ old('country') === 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                        <option value="Philippines" {{ old('country') === 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                        <option value="Vietnam" {{ old('country') === 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                        <option value="Other" {{ old('country') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio" rows="4"
                                      placeholder="Tell us about yourself and your experience in travel industry...">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Account Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Minimum 8 characters with at least one letter and one number</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control"
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="affiliate_code" class="form-label">Affiliate Code</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('affiliate_code') is-invalid @enderror"
                                               id="affiliate_code" name="affiliate_code" value="{{ old('affiliate_code') }}"
                                               placeholder="Auto-generated if empty">
                                        <button class="btn btn-outline-secondary" type="button" onclick="generateAffiliateCode()">
                                            <i class="ri-refresh-line"></i>
                                        </button>
                                    </div>
                                    @error('affiliate_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Unique code for affiliate tracking (leave empty for auto-generation)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="commission_rate" class="form-label">Commission Rate (%)</label>
                                    <input type="number" step="0.01" min="0" max="100"
                                           class="form-control @error('commission_rate') is-invalid @enderror"
                                           id="commission_rate" name="commission_rate" value="{{ old('commission_rate', 10) }}">
                                    @error('commission_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bank_details" class="form-label">Bank Details (for commission payments)</label>
                            <textarea class="form-control @error('bank_details') is-invalid @enderror"
                                      id="bank_details" name="bank_details" rows="3"
                                      placeholder="Bank name, account holder, account number...">{{ old('bank_details') }}</textarea>
                            @error('bank_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Settings -->
            <div class="col-lg-4">
                <!-- Profile Picture -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Picture</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="avatar-xl mx-auto mb-3">
                                <img id="avatar-preview" src="{{ asset('images/default-avatar.png') }}"
                                     class="img-fluid rounded-circle" alt="Preview">
                            </div>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                   id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Max file size: 2MB. Supported formats: JPG, PNG</div>
                        </div>
                    </div>
                </div>

                <!-- Status & Settings -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Status & Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Account Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1"
                                   {{ old('email_verified') ? 'checked' : '' }}>
                            <label class="form-check-label" for="email_verified">
                                Mark email as verified
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="receive_notifications"
                                   name="receive_notifications" value="1" {{ old('receive_notifications', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="receive_notifications">
                                Receive email notifications
                            </label>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="marketing_emails"
                                   name="marketing_emails" value="1" {{ old('marketing_emails', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="marketing_emails">
                                Receive marketing emails
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Admin Notes</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Internal Notes</label>
                            <textarea class="form-control @error('admin_notes') is-invalid @enderror"
                                      id="admin_notes" name="admin_notes" rows="4"
                                      placeholder="Internal notes about this affiliate (not visible to the affiliate)">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-save-line"></i> Create Affiliate
                            </button>
                            <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Preview uploaded image
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('avatar-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Generate random affiliate code
function generateAffiliateCode() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let result = 'JJB';
    for (let i = 0; i < 5; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    document.getElementById('affiliate_code').value = result;
}

// Auto-fill WhatsApp from phone number
document.getElementById('phone').addEventListener('input', function(e) {
    const whatsappField = document.getElementById('whatsapp');
    if (!whatsappField.value) {
        whatsappField.value = this.value;
    }
});
</script>
@endpush
