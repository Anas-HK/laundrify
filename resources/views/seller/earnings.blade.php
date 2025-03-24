<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Earnings Dashboard - Laundrify</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005f73;
            padding: 20px;
            color: #fff;
        }

        .header-container h1 {
            margin: 0;
            font-size: 24px;
        }

        .seller-nav {
            display: flex;
            gap: 10px;
        }

        .seller-nav .nav-btn {
            padding: 10px 15px;
            color: #fff;
            background-color: #0a9396;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .seller-nav .nav-btn:hover {
            background-color: #94d2bd;
        }

        .seller-nav .logout-btn {
            background-color: #ee9b00;
        }

        .seller-nav .logout-btn:hover {
            background-color: #ca6702;
        }

        .earnings-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .earnings-card:hover {
            transform: translateY(-5px);
        }

        .total-earnings {
            font-size: 32px;
            font-weight: bold;
            color: #0a9396;
        }

        .period-selector {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            gap: 10px;
        }

        .period-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 20px;
            background-color: #f0f0f0;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .period-btn:hover {
            background-color: #e0e0e0;
        }

        .period-btn.active {
            background-color: #005f73;
            color: white;
        }

        .chart-container {
            height: 300px;
            margin-top: 30px;
        }

        .table th {
            background-color: #005f73;
            color: white;
        }

        .orders-table {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .back-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Earnings Dashboard</h1>
            <nav class="seller-nav">
                <a href="{{ route('seller.panel') }}" class="nav-btn">Back to Dashboard</a>
                <form id="logout-form" action="{{ route('logout.seller') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn logout-btn">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="container py-4">
        <div class="row">
            <!-- Earnings Summary Cards -->
            <div class="col-md-4">
                <div class="earnings-card text-center">
                    <h4>Total Earnings</h4>
                    <div class="total-earnings">{{ number_format($allTimeEarnings['total']) }} PKR</div>
                    <p>From {{ $allTimeEarnings['count'] }} completed orders</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="earnings-card text-center">
                    <h4>{{ ucfirst($period) }} Earnings</h4>
                    <div class="total-earnings">{{ number_format($currentPeriodEarnings['total']) }} PKR</div>
                    <p>From {{ $currentPeriodEarnings['count'] }} completed orders</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="earnings-card text-center">
                    <h4>Average Per Order</h4>
                    <div class="total-earnings">
                        @if($allTimeEarnings['count'] > 0)
                            {{ number_format($allTimeEarnings['total'] / $allTimeEarnings['count']) }} PKR
                        @else
                            0 PKR
                        @endif
                    </div>
                    <p>Based on all completed orders</p>
                </div>
            </div>
        </div>

        <!-- Period Selector -->
        <div class="period-selector">
            <form action="{{ route('seller.earnings') }}" method="GET" class="d-flex gap-2">
                <button type="submit" name="period" value="week" class="period-btn {{ $period == 'week' ? 'active' : '' }}">This Week</button>
                <button type="submit" name="period" value="month" class="period-btn {{ $period == 'month' ? 'active' : '' }}">This Month</button>
                <button type="submit" name="period" value="year" class="period-btn {{ $period == 'year' ? 'active' : '' }}">This Year</button>
                <button type="submit" name="period" value="all" class="period-btn {{ $period == 'all' ? 'active' : '' }}">All Time</button>
            </form>
        </div>

        <!-- Earnings Chart -->
        <div class="earnings-card">
            <h3 class="text-center mb-4">Earnings Trend (Last 6 Months)</h3>
            <div class="chart-container">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        <!-- Recent Completed Orders -->
        <div class="earnings-card mt-4">
            <h3 class="text-center mb-4">Recent Completed Orders</h3>
            
            @if($completedOrders->isEmpty())
                <p class="text-center">No completed orders found.</p>
            @else
                <div class="table-responsive orders-table">
                    <table class="table table-striped">
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
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($order->items as $item)
                                                <li>{{ $item->service->service_name }} ({{ $item->quantity }} x {{ $item->price }} PKR)</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ number_format($order->total_amount) }} PKR</td>
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
    </main>

    <script>
        // Set up the earnings chart
        const ctx = document.getElementById('earningsChart').getContext('2d');
        
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlyData)) !!},
                datasets: [{
                    label: 'Monthly Earnings (PKR)',
                    data: {!! json_encode(array_values($monthlyData)) !!},
                    backgroundColor: '#0a9396',
                    borderColor: '#005f73',
                    borderWidth: 1
                }]
            },
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
                }
            }
        });
    </script>
</body>
</html> 