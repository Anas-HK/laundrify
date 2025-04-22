@extends('admin.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/adminDashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid py-4">
    <h1 class="page-title">Verification Request Details</h1>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Seller Information -->
        <div class="col-lg-8">
            <div class="data-card mb-4">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-user-check"></i> Seller Information
                    </h2>
                    <div>
                        <span class="status-badge status-{{ strtolower($verification->status) }}">
                            <i class="fas fa-{{ $verification->status == 'PENDING' ? 'clock' : ($verification->status == 'APPROVED' ? 'check-circle' : 'times-circle') }}"></i>
                            {{ $verification->status }}
                        </span>
                    </div>
                </div>
                <div class="data-card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Seller Name</label>
                                <div class="fw-bold">{{ $verification->seller->name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Business Name</label>
                                <div class="fw-bold">{{ $verification->business_name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Tax ID / Business Registration</label>
                                <div class="fw-bold">{{ $verification->tax_id }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Email</label>
                                <div class="fw-bold">{{ $verification->seller->email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Phone</label>
                                <div class="fw-bold">{{ $verification->phone }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small mb-1">Address</label>
                                <div class="fw-bold">{{ $verification->address }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small mb-1">Business Description</label>
                        <div class="p-3 bg-light rounded">
                            {{ $verification->description }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small mb-1">Supporting Documents</label>
                        <div class="row">
                            @if($verification->document_paths)
                                @foreach(json_decode($verification->document_paths) as $index => $path)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $path) }}" alt="Document {{ $index + 1 }}" class="card-img-top" style="max-height: 150px; object-fit: cover;">
                                            <a href="{{ asset('storage/' . $path) }}" target="_blank" class="position-absolute top-0 end-0 m-2 bg-light rounded-circle p-1">
                                                <i class="fas fa-expand text-primary"></i>
                                            </a>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <small class="text-muted">Document {{ $index + 1 }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i> No documents uploaded
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($verification->status == 'PENDING')
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times-circle me-1"></i> Reject
                        </button>
                        <form action="{{ route('admin.verifications.approve', $verification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-1"></i> Approve
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="col-lg-4">
            <div class="data-card">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-history"></i> Timeline
                    </h2>
                </div>
                <div class="data-card-body p-0">
                    <div class="p-3">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title mb-1">Request Submitted</h5>
                                    <div class="timeline-date text-muted small">{{ $verification->created_at->format('M d, Y h:i A') }}</div>
                                    <p class="mb-0 mt-2 text-muted small">Verification request submitted by seller.</p>
                                </div>
                            </div>

                            @if($verification->status != 'PENDING')
                            <div class="timeline-item">
                                <div class="timeline-marker {{ $verification->status == 'APPROVED' ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas fa-{{ $verification->status == 'APPROVED' ? 'check' : 'times' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5 class="timeline-title mb-1">Request {{ $verification->status }}</h5>
                                    <div class="timeline-date text-muted small">{{ $verification->updated_at->format('M d, Y h:i A') }}</div>
                                    <p class="mb-0 mt-2 text-muted small">
                                        @if($verification->status == 'APPROVED')
                                            Verification request was approved
                                        @else
                                            Verification request was rejected. Reason: {{ $verification->rejection_reason }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Verification Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.verifications.reject', $verification->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for rejection</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                        <div class="form-text">This message will be visible to the seller.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        width: 1.5rem;
        height: 1.5rem;
        left: -1.5rem;
        top: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
    }
    
    .timeline-content {
        padding-left: 0.5rem;
    }
    
    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
</style>
@endsection 