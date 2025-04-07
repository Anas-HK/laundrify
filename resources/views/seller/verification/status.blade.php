@extends('seller.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Verification Status</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    @if(session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif
                    
                    @if(!isset($verificationRequest) || !$verificationRequest)
                        <div class="alert alert-warning">
                            <h5><i class="fas fa-exclamation-circle"></i> No Verification Request Found</h5>
                            <p>You haven't submitted a verification request yet.</p>
                            <a href="{{ route('seller.verification.apply') }}" class="btn btn-primary mt-3">Apply for Verification</a>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center mb-4">
                                    <div class="verification-status-icon">
                                        @if($verificationRequest->status === 'pending')
                                            <i class="fas fa-clock fa-5x text-warning"></i>
                                        @elseif($verificationRequest->status === 'approved')
                                            <i class="fas fa-check-circle fa-5x text-success"></i>
                                        @else
                                            <i class="fas fa-times-circle fa-5x text-danger"></i>
                                        @endif
                                    </div>
                                    <h4 class="mt-3">
                                        @if($verificationRequest->status === 'pending')
                                            Pending Review
                                        @elseif($verificationRequest->status === 'approved')
                                            Verification Approved
                                        @else
                                            Verification Rejected
                                        @endif
                                    </h4>
                                    <p class="text-muted">
                                        @if($verificationRequest->status === 'pending')
                                            Submitted on {{ $verificationRequest->submitted_at->format('M d, Y') }}
                                        @elseif($verificationRequest->status === 'approved')
                                            Approved on {{ $verificationRequest->reviewed_at ? $verificationRequest->reviewed_at->format('M d, Y') : 'N/A' }}
                                        @else
                                            Rejected on {{ $verificationRequest->reviewed_at ? $verificationRequest->reviewed_at->format('M d, Y') : 'N/A' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="verification-details">
                                    <h5>Verification Request Details</h5>
                                    <hr>
                                    
                                    <div class="mb-3">
                                        <strong>Business Description:</strong>
                                        <p>{{ $verificationRequest->business_description }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Reason for Verification:</strong>
                                        <p>{{ $verificationRequest->reason_for_verification }}</p>
                                    </div>
                                    
                                    @if($verificationRequest->status === 'rejected')
                                    <div class="mb-3">
                                        <strong>Rejection Reason:</strong>
                                        <p class="text-danger">{{ $verificationRequest->rejection_reason }}</p>
                                    </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <strong>Submitted Documents:</strong>
                                        @if(is_array($verificationRequest->documents) && count($verificationRequest->documents) > 0)
                                            <div class="list-group mt-2">
                                                @foreach($verificationRequest->documents as $index => $document)
                                                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span>Document #{{ $index + 1 }}</span>
                                                        <a href="{{ Storage::url($document) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No documents available</p>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-4">
                                        @if($verificationRequest->status === 'pending')
                                            <div class="alert alert-warning">
                                                <i class="fas fa-info-circle"></i> Your verification request is being reviewed. This process may take 1-3 business days.
                                            </div>
                                        @elseif($verificationRequest->status === 'rejected')
                                            <a href="{{ route('seller.verification.apply') }}" class="btn btn-primary">Submit New Request</a>
                                        @endif
                                        <a href="{{ route('seller.panel') }}" class="btn btn-secondary">Back to Dashboard</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .verification-status-icon {
        margin: 20px 0;
    }
</style>
@endsection 