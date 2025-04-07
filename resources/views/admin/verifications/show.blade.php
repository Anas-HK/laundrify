@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verification Request Details</h1>
        <a href="{{ route('admin.verifications.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Seller Information -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Seller Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($verification->seller->profile_image)
                            <img class="img-profile rounded-circle mb-3" src="{{ Storage::url($verification->seller->profile_image) }}" width="100" height="100">
                        @else
                            <i class="fas fa-user-circle fa-5x mb-3 text-gray-300"></i>
                        @endif
                        <h5>{{ $verification->seller->name }}</h5>
                        <div class="text-muted">{{ $verification->seller->email }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>City:</strong> {{ $verification->seller->city ?? 'Not specified' }}
                    </div>
                    <div class="mb-3">
                        <strong>Area:</strong> {{ $verification->seller->area ?? 'Not specified' }}
                    </div>
                    <div class="mb-3">
                        <strong>Joined:</strong> {{ $verification->seller->created_at->format('M d, Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>Account Status:</strong>
                        @if($verification->seller->accountIsApproved)
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Services:</strong> {{ $verification->seller->services->count() }}
                    </div>
                    
                    <a href="#" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-user fa-sm"></i> View Seller Profile
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Verification Request Details -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Request Details</h6>
                    <div>
                        <span class="mr-2">
                            @if($verification->status === 'pending')
                                <span class="badge badge-warning">Pending Review</span>
                            @elseif($verification->status === 'approved')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </span>
                        <span class="font-weight-bold text-primary small">ID: #{{ $verification->id }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Business Description</h5>
                        <p>{{ $verification->business_description }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Reason for Verification</h5>
                        <p>{{ $verification->reason_for_verification }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Supporting Documents</h5>
                        <div class="row">
                            @foreach($verification->documents as $index => $document)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Document #{{ $index + 1 }}</h6>
                                            <a href="{{ Storage::url($document) }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View Document
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    @if($verification->status === 'rejected')
                        <div class="mb-4">
                            <h5 class="font-weight-bold text-danger">Rejection Reason</h5>
                            <p>{{ $verification->rejection_reason }}</p>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Timeline</h5>
                        <ul class="timeline">
                            <li>
                                <div class="timeline-badge success"><i class="fas fa-paper-plane"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Request Submitted</h6>
                                        <p><small class="text-muted"><i class="fas fa-clock"></i> {{ $verification->submitted_at->format('M d, Y h:i A') }}</small></p>
                                    </div>
                                </div>
                            </li>
                            
                            @if($verification->reviewed_at)
                                <li class="timeline-inverted">
                                    <div class="timeline-badge {{ $verification->status === 'approved' ? 'success' : 'danger' }}">
                                        <i class="{{ $verification->status === 'approved' ? 'fas fa-check' : 'fas fa-times' }}"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h6 class="timeline-title">Request {{ ucfirst($verification->status) }}</h6>
                                            <p><small class="text-muted"><i class="fas fa-clock"></i> {{ $verification->reviewed_at->format('M d, Y h:i A') }}</small></p>
                                        </div>
                                        <div class="timeline-body">
                                            @if($verification->status === 'rejected')
                                                <p>{{ $verification->rejection_reason }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    @if($verification->status === 'pending')
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <form action="{{ route('admin.verifications.approve', $verification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i> Approve Verification
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times"></i> Reject Verification
                                </button>
                            </div>
                        </div>
                        
                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel">Reject Verification Request</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.verifications.reject', $verification) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="rejection_reason">Reason for Rejection</label>
                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                                                <small class="form-text text-muted">This will be shown to the seller.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject Request</button>
                                        </div>
                                    </form>
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
.timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
}

.timeline:before {
    top: 0;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 3px;
    background-color: #eeeeee;
    left: 50%;
    margin-left: -1.5px;
}

.timeline > li {
    margin-bottom: 20px;
    position: relative;
}

.timeline > li:before,
.timeline > li:after {
    content: " ";
    display: table;
}

.timeline > li:after {
    clear: both;
}

.timeline > li > .timeline-panel {
    width: 46%;
    float: left;
    border: 1px solid #d4d4d4;
    border-radius: 2px;
    padding: 20px;
    position: relative;
    -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}

.timeline > li > .timeline-panel:before {
    position: absolute;
    top: 26px;
    right: -15px;
    display: inline-block;
    border-top: 15px solid transparent;
    border-left: 15px solid #ccc;
    border-right: 0 solid #ccc;
    border-bottom: 15px solid transparent;
    content: " ";
}

.timeline > li > .timeline-panel:after {
    position: absolute;
    top: 27px;
    right: -14px;
    display: inline-block;
    border-top: 14px solid transparent;
    border-left: 14px solid #fff;
    border-right: 0 solid #fff;
    border-bottom: 14px solid transparent;
    content: " ";
}

.timeline > li > .timeline-badge {
    color: #fff;
    width: 50px;
    height: 50px;
    line-height: 50px;
    font-size: 1.4em;
    text-align: center;
    position: absolute;
    top: 16px;
    left: 50%;
    margin-left: -25px;
    background-color: #999999;
    z-index: 100;
    border-top-right-radius: 50%;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-bottom-left-radius: 50%;
}

.timeline > li.timeline-inverted > .timeline-panel {
    float: right;
}

.timeline > li.timeline-inverted > .timeline-panel:before {
    border-left-width: 0;
    border-right-width: 15px;
    left: -15px;
    right: auto;
}

.timeline > li.timeline-inverted > .timeline-panel:after {
    border-left-width: 0;
    border-right-width: 14px;
    left: -14px;
    right: auto;
}

.timeline-badge.primary {
    background-color: #2e6da4 !important;
}

.timeline-badge.success {
    background-color: #3f903f !important;
}

.timeline-badge.warning {
    background-color: #f0ad4e !important;
}

.timeline-badge.danger {
    background-color: #d9534f !important;
}

.timeline-badge.info {
    background-color: #5bc0de !important;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body > p,
.timeline-body > ul {
    margin-bottom: 0;
}

.timeline-body > p + p {
    margin-top: 5px;
}
</style>
@endsection 