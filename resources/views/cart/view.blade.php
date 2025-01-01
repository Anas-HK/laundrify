<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
</head>
<body>
<section class="cart">
    <div class="container">
        <h2>Your Cart</h2>
        @if (empty($cart))
            <p>Your cart is empty.</p>
        @else
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }} PKR</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] * $item['quantity'] }} PKR</td>
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $item['id'] }}">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td>{{ $total }} PKR</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <a href="{{ route('checkout.show') }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</section>
</body>
</html>
