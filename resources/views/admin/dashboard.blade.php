@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> --}}
        <a href="#" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50 me-1"></i> Generate Report
        </a>
    </div>

    <!-- Dashboard Summary -->
    <div class="row dashboard-summary mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card primary h-100">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ count($sellers) }}</div>
                        <div class="stat-label">Total Sellers</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card warning h-100">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ count($pendingSellers) }}</div>
                        <div class="stat-label">Pending Verifications</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card success h-100">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ count($pendingServices) }}</div>
                        <div class="stat-label">Pending Services</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card danger h-100">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="stat-value">{{ count($sellers) > 0 ? number_format(count($pendingSellers) / count($sellers) * 100, 1) : 0 }}%</div>
                        <div class="stat-label">Approval Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Verifications Panel -->
        <div class="col-lg-6 mb-4">
            <div class="data-card h-100">
                <div class="data-card-header">
                    <h5 class="data-card-title">
                        <i class="fas fa-user-check text-warning me-2"></i>Pending Seller Verifications
                    </h5>
                    <a href="{{ route('admin.verifications.index') }}" class="data-card-action">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="data-card-body">
                    @if(count($pendingSellers) > 0)
                        <ul class="seller-list">
                            @foreach($pendingSellers as $seller)
                            <li class="seller-item">
                                <div class="seller-avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($seller->name) }}&background=4e73df&color=fff" alt="{{ $seller->name }}">
                                </div>
                                <div class="seller-info">
                                    <h6 class="seller-name">{{ $seller->name }}</h6>
                                    <p class="seller-email">{{ $seller->email }}</p>
                                </div>
                                <div class="ms-auto d-flex align-items-center">
                                    <span class="status-badge status-pending me-3">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                    <div class="d-flex">
                                        <form action="{{ route('admin.approveSeller', $seller->id) }}" method="POST" class="me-2 approval-form approve-form" data-entity-type="Seller">
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
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="data-card-empty">
                            <i class="fas fa-check-circle"></i>
                            <p>No pending verifications</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Pending Services Panel -->
        <div class="col-lg-6 mb-4">
            <div class="data-card h-100">
                <div class="data-card-header">
                    <h5 class="data-card-title">
                        <i class="fas fa-box-open text-info me-2"></i>Pending Services
                    </h5>
                    <a href="{{ route('admin.services') }}" class="data-card-action">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="data-card-body">
                    @if(count($pendingServices) > 0)
                        <div class="table-responsive">
                            <table class="admin-table w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service Name</th>
                                        <th>Seller</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingServices as $service)
                                    <tr>
                                        <td class="table-id">#{{ $service->id }}</td>
                                        <td>{{ $service->service_name }}</td>
                                        <td>{{ $service->seller ? $service->seller->name : 'N/A' }}</td>
                                        <td>{{ number_format($service->service_price, 2) }} PKR</td>
                                        <td>
                                            <div class="d-flex">
                                                <form action="{{ route('admin.approveService', $service->id) }}" method="POST" class="me-2 approval-form approve-form" data-entity-type="Service">
                                                    @csrf
                                                    <button type="submit" class="action-btn approve" data-bs-toggle="tooltip" title="Approve Service">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.rejectService', $service->id) }}" method="POST" class="approval-form reject-form" data-entity-type="Service">
                                                    @csrf
                                                    <button type="submit" class="action-btn reject" data-bs-toggle="tooltip" title="Reject Service">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="data-card-empty">
                            <i class="fas fa-check-circle"></i>
                            <p>No pending services</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Registered Sellers Table -->
    <div class="row">
        <div class="col-12">
            <div class="data-card">
                <div class="data-card-header">
                    <h5 class="data-card-title">
                        <i class="fas fa-store text-primary me-2"></i>Registered Sellers
                    </h5>
                    <a href="{{ route('admin.sellers') }}" class="data-card-action">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="data-card-body">
                    @if(count($sellers) > 0)
                        <div class="table-responsive">
                            <table class="admin-table w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Shop/Service</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sellers->take(5) as $seller)
                                    <tr>
                                        <td class="table-id">#{{ $seller->id }}</td>
                                        <td>{{ $seller->name }}</td>
                                        <td>{{ $seller->email }}</td>
                                        <td>{{ $seller->business_name ?? 'N/A' }}</td>
                                        <td>{{ $seller->created_at->diffForHumans() }}</td>
                                        <td>
                                            <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="action-btn view" data-bs-toggle="tooltip" title="Login as Seller">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="data-card-empty">
                            <i class="fas fa-store-slash"></i>
                            <p>No registered sellers yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Generate a report function
    function generateReport() {
        toast.info('Generating report...', 'Report');
        
        // Simulate report generation
        setTimeout(() => {
            toast.success('Report generated successfully!', 'Report');
        }, 2000);
    }
</script>
@endsection