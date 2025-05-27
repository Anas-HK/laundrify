<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Details - {{ $order->id }} | Laundrify</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/orderDetails.css') }}">
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

    <div class="container order-details-page">
        <div class="row mb-3">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('order.history') }}">Order History</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Details Card -->
                <div class="order-card card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order #{{ $order->id }}</h5>
                        <span class="order-status status-{{ strtolower(str_replace(' ', '-', str_replace('_', '-', $order->status))) }}">
                            <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i>
                            {{ ucwords(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Order Date</div>
                                    <div class="info-value">{{ $order->created_at->format('F d, Y h:i A') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Total Amount</div>
                                    <div class="info-value">{{ number_format($order->total_amount, 2) }} PKR</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Delivery Address</div>
                                    <div class="info-value">{{ $order->address }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Contact Phone</div>
                                    <div class="info-value">{{ $order->phone }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Seller</div>
                                    <div class="info-value">{{ $order->seller->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                            @if($order->transaction_id)
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Transaction ID</div>
                                    <div class="info-value">{{ $order->transaction_id }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="order-card card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="order-items-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Service</th>
                                        <th style="width: 15%;" class="text-center">Price</th>
                                        <th style="width: 15%;" class="text-center">Qty</th>
                                        <th style="width: 20%;" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-medium">{{ $item->service->service_name ?? 'Unknown Service' }}</div>
                                            <small class="text-muted">{{ $item->service->service_description ?? '' }}</small>
                                        </td>
                                        <td class="text-center">{{ number_format($item->price, 2) }} PKR</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">{{ number_format($item->price * $item->quantity, 2) }} PKR</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="text-end fw-bold">{{ number_format($order->total_amount, 2) }} PKR</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                @if($order->status === 'completed')
                <div class="order-card card">
                    <div class="card-header">
                        <h5 class="mb-0">Leave Feedback</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">Share your experience with this service to help other customers make better decisions.</p>
                        <a href="{{ route('order.feedback', $order->id) }}" class="action-btn btn-feedback">
                            <i class="fas fa-comment"></i> Write a Review
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Order Status Card -->
                <div class="order-card card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item {{ in_array($order->status, ['pending', 'accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']) ? 'active' : '' }}">
                                <div class="timeline-title">Order Placed</div>
                                <div class="timeline-date">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']) ? 'active' : '' }}">
                                <div class="timeline-title">Order Accepted</div>
                                <div class="timeline-date">
                                    @if(in_array($order->status, ['accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']))
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']) ? 'active' : '' }}">
                                <div class="timeline-title">In Process</div>
                                <div class="timeline-date">
                                    @if(in_array($order->status, ['pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']))
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['delivered', 'completed']) ? 'active' : '' }}">
                                <div class="timeline-title">Delivered</div>
                                <div class="timeline-date">
                                    @if(in_array($order->status, ['delivered', 'completed']))
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </div>
                            </div>
                            
                            <div class="timeline-item {{ $order->status === 'completed' ? 'active' : '' }}">
                                <div class="timeline-title">Completed</div>
                                <div class="timeline-date">
                                    @if($order->status === 'completed')
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </div>
                            </div>

                            @if($order->status === 'cancelled')
                            <div class="timeline-item active">
                                <div class="timeline-title text-danger">Cancelled</div>
                                <div class="timeline-date">
                                    @if($order->cancelled_at && !is_string($order->cancelled_at))
                                        {{ $order->cancelled_at->format('M d, Y h:i A') }}
                                    @elseif($order->cancelled_at)
                                        {{ date('M d, Y h:i A', strtotime($order->cancelled_at)) }}
                                    @else
                                        {{ date('M d, Y h:i A', strtotime($order->updated_at)) }}
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Actions Card -->
                <div class="order-card card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('order.track', $order->id) }}" class="action-btn mb-3">
                                <i class="fas fa-map-marker-alt"></i> Track Order
                            </a>
                            
                            @if(in_array($order->status, ['pending', 'accepted']))
                            <a href="{{ route('order.cancel.form', $order->id) }}" class="action-btn btn-cancel mb-3">
                                <i class="fas fa-times-circle"></i> Cancel Order
                            </a>
                            @endif
                            
                            <a href="{{ route('chat.index', $order->id) }}" class="action-btn mb-3">
                                <i class="fas fa-comments"></i> Contact Seller
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white py-4 mt-2 border-top">
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