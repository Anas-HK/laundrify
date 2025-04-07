<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - {{ $order->id }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .order-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        .status-pending {
            background-color: #ffe8cc;
            color: #ff9800;
        }
        .status-accepted {
            background-color: #cce5ff;
            color: #0d6efd;
        }
        .status-in-progress {
            background-color: #e0f7fa;
            color: #00acc1;
        }
        .status-completed {
            background-color: #d4edda;
            color: #28a745;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #dc3545;
        }
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-bottom: 20px;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }
        .timeline-item:before {
            content: "";
            position: absolute;
            left: -24px;
            top: 0;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: #e9ecef;
            border: 3px solid #dee2e6;
            z-index: 1;
        }
        .timeline-item.active:before {
            background-color: #28a745;
            border-color: #d4edda;
        }
        .timeline-item:after {
            content: "";
            position: absolute;
            left: -16px;
            top: 18px;
            bottom: 0;
            width: 2px;
            background-color: #dee2e6;
        }
        .timeline-item:last-child:after {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
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
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Order #{{ $order->id }}</h5>
                        <span class="order-status status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Order Date:</strong></p>
                                <p>{{ $order->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Total Amount:</strong></p>
                                <p>${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Delivery Address:</strong></p>
                                <p>{{ $order->address }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Contact Phone:</strong></p>
                                <p>{{ $order->phone }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Seller:</strong></p>
                                <p>{{ $order->seller->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($order->transaction_id)
                                <p class="mb-1"><strong>Transaction ID:</strong></p>
                                <p>{{ $order->transaction_id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Items</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->service->title ?? 'Unknown Service' }}
                                            <small class="d-block text-muted">{{ $item->service->category ?? '' }}</small>
                                        </td>
                                        <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end">${{ number_format($order->total_amount, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                @if($order->status === 'completed')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Leave Feedback</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('order.feedback', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-comment"></i> Write a Review
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item {{ in_array($order->status, ['pending', 'accepted', 'in_progress', 'completed']) ? 'active' : '' }}">
                                <h6>Order Placed</h6>
                                <p class="small text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['accepted', 'in_progress', 'completed']) ? 'active' : '' }}">
                                <h6>Order Accepted</h6>
                                <p class="small text-muted">
                                    @if(in_array($order->status, ['accepted', 'in_progress', 'completed']))
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                            
                            <div class="timeline-item {{ in_array($order->status, ['in_progress', 'completed']) ? 'active' : '' }}">
                                <h6>In Progress</h6>
                                <p class="small text-muted">
                                    @if(in_array($order->status, ['in_progress', 'completed']))
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                            
                            <div class="timeline-item {{ $order->status === 'completed' ? 'active' : '' }}">
                                <h6>Completed</h6>
                                <p class="small text-muted">
                                    @if($order->status === 'completed')
                                        {{ $order->updated_at->format('M d, Y h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('order.track', $order->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-truck"></i> Track Order
                            </a>
                            
                            @if($order->status !== 'cancelled' && $order->status !== 'completed')
                            <a href="{{ route('chat.index', $order->id) }}" class="btn btn-outline-info">
                                <i class="fas fa-comments"></i> Contact Seller
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 