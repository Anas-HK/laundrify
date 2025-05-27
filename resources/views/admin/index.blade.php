@extends('admin.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/adminDashboard.css') }}">
@endsection

@section('content')
<div class="container-fluid py-4">
    <h1 class="page-title">Admin Dashboard</h1>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <div>
                        <h3 class="stat-value">{{ $totalUsers }}</h3>
                        <p class="stat-label">Total Users</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-store text-success"></i>
                    </div>
                    <div>
                        <h3 class="stat-value">{{ $totalSellers }}</h3>
                        <p class="stat-label">Total Sellers</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-shopping-cart text-info"></i>
                    </div>
                    <div>
                        <h3 class="stat-value">{{ $totalOrders }}</h3>
                        <p class="stat-label">Total Orders</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="summary-card">
                <div class="summary-card-body">
                    <div class="summary-card-icon">
                        <i class="fas fa-money-bill-wave text-warning"></i>
                    </div>
                    <div>
                        <h3 class="stat-value">{{ number_format($totalRevenue, 2) }} PKR</h3>
                        <p class="stat-label">Total Revenue</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row">
        <!-- Orders Chart -->
        <div class="col-lg-8 mb-4">
            <div class="data-card">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-chart-line me-2"></i> Orders Overview
                    </h2>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="orderChartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Last 7 Days
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="orderChartDropdown">
                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="data-card-body">
                    <div class="chart-container">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Requests -->
        <div class="col-lg-4 mb-4">
            <div class="data-card">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-user-check me-2"></i> Verification Requests
                    </h2>
                    <a href="{{ route('admin.verifications.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="data-card-body p-0">
                    @if(count($pendingVerifications) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($pendingVerifications as $verification)
                        <a href="{{ route('admin.verifications.show', $verification->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $verification->business_name }}</h6>
                                    <p class="mb-1 text-muted small">{{ $verification->seller->name }}</p>
                                </div>
                                <span class="badge bg-warning text-dark">Pending</span>
                            </div>
                            <small class="text-muted">Submitted {{ $verification->created_at->diffForHumans() }}</small>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 text-center">
                        <i class="fas fa-check-circle text-success mb-3" style="font-size: 2rem;"></i>
                        <p class="mb-0">No pending verification requests</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="data-card">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-shopping-bag me-2"></i> Recent Orders
                    </h2>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="data-card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($order->status) }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-4 mb-4">
            <div class="data-card">
                <div class="data-card-header">
                    <h2 class="data-card-title">
                        <i class="fas fa-user-plus me-2"></i> New Users
                    </h2>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="data-card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                        <a href="{{ route('admin.users.show', $user->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <p class="mb-0 text-muted small">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Orders Chart
    const ordersChart = document.getElementById('ordersChart');
    
    new Chart(ordersChart, {
        type: 'line',
        data: {
            labels: {!! json_encode($orderChartLabels) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($orderChartData) !!},
                borderColor: 'rgba(78, 115, 223, 1)',
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            maintainAspectRatio: false,
            responsive: true
        }
    });
</script>
@endsection 