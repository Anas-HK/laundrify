<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Handle</title>
</head>
<body>
<div class="container">
    <h1>Order Handling</h1>
    <h3>Order ID: {{ $order->id }}</h3>
    <h4>Current Status: {{ ucfirst($order->status) }}</h4>

    <form action="{{ route('order.updateStatus', $order) }}" method="POST">
        @csrf
        <label for="status">Update Status:</label>
        <select name="status" id="status" class="form-select" required>
            <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
            <option value="pickup_departed" {{ $order->status === 'pickup_departed' ? 'selected' : '' }}>Delivery Boy Departed</option>
            <option value="picked_up" {{ $order->status === 'picked_up' ? 'selected' : '' }}>Laundry Picked Up</option>
            <option value="started_washing" {{ $order->status === 'started_washing' ? 'selected' : '' }}>Started Washing</option>
            <option value="ironing" {{ $order->status === 'ironing' ? 'selected' : '' }}>Ironing</option>
            <option value="ready_for_delivery" {{ $order->status === 'ready_for_delivery' ? 'selected' : '' }}>Ready for Delivery</option>
            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Laundry Delivered</option>
            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Order Completed</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Update Status</button>
    </form>
</div>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Handle</title>
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            font-family: Arial, sans-serif;
        }
        h1, h3, h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Order Handling</h1>
    <h3>Order ID: {{ $order->id }}</h3>
    <h4>Current Status: {{ ucfirst($order->status) }}</h4>
    <h4>Total Amount: {{ $order->total_amount }} PKR</h4>

    <h3>Customer Details</h3>
    <p><strong>Name:</strong> {{ $order->user->name }}</p>
    <p><strong>Email:</strong> {{ $order->user->email }}</p>
    <p><strong>Mobile:</strong> {{ $order->user->mobile }}</p>
    <p><strong>Address:</strong> {{ $order->user->address }}</p>

    <h3>Order Items</h3>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Quantity</th>
                <th>Price (per unit)</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->service->service_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }} PKR</td>
                    <td>{{ $item->quantity * $item->price }} PKR</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Seller Details</h3>
    <p><strong>Name:</strong> {{ $order->seller->name }}</p>
    <p><strong>Email:</strong> {{ $order->seller->email }}</p>
    <p><strong>Contact:</strong> {{ $order->seller->mobile }}</p>

    <form action="{{ route('order.updateStatus', $order) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <label for="status"><strong>Update Status:</strong></label>
        <select name="status" id="status" class="form-select" required>
            <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
            <option value="pickup_departed" {{ $order->status === 'pickup_departed' ? 'selected' : '' }}>Delivery Boy Departed</option>
            <option value="picked_up" {{ $order->status === 'picked_up' ? 'selected' : '' }}>Laundry Picked Up</option>
            <option value="started_washing" {{ $order->status === 'started_washing' ? 'selected' : '' }}>Started Washing</option>
            <option value="ironing" {{ $order->status === 'ironing' ? 'selected' : '' }}>Ironing</option>
            <option value="ready_for_delivery" {{ $order->status === 'ready_for_delivery' ? 'selected' : '' }}>Ready for Delivery</option>
            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Laundry Delivered</option>
            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Order Completed</option>
        </select>
        <button type="submit" class="btn btn-primary mt-3">Update Status</button>
    </form>
</div>
</body>
</html>
