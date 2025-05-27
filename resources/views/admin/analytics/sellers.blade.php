@extends('admin.layouts.app')

@section('title', 'Seller Analytics')

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
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .data-table th, .data-table td {
        white-space: nowrap;
    }
    
    .date-filter {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 20px;
    }
    
    .metric-card {
        padding: 20px;
        border-radius: 8px;
        background-color: white;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 20px;
        text-align: center;
    }
    
    .metric-card .metric-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #4e73df;
        margin-bottom: 5px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }
    
    .metric-card .metric-label {
        color: #2e384d;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .back-button {
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.analytics.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Back to Analytics Dashboard
        </a>
    </div>
    
    <!-- Date Range Filter -->
    <div class="date-filter mb-4">
        <form action="{{ route('admin.analytics.sellers') }}" method="GET" class="row g-3 align-items-center">
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
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-value">{{ number_format($analytics['totalSellers']) }}</div>
                <div class="metric-label">Total Sellers</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-value">{{ number_format($analytics['newSellers']) }}</div>
                <div class="metric-label">New Sellers</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-value">{{ number_format($analytics['activeSellers']) }}</div>
                <div class="metric-label">Active Sellers</div>
            </div>
        </div>
    </div>
    
    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Seller Registrations
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="registrationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-chart-pie"></i> Sellers by City
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="sellersByCityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-trophy"></i> Top Performing Sellers
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-right">Revenue (PKR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analytics['topSellers'] as $seller)
                                <tr>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td class="text-right">{{ number_format($seller->total_revenue) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6">
            <div class="card analytics-card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-store"></i> Sellers with Most Services
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-right">Services</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($analytics['sellersWithMostServices'] as $seller)
                                <tr>
                                    <td>{{ $seller->name }}</td>
                                    <td class="text-right">{{ $seller->service_count }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        
        // Seller Registrations Chart
        const registrationsData = {
            labels: {!! json_encode(array_keys($analytics['registrationsByDay'])) !!},
            datasets: [{
                label: 'New Sellers',
                data: {!! json_encode(array_values($analytics['registrationsByDay'])) !!},
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
        
        new Chart(document.getElementById('registrationsChart'), {
            type: 'line',
            data: registrationsData,
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
        
        // Sellers by City Chart
        const cityLabels = Object.keys({!! json_encode($analytics['sellersByCity']) !!});
        const cityData = Object.values({!! json_encode($analytics['sellersByCity']) !!});
        
        const cityColors = [
            'rgba(78, 115, 223, 0.8)',  // Blue
            'rgba(28, 200, 138, 0.8)',  // Green
            'rgba(246, 194, 62, 0.8)',  // Yellow
            'rgba(231, 74, 59, 0.8)',   // Red
            'rgba(54, 185, 204, 0.8)',  // Cyan
            'rgba(133, 135, 150, 0.8)', // Gray
            'rgba(105, 48, 195, 0.8)',  // Purple
            'rgba(244, 67, 54, 0.8)',   // Deep Red
            'rgba(76, 175, 80, 0.8)',   // Deep Green
            'rgba(255, 152, 0, 0.8)',   // Orange
        ];
        
        new Chart(document.getElementById('sellersByCityChart'), {
            type: 'doughnut',
            data: {
                labels: cityLabels,
                datasets: [{
                    data: cityData,
                    backgroundColor: cityColors,
                    hoverBackgroundColor: cityColors.map(color => color.replace('0.8', '1')),
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