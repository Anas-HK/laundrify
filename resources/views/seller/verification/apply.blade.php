@extends('seller.layouts.app')

@section('content')
<div class="verification-container">
    <!-- Success and Error Messages -->
    @if(session('success'))
    <div class="alert alert-success mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    </div>
    @endif

    <!-- Verification Details Card -->
    <div class="verification-card">
        <div class="verification-header">
            <h5><i class="bi bi-shield-check"></i> Seller Verification</h5>
        </div>
        
        <div class="verification-body">
            <!-- Verification Benefits -->
            <div class="verification-benefits">
                <h5><i class="bi bi-star-fill"></i> Benefits of Verification</h5>
                <ul class="benefits-list">
                    <li>Gain customer trust with a verified badge</li>
                    <li>Appear higher in search results</li>
                    <li>Unlock premium selling features</li>
                    <li>Higher limit on service listings</li>
                    <li>Reduced service fees</li>
                </ul>
            </div>

            <!-- Verification Status -->
            @php
                $seller = Auth::guard('seller')->user();
                $status = $seller->verification_status ?? 'none';
            @endphp

            @if($status == 'pending')
            <div class="verification-status pending">
                <h5><i class="bi bi-hourglass-split"></i> Verification Pending</h5>
                <p>Your verification application is under review. This process typically takes 1-3 business days. We'll notify you once a decision has been made.</p>
            </div>
            @elseif($status == 'verified')
            <div class="verification-status approved">
                <h5><i class="bi bi-check-circle-fill"></i> Verification Approved</h5>
                <p>Congratulations! Your account has been successfully verified. You now have access to all the benefits of being a verified seller.</p>
            </div>
            @elseif($status == 'rejected')
            <div class="verification-status rejected">
                <h5><i class="bi bi-x-circle-fill"></i> Verification Rejected</h5>
                <p>Unfortunately, your verification application has been rejected. Reason: <strong>{{ $seller->verification_notes }}</strong></p>
                <p>You can submit a new application with updated information.</p>
            </div>
            @endif

            <!-- Verification Form -->
            @if($status != 'verified' && $status != 'pending')
            <form action="{{ route('seller.verification.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="business_name" class="form-label">
                        <i class="bi bi-building"></i> Business Name <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" value="{{ old('business_name') }}" required>
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Enter your official registered business name</div>
                </div>

                <div class="mb-4">
                    <label for="business_address" class="form-label">
                        <i class="bi bi-geo-alt"></i> Business Address <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" class="form-control @error('business_address') is-invalid @enderror" id="business_address" name="business_address" value="{{ old('business_address') }}" required>
                    @error('business_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tax_id" class="form-label">
                        <i class="bi bi-file-earmark-text"></i> Tax ID / Business Registration Number <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" class="form-control @error('tax_id') is-invalid @enderror" id="tax_id" name="tax_id" value="{{ old('tax_id') }}" required>
                    @error('tax_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">
                        <i class="bi bi-telephone"></i> Business Phone <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">
                        <i class="bi bi-info-circle"></i> Business Description <span class="required-asterisk">*</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Describe your business, services, and experience (minimum 100 characters)</div>
                </div>

                <div class="document-upload mb-4">
                    <label class="form-label">
                        <i class="bi bi-file-earmark-text"></i> Required Documents <span class="required-asterisk">*</span>
                    </label>
                    
                    <div class="upload-item">
                        <label class="file-upload-label">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <span>Upload Business Registration</span>
                            <input type="file" name="business_registration" class="file-upload-input @error('business_registration') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                        <div class="file-info">Accepted formats: PDF, JPG, PNG (max 5MB)</div>
                        @error('business_registration')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="upload-item">
                        <label class="file-upload-label">
                            <i class="bi bi-file-earmark-person"></i>
                            <span>Upload ID Proof</span>
                            <input type="file" name="id_proof" class="file-upload-input @error('id_proof') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                        </label>
                        <div class="file-info">Official government ID (passport, driver's license, etc.)</div>
                        @error('id_proof')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="upload-item">
                        <label class="file-upload-label">
                            <i class="bi bi-file-earmark-richtext"></i>
                            <span>Upload Additional Supporting Document (Optional)</span>
                            <input type="file" name="additional_document" class="file-upload-input @error('additional_document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        </label>
                        <div class="file-info">Any additional documentation that supports your application</div>
                        @error('additional_document')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="custom-checkbox">
                    <input type="checkbox" id="terms_agree" name="terms_agree" required>
                    <span class="checkbox-icon"></span>
                    <label for="terms_agree" class="custom-checkbox-label">
                        I confirm that all information provided is accurate and complete. I understand that providing false information may result in rejection of verification and/or account termination.
                    </label>
                    @error('terms_agree')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check"></i> Submit Verification
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sellerVerification.css') }}">
@endsection

@section('scripts')
<script>
    // File upload preview
    document.querySelectorAll('.file-upload-input').forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            if (fileName) {
                const label = this.closest('.file-upload-label');
                const spanElement = label.querySelector('span');
                spanElement.textContent = fileName;
                label.style.borderColor = 'var(--primary)';
                label.style.backgroundColor = 'var(--primary-light)';
                
                // Add a small check icon to indicate successful upload
                const icon = label.querySelector('i');
                icon.className = 'bi bi-check-circle-fill';
                icon.style.color = 'var(--success)';
            }
        });
    });
</script>
@endsection 