@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .analytics-card {
        border-radius: 8px;
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 20px;
        transition: transform 0.2s;
    }
    
    .analytics-card:hover {
        transform: translateY(-3px);
    }
    
    .analytics-card .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .analytics-card .card-header i {
        margin-right: 10px;
    }
    
    .stat-card {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card.primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
        color: white;
    }
    
    .stat-card.success {
        background: linear-gradient(45deg, #1cc88a, #13855c);
        color: white;
    }
    
    .stat-card.info {
        background: linear-gradient(45deg, #36b9cc, #258391);
        color: white;
    }
    
    .stat-card.warning {
        background: linear-gradient(45deg, #f6c23e, #dda20a);
        color: white;
    }
    
    .stat-card.danger {
        background: linear-gradient(45deg, #e74a3b, #be2617);
        color: white;
    }
    
    .stat-card .stat-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 2rem;
        opacity: 0.2;
    }
    
    .stat-card .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .stat-card .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
        color: rgba(255, 255, 255, 1);
        font-weight: 600;
    }
    
    .stat-card .stat-change {
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 10px;
        margin-top: 5px;
        display: inline-block;
    }
    
    .stat-card .stat-change.positive {
        background-color: rgba(28, 200, 138, 0.2);
    }
    
    .stat-card .stat-change.negative {
        background-color: rgba(231, 74, 59, 0.2);
    }
    
    .date-filter {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 20px;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .data-table th, .data-table td {
        white-space: nowrap;
    }

    .metric-card .metric-label {
        color: #2e384d;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .metric-card .metric-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #4e73df;
        margin-bottom: 5px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Date Range Filter -->
    <div class="date-filter mb-4">
        <form action="{{ route('admin.analytics.index') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="date_range" class="form-label">Date Range</label>
                <select id="date_range" name="date_range" class="form-select" onchange="this.form.submit()">
                    <option value="7days" {{ $dateRange == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30days" {{ $dateRange == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90days" {{ $dateRange == '90days' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="quarter" {{ $dateRange == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                    <option value="year" {{ $dateRange == 'year' ? 'selected' : '' }}>This Year</option>
                    <option value="all" {{ $dateRange == 'all' ? 'selected' : '' }}>All Time</option>
                </select>
            </div>
        </form>
    </div>
    
    <!-- Summary Stats -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ number_format($metrics['totalUsers']) }}</div>
                <div class="stat-label">Total Users</div>
                @php
                    $userChange = $previousMetrics['totalUsers'] > 0 
                        ? (($metrics['totalUsers'] - $previousMetrics['totalUsers']) / $previousMetrics['totalUsers']) * 100 
                        : 100;
                @endphp
                <div class="stat-change {{ $userChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $userChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs(number_format($userChange, 1)) }}%
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-value">{{ number_format($metrics['totalSellers']) }}</div>
                <div class="stat-label">Total Sellers</div>
                @php
                    $sellerChange = $previousMetrics['totalSellers'] > 0 
                        ? (($metrics['totalSellers'] - $previousMetrics['totalSellers']) / $previousMetrics['totalSellers']) * 100 
                        : 100;
                @endphp
                <div class="stat-change {{ $sellerChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $sellerChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs(number_format($sellerChange, 1)) }}%
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ number_format($metrics['totalOrders']) }}</div>
                <div class="stat-label">Total Orders</div>
                @php
                    $orderChange = $previousMetrics['totalOrders'] > 0 
                        ? (($metrics['totalOrders'] - $previousMetrics['totalOrders']) / $previousMetrics['totalOrders']) * 100 
                        : 100;
                @endphp
                <div class="stat-change {{ $orderChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $orderChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs(number_format($orderChange, 1)) }}%
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-icon">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-value">{{ number_format($metrics['totalRevenue']) }}</div>
                <div class="stat-label">Total Revenue (PKR)</div>
                @php
                    $revenueChange = $previousMetrics['totalRevenue'] > 0 
                        ? (($metrics['totalRevenue'] - $previousMetrics['totalRevenue']) / $previousMetrics['totalRevenue']) * 100 
                        : 100;
                @endphp
                <div class="stat-change {{ $revenueChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-{{ $revenueChange >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ abs(number_format($revenueChange, 1)) }}%
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Daily Active Users
                    </h6>
                    <a href="{{ route('admin.analytics.users', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="userActivityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-chart-bar"></i> Daily Revenue
                    </h6>
                    <a href="{{ route('admin.analytics.financial', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-pie"></i> Order Status Distribution
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-chart-line"></i> Retention Rates
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <h4 class="text-primary">{{ number_format($metrics['userRetentionRate'], 1) }}%</h4>
                            <p class="text-muted">User Retention</p>
                        </div>
                        <div class="text-center">
                            <h4 class="text-success">{{ number_format($metrics['sellerRetentionRate'], 1) }}%</h4>
                            <p class="text-muted">Seller Retention</p>
                        </div>
                    </div>
                    <p class="text-center mt-3 mb-0">
                        <small class="text-muted">
                            Retention rate measures the percentage of users/sellers who remain active in the selected period.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="row">
        <div class="col-12">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table"></i> Analytics Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <h6 class="text-muted">New Users</h6>
                                <h3>{{ number_format($metrics['newUsers']) }}</h3>
                                <a href="{{ route('admin.analytics.users', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-outline-primary mt-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <h6 class="text-muted">New Sellers</h6>
                                <h3>{{ number_format($metrics['newSellers']) }}</h3>
                                <a href="{{ route('admin.analytics.sellers', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-outline-info mt-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <h6 class="text-muted">Avg. Order Value</h6>
                                <h3>{{ number_format($metrics['avgOrderValue'], 2) }} PKR</h3>
                                <a href="{{ route('admin.analytics.financial', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-outline-success mt-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center mb-4">
                                <h6 class="text-muted">Services</h6>
                                <h3>{{ number_format(App\Models\Service::count()) }}</h3>
                                <a href="{{ route('admin.analytics.services', ['date_range' => $dateRange]) }}" class="btn btn-sm btn-outline-warning mt-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart.js global settings
        Chart.defaults.font.family = "'Poppins', 'Helvetica', 'Arial', sans-serif";
        Chart.defaults.color = '#858796';
        
        // User Activity Chart
        const userActivityData = {
            labels: {!! json_encode(array_keys($metrics['dailyActiveUsers'])) !!},
            datasets: [{
                label: 'Active Users',
                data: {!! json_encode(array_values($metrics['dailyActiveUsers'])) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.2)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: '#fff',
                tension: 0.3
            }]
        };
        
        new Chart(document.getElementById('userActivityChart'), {
            type: 'line',
            data: userActivityData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgb(255, 255, 255)',
                        bodyColor: '#858796',
                        titleColor: '#6e707e',
                        titleMarginBottom: 10,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false
                    }
                }
            }
        });
        
        // Revenue Chart
        const revenueData = {
            labels: {!! json_encode(array_keys($metrics['dailyRevenue'])) !!},
            datasets: [{
                label: 'Revenue (PKR)',
                data: {!! json_encode(array_values($metrics['dailyRevenue'])) !!},
                backgroundColor: 'rgba(28, 200, 138, 0.2)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                pointBorderColor: '#fff',
                pointHoverRadius: 5,
                pointHoverBackgroundColor: 'rgba(28, 200, 138, 1)',
                pointHoverBorderColor: '#fff',
                tension: 0.3
            }]
        };
        
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: revenueData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' PKR';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgb(255, 255, 255)',
                        bodyColor: '#858796',
                        titleColor: '#6e707e',
                        titleMarginBottom: 10,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.raw.toLocaleString() + ' PKR';
                            }
                        }
                    }
                }
            }
        });
        
        // Order Status Chart
        const statusLabels = Object.keys({!! json_encode($metrics['orderStatusCounts']) !!});
        const statusData = Object.values({!! json_encode($metrics['orderStatusCounts']) !!});
        
        const statusColors = [
            'rgba(78, 115, 223, 0.8)',  // Blue
            'rgba(28, 200, 138, 0.8)',  // Green
            'rgba(246, 194, 62, 0.8)',  // Yellow
            'rgba(231, 74, 59, 0.8)',   // Red
            'rgba(54, 185, 204, 0.8)',  // Cyan
            'rgba(133, 135, 150, 0.8)', // Gray
        ];
        
        new Chart(document.getElementById('orderStatusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: statusColors,
                    hoverBackgroundColor: statusColors.map(color => color.replace('0.8', '1')),
                    hoverBorderColor: 'rgba(234, 236, 244, 1)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgb(255, 255, 255)',
                        bodyColor: '#858796',
                        titleColor: '#6e707e',
                        titleMarginBottom: 10,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        padding: 15,
                        displayColors: false
                    }
                }
            }
        });
    });
</script>
@endsection 