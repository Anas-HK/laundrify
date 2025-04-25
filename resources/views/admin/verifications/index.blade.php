@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Seller Verification Requests</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Verification Requests</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter by Status:</div>
                    <a class="dropdown-item {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('admin.verifications.index', ['status' => 'pending']) }}">Pending</a>
                    <a class="dropdown-item {{ $status === 'approved' ? 'active' : '' }}" href="{{ route('admin.verifications.index', ['status' => 'approved']) }}">Approved</a>
                    <a class="dropdown-item {{ $status === 'rejected' ? 'active' : '' }}" href="{{ route('admin.verifications.index', ['status' => 'rejected']) }}">Rejected</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item {{ $status === 'all' ? 'active' : '' }}" href="{{ route('admin.verifications.index', ['status' => 'all']) }}">All Requests</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Seller Name</th>
                            <th>Email</th>
                            <th>Submitted</th>
                            <th>Documents</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($verificationRequests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->seller->name }}</td>
                                <td>{{ $request->seller->email }}</td>
                                <td>{{ $request->submitted_at ? $request->submitted_at->format('M d, Y') : $request->created_at->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $docs = $request->documents;
                                        if (is_string($docs)) {
                                            $docs = json_decode($docs, true);
                                        }
                                        $docCount = is_array($docs) ? count($docs) : 0;
                                    @endphp
                                    <span class="badge bg-info">{{ $docCount }} Document(s)</span>
                                </td>
                                <td>
                                    @if($request->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($request->status === 'approved')
                                        <span class="badge badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.verifications.show', $request) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    
                                    @if($request->status === 'pending')
                                        <form action="{{ route('admin.verifications.approve', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $request->id }}">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                        
                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel">Reject Verification Request</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.verifications.reject', $request) }}" method="POST">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No verification requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $verificationRequests->links() }}
            </div>
        </div>
    </div>
</div>
@endsection