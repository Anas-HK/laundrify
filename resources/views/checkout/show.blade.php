<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .checkout-section {
            padding: 50px 0;
        }
        .checkout-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .checkout-summary h4 {
            font-weight: bold;
        }
        .order-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .btn-place-order {
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            font-size: 1.1rem;
            border-radius: 5px;
            width: auto;
            text-align: center;
            display: inline-block;
        }
        .btn-place-order:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
        .btn-place-order:focus {
            box-shadow: none;
        }
        .invalid-feedback {
            display: none;
        }
    </style>
</head>
<body>

<section class="checkout-section">
    <div class="container">
        <h2 class="text-center mb-4">Checkout</h2>

        <form action="{{ route('checkout.place') }}" method="POST"  id="checkout-form" class="row">
            @csrf
            <div class="col-md-6 mb-4">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control">
                <div class="invalid-feedback" id="address-error">Address is required.</div>
            </div>
            <div class="col-md-6 mb-4">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control">
                <div class="invalid-feedback" id="phone-error">Phone number is required.</div>
            </div>

            <div class="col-12">
                <h3 class="my-4">Order Summary</h3>
                <div class="checkout-summary">
                    <div class="order-item">
                        @php $total = 0; @endphp
                        @foreach ($cart as $item)
                            <div class="d-flex justify-content-between">
                                <span>{{ $item['name'] }} ({{ $item['quantity'] }} x {{ $item['price'] }} PKR)</span>
                                <span>{{ $item['quantity'] * $item['price'] }} PKR</span>
                            </div>
                            <input type="hidden" name="service_id" value="{{ $item['id'] }}">
                            @php $total += $item['quantity'] * $item['price']; @endphp
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between my-3">
                        <strong>Total:</strong>
                        <strong>{{ $total }} PKR</strong>
                    </div>
                    <div class='text-center'>
                        <button type="submit" class="btn btn-place-order">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function (e) {
        e.preventDefault(); 
        const address = document.getElementById('address');
        const phone = document.getElementById('phone');
        let isValid = true;

        document.getElementById('address-error').style.display = 'none';
        document.getElementById('phone-error').style.display = 'none';

        if (address.value.trim() === '') {
            document.getElementById('address-error').style.display = 'block';
            isValid = false;
        }

        if (phone.value.trim() === '') {
            document.getElementById('phone-error').style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            this.submit(); 
        }
    });
</script>

</body>
</html>
