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
        .payment-option {
            margin-top: 20px;
            padding: 20px;
            background: #f1f1f1;
            border-radius: 10px;
        }
        .payment-card {
            padding: 15px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: #fff;
            cursor: pointer;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .payment-card.active {
            background-color: #007bff;
            color: #fff;
        }
        .transaction-id {
            display: none;
            margin-top: 15px;
        }
        .invalid-feedback {
            display: none;
            color: red;
        }
    </style>
</head>
<body>

<section class="checkout-section">
    <div class="container">
        <h2 class="text-center mb-4">Checkout</h2>

        <form action="{{ route('checkout.place') }}" method="POST" id="checkout-form" class="row">
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

            <!-- Payment Options -->
            <div class="col-12 payment-option">
                <h4>Select Payment Method</h4>
                <div>
                    <input type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label for="cod">Cash on Delivery</label>
                </div>
                <div>
                    <input type="radio" name="payment_method" value="online" id="online">
                    <label for="online">Online Payment</label>
                </div>
            </div>

            <!-- Online Payment Options (Hidden Initially) -->
            <div class="col-12 mt-3" id="online-payment-options" style="display: none;">
                <h5>Select Payment Service</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-card" id="easypaisa-card">
                            Easypaisa <br> <small>Account: 0345-1234567</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-card" id="jazzcash-card">
                            JazzCash <br> <small>Account: 0300-7654321</small>
                        </div>
                    </div>
                </div>

                <!-- Transaction ID Input (Initially Hidden) -->
                <div class="transaction-id" id="transaction-id-input">
                    <label for="transaction_id" class="form-label mt-3">Enter Transaction ID</label>
                    <input type="text" name="transaction_id" id="transaction_id" class="form-control">
                    <div class="invalid-feedback" id="transaction-error">Transaction ID is required.</div>
                </div>
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
        const transactionId = document.getElementById('transaction_id');
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let isValid = true;

        document.getElementById('address-error').style.display = 'none';
        document.getElementById('phone-error').style.display = 'none';
        document.getElementById('transaction-error').style.display = 'none';

        if (address.value.trim() === '') {
            document.getElementById('address-error').style.display = 'block';
            isValid = false;
        }

        if (phone.value.trim() === '') {
            document.getElementById('phone-error').style.display = 'block';
            isValid = false;
        }

        if (paymentMethod === 'online' && transactionId.value.trim() === '') {
            document.getElementById('transaction-error').style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });

    document.getElementById('online').addEventListener('change', function () {
        document.getElementById('online-payment-options').style.display = 'block';
        document.getElementById('transaction-id-input').style.display = 'block';
    });

    document.getElementById('cod').addEventListener('change', function () {
        document.getElementById('online-payment-options').style.display = 'none';
        document.getElementById('transaction-id-input').style.display = 'none';
    });
</script>

</body>
</html>
