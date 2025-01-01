<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
</head>
<body>
    <div class="container">
        <h1>Your Orders</h1>
        
        @if($orders->isEmpty())
    <p>You have no orders yet.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>Total Items</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->orderItems ? $order->orderItems->count() : 0 }}</td>
            <td>
                <a href="{{ route('order.track', $order) }}" class="btn btn-info">
                    Track Order
                </a>
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
@endif

    </div>
</body>
</html> -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            font-family: Arial, sans-serif;
        }
        h1, h2 {
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
        <h1>Your Orders</h1>
        
        @if($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
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
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->orderItems ? $order->orderItems->count() : 0 }}</td>
                            <td>{{ $order->total_amount }} PKR</td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <a href="{{ route('order.track', $order) }}" class="btn btn-info">
                                    Track Order
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
