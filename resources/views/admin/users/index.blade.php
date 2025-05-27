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
    
    /* Target all SVG elements in pagination */
    .card-footer svg {
        width: 20px !important;
        height: 20px !important;
        max-width: 20px !important;
        max-height: 20px !important;
        overflow: visible !important;
    }
    
    /* Target the actual next/prev arrows */
    .card-footer [rel="next"] svg,
    .card-footer [rel="prev"] svg {
        width: 20px !important;
        height: 20px !important;
        max-width: 20px !important;
        max-height: 20px !important;
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
    
    /* Force reasonable size on pagination items */
    .card-footer .page-item {
        width: auto !important;
        height: auto !important;
        margin: 0 2px !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .card-footer .page-link {
        position: relative !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0.5rem 0.75rem !important;
        margin-left: -1px !important;
        line-height: 1.25 !important;
        color: #007bff !important;
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
        width: 40px !important;
        height: 40px !important;
        overflow: hidden !important;
    }
    
    .card-footer .page-item.active .page-link {
        z-index: 3 !important;
        color: #fff !important;
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    
    /* Custom fix for large arrow icons */
    .card-footer path {
        transform: scale(0.01) !important;
        transform-origin: center !important;
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
                    <h3 class="card-title">User Management</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Search users..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <select name="filter" class="form-control form-control-sm ml-2" onchange="this.form.submit()">
                                <option value="all" {{ request('filter') === 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Active Users</option>
                                <option value="suspended" {{ request('filter') === 'suspended' ? 'selected' : '' }}>Suspended Users</option>
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
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_suspended)
                                        <span class="badge badge-danger">Suspended</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                        </div>
                        <div class="pagination-controls">
                            @if ($users->onFirstPage())
                                <span class="custom-pagination-btn disabled">« Previous</span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="custom-pagination-btn">« Previous</a>
                            @endif

                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="custom-pagination-btn">Next »</a>
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

<script>
// Add this script to further fix the pagination arrows and their alignment
document.addEventListener('DOMContentLoaded', function() {
    // Nothing needed here since we're using custom pagination now
});
</script>
@endsection 