@extends('admin.layouts.app')

@section('styles')
<style>
    /* Complete pagination reset */
    .card-footer .pagination {
        display: flex !important;
        padding-left: 0 !important;
        list-style: none !important;
        border-radius: 0.25rem !important;
        width: auto !important;
        max-width: 100% !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    /* Force small size on pagination nav container */
    .card-footer nav {
        width: 100% !important;
        max-width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 0 auto !important;
    }
    
    /* Fix for card footer alignment */
    .card-footer {
        text-align: center !important;
        padding: 1rem !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
    
    /* Add new styles for pagination result text and controls alignment */
    .pagination-container {
        width: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        gap: 10px !important;
    }
    
    .pagination-info {
        width: 100% !important;
        text-align: center !important;
        margin-bottom: 10px !important;
        font-size: 14px !important;
    }
    
    .pagination-controls {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        gap: 15px !important;
    }
    
    /* Custom navigation button styles */
    .custom-pagination-btn {
        padding: 8px 15px !important;
        border: 1px solid #dee2e6 !important;
        background-color: #fff !important;
        color: #007bff !important;
        border-radius: 4px !important;
        font-size: 14px !important;
        cursor: pointer !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .custom-pagination-btn:hover {
        background-color: #f8f9fa !important;
    }
    
    .custom-pagination-btn.disabled {
        color: #6c757d !important;
        pointer-events: none !important;
        cursor: default !important;
        opacity: 0.65 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Seller Management</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.sellers.index') }}" method="GET" class="d-flex">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Search sellers..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <select name="filter" class="form-control form-control-sm ml-2" onchange="this.form.submit()">
                                <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>All Sellers</option>
                                <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Active Sellers</option>
                                <option value="suspended" {{ request('filter') === 'suspended' ? 'selected' : '' }}>Suspended Sellers</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Approval</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sellers as $seller)
                            <tr>
                                <td>{{ $seller->id }}</td>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>
                                    @if($seller->is_suspended)
                                        <span class="badge badge-danger">Suspended</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if($seller->accountIsApproved == 1)
                                        <span class="badge badge-info">Approved</span>
                                    @elseif($seller->is_deleted == 1)
                                        <span class="badge badge-warning">Rejected</span>
                                    @else
                                        <span class="badge badge-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $seller->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" style="gap: 5px; display: flex;">
                                        <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fas fa-sign-in-alt"></i> Login
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No sellers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }} of {{ $sellers->total() }} results
                        </div>
                        <div class="pagination-controls">
                            @if ($sellers->onFirstPage())
                                <span class="custom-pagination-btn disabled">« Previous</span>
                            @else
                                <a href="{{ $sellers->previousPageUrl() }}" class="custom-pagination-btn">« Previous</a>
                            @endif

                            @if ($sellers->hasMorePages())
                                <a href="{{ $sellers->nextPageUrl() }}" class="custom-pagination-btn">Next »</a>
                            @else
                                <span class="custom-pagination-btn disabled">Next »</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 