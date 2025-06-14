<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders - Laundrify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orderTrack.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .orders-container {
            min-height: calc(100vh - 300px);
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            border-radius: 2px;
        }

        .empty-orders {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .empty-orders i {
            font-size: 4rem;
            color: var(--light-gray);
            margin-bottom: 1.5rem;
        }

        .empty-orders p {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .empty-orders-btn {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-normal);
        }

        .empty-orders-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .orders-card {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            margin-bottom: 0;
        }

        .orders-table th {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 15px;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .orders-table td {
            vertical-align: middle;
            padding: 15px;
            font-size: 0.95rem;
            color: var(--text-color);
            border-bottom: 1px solid var(--light-gray);
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .order-id {
            font-weight: 600;
            color: var(--primary-color);
        }

        .order-status {
            font-weight: 600;
            text-transform: capitalize;
            padding: 5px 10px;
            border-radius: var(--border-radius-md);
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            min-width: 120px;
            text-align: center;
        }

        .order-status i {
            margin-right: 6px;
        }

        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #f39c12;
        }

        .status-accepted {
            background-color: rgba(52, 152, 219, 0.15);
            color: var(--secondary);
        }

        .status-pickup_departed {
            background-color: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }

        .status-picked_up {
            background-color: rgba(52, 152, 219, 0.15);
            color: #3498db;
        }

        .status-started_washing {
            background-color: rgba(52, 152, 219, 0.15);
            color: #2980b9;
        }

        .status-ironing {
            background-color: rgba(142, 68, 173, 0.15);
            color: #8e44ad;
        }

        .status-ready_for_delivery {
            background-color: rgba(142, 68, 173, 0.15);
            color: #9b59b6;
        }

        .status-delivered {
            background-color: rgba(46, 204, 113, 0.15);
            color: var(--success);
        }

        .status-completed {
            background-color: rgba(46, 204, 113, 0.15);
            color: #27ae60;
        }

        .status-rejected {
            background-color: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .status-cancelled {
            background-color: rgba(231, 76, 60, 0.15);
            color: #e74c3c;
        }

        .order-date {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .track-button {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--border-radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-normal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .track-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
            color: white;
        }

        .track-button i {
            margin-right: 5px;
        }

        .cancel-button {
            background: linear-gradient(to right, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--border-radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-normal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
        }

        .cancel-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
            color: white;
        }

        .cancel-button i {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .orders-table {
                display: block;
                overflow-x: auto;
            }

            .page-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Toast notification container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 70px;">
        @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    
        @if(session('error'))
            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- Modern Navbar -->
    <header class="navbar-main">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        @include('components.logo')
                    </a>
                </div>
                
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    <a href="{{ route('cart.view') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a>
                    <a href="{{ route('orders.all') }}" class="nav-link active">
                        <i class="fas fa-box"></i> Orders
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container orders-container">
        <h1 class="page-title">Your Orders</h1>
        
        @if($orders->isEmpty())
            <div class="empty-orders">
                <i class="fas fa-box-open"></i>
                <p>You have no orders yet.</p>
                <a href="{{ route('home') }}" class="empty-orders-btn">
                    <i class="fas fa-shopping-basket me-2"></i> Start Shopping
                </a>
            </div>
        @else
            <div class="orders-card">
                <div class="table-responsive">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Status</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="order-id">#{{ $order->id }}</td>
                                    <td>
                                        @php
                                            $statusIcons = [
                                                'pending' => '<i class="bi bi-hourglass-split"></i>',
                                                'accepted' => '<i class="bi bi-check-circle"></i>',
                                                'pickup_departed' => '<i class="bi bi-truck"></i>',
                                                'picked_up' => '<i class="bi bi-basket"></i>',
                                                'started_washing' => '<i class="bi bi-water"></i>',
                                                'ironing' => '<i class="bi bi-crop"></i>',
                                                'ready_for_delivery' => '<i class="bi bi-box-seam"></i>',
                                                'delivered' => '<i class="bi bi-truck"></i>',
                                                'completed' => '<i class="bi bi-check-circle-fill"></i>',
                                                'rejected' => '<i class="bi bi-x-circle"></i>',
                                                'cancelled' => '<i class="bi bi-slash-circle"></i>'
                                            ];
                                            
                                            $icon = isset($statusIcons[$order->status]) ? $statusIcons[$order->status] : '<i class="bi bi-question-circle"></i>';
                                            $statusText = ucwords(str_replace('_', ' ', $order->status));
                                        @endphp
                                        <span class="order-status status-{{ $order->status }}">{!! $icon !!} {{ $statusText }}</span>
                                    </td>
                                    <td>{{ $order->orderItems ? $order->orderItems->count() : 0 }}</td>
                                    <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                                    <td>
                                        <div class="order-date">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="order-date">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.track', $order) }}" class="track-button">
                                            <i class="fas fa-truck"></i> Track
                                        </a>
                                        @if(in_array($order->status, ['pending', 'accepted']))
                                        <a href="{{ route('orders.cancel.form', $order) }}" class="cancel-button">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="text-center">
                <p>&copy; 2024 Laundrify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Toast initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastElements = document.querySelectorAll('.toast');
            toastElements.forEach(function(toast) {
                var bsToast = new bootstrap.Toast(toast, {
                    autohide: true,
                    delay: 5000
                });
                bsToast.show();
            });
        });
    </script>
</body>
</html>
