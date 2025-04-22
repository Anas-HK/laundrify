<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Earnings Dashboard - Laundrify</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerPanel.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('seller.panel') }}">
                <div class="logo-container">
                    <i class="fas fa-tshirt logo-icon"></i>
                    <span class="logo-text">Laundrify</span>
                </div>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Nav Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.panel') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('add.service') }}">
                            <i class="fas fa-plus-circle me-1"></i> Add Service
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('seller.earnings') }}">
                            <i class="fas fa-wallet me-1"></i> Earnings
                        </a>
                    </li>
                    @if(!Auth::guard('seller')->user()->is_verified)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.verification.apply') }}">
                            <i class="fas fa-certificate me-1"></i> Get Verified
                        </a>
                    </li>
                    @endif
                    
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::guard('seller')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form action="{{ route('logout.seller') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container dashboard-container">
            <!-- Section Title -->
            <div class="welcome-card animate__animated animate__fadeIn">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">Earnings Dashboard</h1>
                        <p class="welcome-text">Track your income and financial performance</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="fas fa-wallet welcome-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Earnings Summary Cards -->
            <div class="row stats-row">
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ number_format($allTimeEarnings['total']) }} PKR</h3>
                            <p class="stats-label">Total Earnings ({{ $allTimeEarnings['count'] }} orders)</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ number_format($currentPeriodEarnings['total']) }} PKR</h3>
                            <p class="stats-label">{{ ucfirst($period) }} Earnings ({{ $currentPeriodEarnings['count'] }} orders)</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">
                                @if($allTimeEarnings['count'] > 0)
                                    {{ number_format($allTimeEarnings['total'] / $allTimeEarnings['count']) }} PKR
                                @else
                                    0 PKR
                                @endif
                            </h3>
                            <p class="stats-label">Average Per Order</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Period Selector -->
            <div class="section-card animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-calendar"></i> Select Time Period
                    </h2>
                </div>
                <div class="section-body text-center">
                    <form action="{{ route('seller.earnings') }}" method="GET">
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <button type="submit" name="period" value="week" class="btn {{ $period == 'week' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                                <i class="fas fa-calendar-week me-2"></i>This Week
                            </button>
                            <button type="submit" name="period" value="month" class="btn {{ $period == 'month' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                                <i class="fas fa-calendar-alt me-2"></i>This Month
                            </button>
                            <button type="submit" name="period" value="year" class="btn {{ $period == 'year' ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                                <i class="fas fa-calendar me-2"></i>This Year
                            </button>
                            <button type="submit" name="period" value="all" class="btn {{ $period == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                <i class="fas fa-infinity me-2"></i>All Time
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Earnings Chart -->
            <div class="section-card animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-bar"></i> Earnings Trend
                    </h2>
                    <span class="text-muted">Last 6 Months</span>
                </div>
                <div class="section-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="earningsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Completed Orders -->
            <div class="section-card animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-clipboard-check"></i> Recent Completed Orders
                    </h2>
                </div>
                
                <div class="section-body">
                    @if($completedOrders->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>No completed orders found.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Services</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedOrders as $order)
                                        <tr>
                                            <td>
                                                <span class="fw-medium">#{{ $order->id }}</span>
                                            </td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="services-list">
                                                    @foreach($order->items as $item)
                                                        <div>
                                                            {{ $item->service->service_name }}
                                                            <span class="text-muted">
                                                                ({{ $item->quantity }} x {{ $item->price }} PKR)
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="fw-semibold">{{ number_format($order->total_amount) }} PKR</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $completedOrders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Laundrify. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize Chart.js
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('earningsChart').getContext('2d');
            
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($monthlyData)) !!},
                    datasets: [{
                        label: 'Monthly Earnings (PKR)',
                        data: {!! json_encode(array_values($monthlyData)) !!},
                        backgroundColor: 'rgba(78, 115, 223, 0.7)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toLocaleString() + ' PKR';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' PKR';
                                }
                            }
                        }
                    }
                }
            });
            
            // Enable all tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html> 