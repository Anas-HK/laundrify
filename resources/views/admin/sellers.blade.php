@extends('admin.layouts.app')

@section('title', 'Manage Sellers')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Sellers</h1>
        <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Sellers</li>
        </ol>
    </div>
    
    <!-- Sellers Card -->
    <div class="data-card">
        <div class="data-card-header">
            <h5 class="data-card-title">
                <i class="fas fa-store text-primary me-2"></i>All Sellers
            </h5>
            <div class="d-flex gap-2">
                <form class="input-group" style="width: 250px;">
                    <input type="text" class="form-control form-control-sm" placeholder="Search sellers..." name="search">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="data-card-body">
            @if($sellers->isEmpty())
                <div class="data-card-empty">
                    <i class="fas fa-store-slash"></i>
                    <p>No sellers available at the moment.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="admin-table w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Business</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sellers as $seller)
                                <tr>
                                    <td class="table-id">#{{ $seller->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="seller-avatar me-2" style="width: 32px; height: 32px;">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($seller->name) }}&background=4e73df&color=fff" alt="{{ $seller->name }}" class="rounded-circle">
                                            </div>
                                            {{ $seller->name }}
                                        </div>
                                    </td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->business_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($seller->accountIsApproved == 1)
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-check-circle"></i> Approved
                                            </span>
                                        @elseif($seller->is_deleted == 1)
                                            <span class="status-badge status-cancelled">
                                                <i class="fas fa-ban"></i> Rejected
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $seller->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="action-btn view" data-bs-toggle="tooltip" title="Login as Seller">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </button>
                                            </form>
                                            
                                            @if($seller->accountIsApproved == 0 && $seller->is_deleted == 0)
                                                <form action="{{ route('admin.approveSeller', $seller->id) }}" method="POST" class="approval-form approve-form" data-entity-type="Seller">
                                                    @csrf
                                                    <button type="submit" class="action-btn approve" data-bs-toggle="tooltip" title="Approve Seller">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.rejectSeller', $seller->id) }}" method="POST" class="approval-form reject-form" data-entity-type="Seller">
                                                    @csrf
                                                    <button type="submit" class="action-btn reject" data-bs-toggle="tooltip" title="Reject Seller">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(method_exists($sellers, 'hasPages') && $sellers->hasPages())
                <div class="d-flex justify-content-end mt-4">
                    {{ $sellers->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection