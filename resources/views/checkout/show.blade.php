<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>
        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <div>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required>
            </div>
            <h3>Order Summary</h3>
            <ul>
                @foreach ($cart as $item)
                    <li>{{ $item['name'] }} - {{ $item['quantity'] }} x {{ $item['price'] }} = {{ $item['quantity'] * $item['price'] }} PKR</li>
                    <input type="hidden" name="service_id" value="{{ $item['id'] }}">
                @endforeach
            </ul>
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>