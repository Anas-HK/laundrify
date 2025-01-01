<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
</head>
<body>
<section class="order-tracking">
    <div class="container">
        <h2>Order Tracking</h2>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <h3>Order Items:</h3>
        <ul>
            @foreach ($order->items as $item)
                <li>{{ $item->service->service_name }} - {{ $item->quantity }} x {{ $item->price }} PKR</li>
            @endforeach
        </ul>
    </div>
</section>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
</head>
<body>
<section class="order-tracking">
    <div class="container">
        <h2>Order Tracking</h2>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

        <h3>Order Details</h3>
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
        <p><strong>Total Amount:</strong> {{ $order->total_amount }} PKR</p>

        <h3>Customer Details</h3>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Address:</strong> {{ $order->user->address }}, {{ $order->user->city }}, {{ $order->user->state }}</p>
        <p><strong>Mobile:</strong> {{ $order->user->mobile }}</p>

        <h3>Seller Details</h3>
        <p><strong>Name:</strong> {{ $order->seller->name }}</p>
        <p><strong>Email:</strong> {{ $order->seller->email }}</p>
        <p><strong>Contact:</strong> {{ $order->seller->contact }}</p>

        <h3>Order Items:</h3>
        <ul>
            @foreach ($order->items as $item)
                <li>
                    <strong>Service:</strong> {{ $item->service->service_name }} <br>
                    <strong>Quantity:</strong> {{ $item->quantity }} <br>
                    <strong>Price:</strong> {{ $item->price }} PKR <br>
                    <strong>Description:</strong> {{ $item->service->description ?? 'No description available' }}
                </li>
            @endforeach
        </ul>
    </div>
</section>
</body>
</html>
