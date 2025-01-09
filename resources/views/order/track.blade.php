<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Order Tracking</h2>
        
        <div class="mb-4">
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : ($order->status == 'rejected' ? 'danger' : 'info')) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>

        <h3>Order Details</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Order ID:</strong> {{ $order->id }}</li>
            <li class="list-group-item"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</li>
            <li class="list-group-item"><strong>Total Amount:</strong> {{ $order->total_amount }} PKR</li>
        </ul>

        <h3>Customer Details</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Name:</strong> {{ $order->user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $order->user->email }}</li>
            <li class="list-group-item"><strong>Address:</strong> {{ $order->user->address }}, {{ $order->user->city }}, {{ $order->user->state }}</li>
            <li class="list-group-item"><strong>Mobile:</strong> {{ $order->user->mobile }}</li>
        </ul>

        <h3>Seller Details</h3>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Name:</strong> {{ $order->seller->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $order->seller->email }}</li>
            <li class="list-group-item"><strong>Contact:</strong> {{ $order->seller->contact }}</li>
        </ul>

        <h3>Order Items:</h3>
        <ul class="list-group">
            @foreach ($order->items as $item)
                <li class="list-group-item">
                    <strong>Service:</strong> {{ $item->service->service_name }} <br>
                    <strong>Quantity:</strong> {{ $item->quantity }} <br>
                    <strong>Price:</strong> {{ $item->price }} PKR <br>
                    <strong>Description:</strong> {{ $item->service->description ?? 'No description available' }}
                </li>
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
