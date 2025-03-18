<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        @php
            $statuses = [
                'accepted' => 'bi-check-circle',
                'pickup_departed' => 'bi-truck',
                'picked_up' => 'bi-basket',
                'started_washing' => 'bi-water',
                'ironing' => 'bi-crop',
                'ready_for_delivery' => 'bi-box-seam',
                'delivered' => 'bi-truck',
                'completed' => 'bi-check-circle-fill'
            ];

            $currentStatusIndex = array_search($order->status, array_keys($statuses));
        @endphp

        @if ($order->status == 'pending')
            <div class="alert alert-warning text-center">
                Order is Pending
            </div>
        @elseif ($order->status == 'rejected')
            <div class="alert alert-danger text-center">
                Order Rejected
            </div>
        @else
            <div class="status-tracker">
                @foreach ($statuses as $statusKey => $iconClass)
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
                @endforeach
            </div>

            <!-- Chat Button (Only for specific statuses) -->
            @if(in_array($order->status, ['accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']))
                <div class="text-center mb-4">
                <a href="{{ route('chat.index', $order->id) }}" class="btn btn-primary">
    Chat with Seller
</a>
                </div>
            @endif
        @endif

        <div class="mb-4">
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : ($order->status == 'rejected' ? 'danger' : 'info')) }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </p>
        </div>

        <h3>Order Details</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Order ID:</strong> {{ $order->id }}</li>
            <li class="list-group-item"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</li>
            <li class="list-group-item"><strong>Total Amount:</strong> {{ $order->total_amount }} PKR</li>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
