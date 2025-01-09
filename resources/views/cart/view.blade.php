<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .cart-table th, .cart-table td {
            text-align: center;
            vertical-align: middle;
        }
        .cart-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .cart-table td {
            padding: 1rem;
        }
        .cart-table .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .cart-table .remove-btn:hover {
            background-color: #c82333;
        }
        .cart-summary {
            margin-top: 20px;
        }
        .cart-summary .total-label {
            font-weight: bold;
        }
        .cart-summary .checkout-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 1.2rem;
            border-radius: 5px;
            text-decoration: none;
        }
        .cart-summary .checkout-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<section class="cart py-5">
    <div class="container">
        <h2 class="text-center mb-4">Your Cart</h2>

        @if (empty($cart))
            <div class="alert alert-info text-center">
                Your cart is empty.
            </div>
        @else
            <table class="table table-bordered cart-table">
                <thead class="thead-light">
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
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total-label">Total:</td>
                        <td>{{ $total }} PKR</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <div class="cart-summary text-center">
                <a href="{{ route('checkout.show') }}" class="checkout-btn">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</section>

</body>
</html>
