@extends('seller.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Apply for Seller Verification</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    @if(isset($verificationRequest) && $verificationRequest && $verificationRequest->status === 'pending')
                        <div class="alert alert-info">
                            <h5><i class="fas fa-info-circle"></i> Verification in Progress</h5>
                            <p>Your verification request is currently under review. We will notify you once the process is complete.</p>
                            <p><strong>Submitted on:</strong> {{ $verificationRequest->submitted_at->format('M d, Y') }}</p>
                            <a href="{{ route('seller.verification.status') }}" class="btn btn-primary">View Status</a>
                        </div>
                    @elseif(isset($verificationRequest) && $verificationRequest && $verificationRequest->status === 'approved')
                        <div class="alert alert-success">
                            <h5><i class="fas fa-check-circle"></i> Already Verified</h5>
                            <p>Congratulations! Your account has already been verified.</p>
                            <p><strong>Approved on:</strong> {{ $verificationRequest->reviewed_at->format('M d, Y') }}</p>
                            <a href="{{ route('seller.panel') }}" class="btn btn-primary">Return to Dashboard</a>
                        </div>
                    @elseif(isset($verificationRequest) && $verificationRequest && $verificationRequest->status === 'rejected')
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-exclamation-triangle"></i> Previous Request Rejected</h5>
                            <p>Your previous verification request was rejected. Please review the feedback and submit a new request.</p>
                            <p><strong>Reason:</strong> {{ $verificationRequest->rejection_reason }}</p>
                        </div>
                        
                        <form action="{{ route('seller.verification.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="business_description" class="form-label">Business Description <span class="text-danger">*</span></label>
                                <textarea name="business_description" id="business_description" rows="4" class="form-control @error('business_description') is-invalid @enderror" required>{{ old('business_description') }}</textarea>
                                <small class="form-text text-muted">Provide a detailed description of your laundry business (minimum 50 characters).</small>
                                @error('business_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason_for_verification" class="form-label">Why are you applying for verification? <span class="text-danger">*</span></label>
                                <textarea name="reason_for_verification" id="reason_for_verification" rows="4" class="form-control @error('reason_for_verification') is-invalid @enderror" required>{{ old('reason_for_verification') }}</textarea>
                                <small class="form-text text-muted">Explain why you want your account to be verified (minimum 50 characters).</small>
                                @error('reason_for_verification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Supporting Documents <span class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <input type="file" name="documents[]" class="form-control @error('documents.*') is-invalid @enderror" required>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="file" name="documents[]" class="form-control">
                                </div>
                                <div class="input-group">
                                    <input type="file" name="documents[]" class="form-control">
                                </div>
                                <small class="form-text text-muted">Upload documents to support your verification request (business license, ID proof, etc.). Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                @if($errors->has('documents.*'))
                                    <div class="text-danger mt-1">{{ $errors->first('documents.*') }}</div>
                                @endif
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="verification_agreement" name="verification_agreement" required>
                                <label class="form-check-label" for="verification_agreement">
                                    I confirm that all information and documents provided are true and accurate.
                                </label>
                                @error('verification_agreement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('seller.panel') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Verification Request</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info mb-4">
                            <h5><i class="fas fa-info-circle"></i> Why Get Verified?</h5>
                            <ul class="mb-0">
                                <li>Build trust with customers</li>
                                <li>Get a verification badge next to your name</li>
                                <li>Appear higher in search results</li>
                                <li>Access to premium features</li>
                            </ul>
                        </div>
                        
                        <form action="{{ route('seller.verification.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="business_description" class="form-label">Business Description <span class="text-danger">*</span></label>
                                <textarea name="business_description" id="business_description" rows="4" class="form-control @error('business_description') is-invalid @enderror" required>{{ old('business_description') }}</textarea>
                                <small class="form-text text-muted">Provide a detailed description of your laundry business (minimum 50 characters).</small>
                                @error('business_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason_for_verification" class="form-label">Why are you applying for verification? <span class="text-danger">*</span></label>
                                <textarea name="reason_for_verification" id="reason_for_verification" rows="4" class="form-control @error('reason_for_verification') is-invalid @enderror" required>{{ old('reason_for_verification') }}</textarea>
                                <small class="form-text text-muted">Explain why you want your account to be verified (minimum 50 characters).</small>
                                @error('reason_for_verification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Supporting Documents <span class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <input type="file" name="documents[]" class="form-control @error('documents.*') is-invalid @enderror" required>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="file" name="documents[]" class="form-control">
                                </div>
                                <div class="input-group">
                                    <input type="file" name="documents[]" class="form-control">
                                </div>
                                <small class="form-text text-muted">Upload documents to support your verification request (business license, ID proof, etc.). Allowed formats: PDF, JPG, JPEG, PNG. Max 5MB per file.</small>
                                @if($errors->has('documents.*'))
                                    <div class="text-danger mt-1">{{ $errors->first('documents.*') }}</div>
                                @endif
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="verification_agreement" name="verification_agreement" required>
                                <label class="form-check-label" for="verification_agreement">
                                    I confirm that all information and documents provided are true and accurate.
                                </label>
                                @error('verification_agreement')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('seller.panel') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Verification Request</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 