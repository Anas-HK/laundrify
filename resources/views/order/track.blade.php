<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Tracking - Laundrify</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/orderTrack.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .status-tracker {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .status-tracker::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #dee2e6;
            z-index: 1;
        }
        .status-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex-grow: 1;
            z-index: 2;
        }
        .status-icon {
            width: 40px;
            height: 40px;
            margin-bottom: 10px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #dee2e6;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .status-icon.completed {
            background-color: #28a745;
            color: white;
        }
        .status-text {
            text-align: center;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <header class="bg-white shadow-sm py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                @include('components.logo')
                <div>
                    <a href="{{ url('/') }}" class="btn-contact btn-sm">
                        <i class="fas fa-home"></i> Home
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-white border-0 p-4">
                        <h2 class="section-title mb-0">Order Tracking</h2>
                    </div>
                    <div class="card-body p-4">
                        <!-- Order Status Alert -->
                        @if($order->status == 'pending')
                            <div class="alert alert-warning animate__animated animate__fadeIn">
                                <i class="bi bi-hourglass-split me-2"></i> Your order is pending confirmation.
                            </div>
                        @elseif($order->status == 'rejected')
                            <div class="alert alert-danger animate__animated animate__fadeIn">
                                <i class="bi bi-x-circle me-2"></i> Your order was rejected. Please contact customer service for more information.
                            </div>
                        @elseif($order->status == 'cancelled')
                            <div class="alert alert-danger animate__animated animate__fadeIn">
                                <i class="bi bi-slash-circle me-2"></i> Your order was cancelled. Please contact customer service for more information.
                            </div>
                        @elseif($order->status == 'delivered')
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <i class="bi bi-check-circle me-2"></i> Your order has been delivered successfully!
                            </div>
                        @elseif($order->status == 'completed')
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <i class="bi bi-check-circle-fill me-2"></i> Your order has been completed successfully!
                            </div>
                        @else
                            <div class="alert alert-info animate__animated animate__fadeIn">
                                <i class="bi bi-info-circle me-2"></i> Your order is being processed. You can track its progress below.
                            </div>
                        @endif
                        
                        <!-- Status Tracker -->
                        <div class="status-tracker">
                            @php
                                $statuses = [
                                    'pending' => 'bi-hourglass-split',
                                    'accepted' => 'bi-check-circle',
                                    'pickup_departed' => 'bi-truck',
                                    'picked_up' => 'bi-basket',
                                    'started_washing' => 'bi-water',
                                    'ironing' => 'bi-crop',
                                    'ready_for_delivery' => 'bi-box-seam',
                                    'delivered' => 'bi-truck',
                                    'completed' => 'bi-check-circle-fill',
                                    'rejected' => 'bi-x-circle',
                                    'cancelled' => 'bi-slash-circle'
                                ];

                                $currentStatusIndex = array_search($order->status, array_keys($statuses));
                            @endphp

                            @if ($order->status == 'pending')
                                <div class="status-item">
                                    <div class="status-icon">
                                        <i class="bi bi-hourglass-split fs-4"></i>
                                    </div>
                                    <div class="status-text">
                                        Pending
                                    </div>
                                </div>
                            @elseif ($order->status == 'rejected')
                                <div class="status-item">
                                    <div class="status-icon">
                                        <i class="bi bi-x-circle fs-4"></i>
                                    </div>
                                    <div class="status-text">
                                        Rejected
                                    </div>
                                </div>
                            @elseif ($order->status == 'cancelled')
                                <div class="status-item">
                                    <div class="status-icon">
                                        <i class="bi bi-slash-circle fs-4"></i>
                                    </div>
                                    <div class="status-text">
                                        Cancelled
                                    </div>
                                </div>
                            @else
                                @foreach ($statuses as $statusKey => $iconClass)
                                    @if (!in_array($statusKey, ['pending', 'rejected', 'cancelled']))
                                        @php
                                            $isCompleted = array_search($statusKey, array_keys($statuses)) <= $currentStatusIndex;
                                        @endphp
                                        <div class="status-item">
                                            <div class="status-icon {{ $isCompleted ? 'completed' : '' }}">
                                                <i class="bi {{ $iconClass }} fs-4"></i>
                                            </div>
                                            <div class="status-text">
                                                {{ ucwords(str_replace('_', ' ', $statusKey)) }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Order Details -->
                        <div class="order-details">
                            <h3 class="section-title">Order Details</h3>
                            
                            <div class="order-meta">
                                <div class="order-meta-item">
                                    <i class="fas fa-hashtag"></i>
                                    <div>
                                        <div class="meta-label">Order ID</div>
                                        <div class="meta-value">{{ $order->id }}</div>
                                    </div>
                                </div>
                                
                                <div class="order-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <div>
                                        <div class="meta-label">Order Date</div>
                                        <div class="meta-value">{{ $order->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                
                                <div class="order-meta-item">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>
                                        <div class="meta-label">Total Amount</div>
                                        <div class="meta-value">{{ number_format($order->total_amount, 2) }} PKR</div>
                                    </div>
                                </div>
                                
                                <div class="order-meta-item">
                                    <i class="fas fa-info-circle"></i>
                                    <div>
                                        <div class="meta-label">Status</div>
                                        <div class="meta-value">
                                            @if($order->status == 'pending')
                                                <span class="status-badge status-pending">Pending</span>
                                            @elseif($order->status == 'accepted')
                                                <span class="status-badge status-accepted">Accepted</span>
                                            @elseif($order->status == 'pickup_departed')
                                                <span class="status-badge status-pickup">Pickup Departed</span>
                                            @elseif($order->status == 'picked_up')
                                                <span class="status-badge status-pickup">Picked Up</span>
                                            @elseif($order->status == 'started_washing')
                                                <span class="status-badge status-washing">Started Washing</span>
                                            @elseif($order->status == 'ironing')
                                                <span class="status-badge status-ironing">Ironing</span>
                                            @elseif($order->status == 'ready_for_delivery')
                                                <span class="status-badge status-ready">Ready for Delivery</span>
                                            @elseif($order->status == 'delivered')
                                                <span class="status-badge status-delivered">Delivered</span>
                                            @elseif($order->status == 'completed')
                                                <span class="status-badge status-completed">Completed</span>
                                            @elseif($order->status == 'rejected')
                                                <span class="status-badge status-rejected">Rejected</span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="status-badge status-cancelled">Cancelled</span>
                                            @else
                                                <span class="status-badge">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="mt-5">
                            <h3 class="section-title">Order Items</h3>
                            
                            <div class="order-items">
                                @foreach($order->items as $item)
                                <div class="item-card">
                                    <div class="item-name">{{ $item->service->service_name ?? 'Unknown Service' }}</div>
                                    <span class="item-qty">{{ $item->quantity }} x {{ $item->service->service_description ?? 'Service' }}</span>
                                    <span class="item-price">{{ number_format($item->price, 2) }} PKR</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        @if(in_array($order->status, ['accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']))
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('chat.index', $order->id) }}" class="btn-contact">
                                <i class="fas fa-comment-dots"></i> Chat with Seller
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} Laundrify. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-muted me-3">Privacy Policy</a>
                    <a href="#" class="text-muted">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
