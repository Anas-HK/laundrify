<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Handle</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Order Handling</h1>
    <h3 class="text-center">Order ID: {{ $order->id }}</h3>
    <h4 class="text-center">Current Status: <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : ($order->status == 'rejected' ? 'danger' : 'info')) }}">{{ ucfirst($order->status) }}</span></h4>
    <h4 class="text-center">Total Amount: {{ $order->total_amount }} PKR</h4>

    <h3 class="mt-4">Customer Details</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $order->user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $order->user->email }}</li>
        <li class="list-group-item"><strong>Mobile:</strong> {{ $order->user->mobile }}</li>
        <li class="list-group-item"><strong>Address:</strong> {{ $order->user->address }}</li>
    </ul>

    <h3 class="mt-4">Order Items</h3>
    <table class="table table-bordered">
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

    <h3 class="mt-4">Seller Details</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $order->seller->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $order->seller->email }}</li>
        <li class="list-group-item"><strong>Contact:</strong> {{ $order->seller->mobile }}</li>
    </ul>

    <form action="{{ route('order.updateStatus', $order) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label"><strong>Update Status:</strong></label>
            <select name="status" id="status" class="form-select" {{ $order->status == 'rejected' ? 'disabled' : '' }} required>
                @if($order->status !== 'rejected')
                    <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="pickup_departed" {{ $order->status === 'pickup_departed' ? 'selected' : '' }}>Delivery Boy Departed</option>
                    <option value="picked_up" {{ $order->status === 'picked_up' ? 'selected' : '' }}>Laundry Picked Up</option>
                    <option value="started_washing" {{ $order->status === 'started_washing' ? 'selected' : '' }}>Started Washing</option>
                    <option value="ironing" {{ $order->status === 'ironing' ? 'selected' : '' }}>Ironing</option>
                    <option value="ready_for_delivery" {{ $order->status === 'ready_for_delivery' ? 'selected' : '' }}>Ready for Delivery</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Laundry Delivered</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Order Completed</option>
                @endif
            </select>
        </div>
        @if($order->status !== 'rejected')
            <button type="submit" class="btn btn-primary">Update Status</button>
        @else
            <button type="button" class="btn btn-secondary" disabled>Cannot Update - Order Rejected</button>
        @endif
    </form>

    
    <!-- Back to Seller Panel Button -->
    <div class="mt-4">
        <a href="{{ route('seller.panel') }}" class="btn btn-secondary">Back to Seller Panel</a>
    </div>
</div>

<!-- Bootstrap JS (Optional but recommended for components like dropdowns and modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0DWq69bWWVbq00+L8f6cIN8p+5BvhTtG5J9k3ZGzCqgkzMGG" crossorigin="anonymous"></script>
</body>
</html>
