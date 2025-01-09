<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Your Orders</h1>
        
        @if($orders->isEmpty())
            <div class="alert alert-info text-center" role="alert">
                You have no orders yet.
            </div>
        @else
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Total Items</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td class="text-capitalize">{{ $order->status }}</td>
                            <td>{{ $order->orderItems ? $order->orderItems->count() : 0 }}</td>
                            <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <a href="{{ route('order.track', $order) }}" class="btn btn-info btn-sm" style="color: white">
                                    Track Order
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
