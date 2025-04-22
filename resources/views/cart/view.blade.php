<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Laundrify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .cart-container {
            margin-top: 50px;
            min-height: calc(100vh - 250px);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            border-radius: 2px;
        }

        .cart-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
        }

        .cart-empty i {
            font-size: 4rem;
            color: var(--light-gray);
            margin-bottom: 1.5rem;
        }

        .cart-empty p {
            font-size: 1.2rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .cart-empty-btn {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-normal);
        }

        .cart-empty-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .cart-table {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: none;
        }

        .cart-table th {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .cart-table td {
            vertical-align: middle;
            padding: 1rem;
            font-size: 1rem;
            color: var(--text-color);
            border-bottom: 1px solid var(--light-gray);
        }

        .cart-table tr:last-child td {
            border-bottom: none;
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--dark-color);
        }

        .cart-item-price, .cart-item-quantity, .cart-item-total {
            text-align: center;
        }

        .cart-item-price, .cart-item-total {
            font-weight: 600;
        }

        .cart-item-total {
            color: var(--primary-color);
        }

        .remove-btn {
            background-color: var(--danger);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: var(--border-radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            transition: all var(--transition-normal);
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: var(--danger-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .cart-summary {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: var(--shadow-md);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .cart-total-label {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .cart-total-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .checkout-btn {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius-md);
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            display: block;
            width: 100%;
            text-decoration: none;
            transition: all var(--transition-normal);
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            color: white;
        }

        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--text-muted);
            font-weight: 500;
            text-decoration: none;
            transition: color var(--transition-fast);
        }

        .continue-shopping:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .cart-table {
                display: block;
                overflow-x: auto;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .cart-total-label {
                font-size: 1.1rem;
            }
            
            .cart-total-value {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Modern Navbar -->
    <header class="navbar-main">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <span class="logo-text">Laundrify</span>
                        <span class="logo-icon"><i class="fas fa-tshirt"></i></span>
                    </a>
                </div>
                
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    <a href="{{ route('cart.view') }}" class="nav-link active">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="badge bg-danger rounded-pill">
                            {{ count($cart) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container cart-container">
        <h1 class="page-title">Your Cart</h1>

        @if (empty($cart))
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Your cart is empty.</p>
                <a href="{{ route('home') }}" class="cart-empty-btn">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
            </div>
        @else
            <div class="card cart-table">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="width: 40%">Service</th>
                                <th style="width: 15%">Price</th>
                                <th style="width: 15%">Quantity</th>
                                <th style="width: 15%">Total</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cart as $item)
                                <tr>
                                    <td class="cart-item-name">{{ $item['name'] }}</td>
                                    <td class="cart-item-price">{{ $item['price'] }} PKR</td>
                                    <td class="cart-item-quantity">{{ $item['quantity'] }}</td>
                                    <td class="cart-item-total">{{ $item['price'] * $item['quantity'] }} PKR</td>
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $item['id'] }}">
                                            <button type="submit" class="remove-btn">
                                                <i class="fas fa-trash-alt me-1"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="cart-summary">
                <div class="cart-total">
                    <span class="cart-total-label">Total Amount</span>
                    <span class="cart-total-value">{{ $total }} PKR</span>
                </div>

                <a href="{{ route('checkout.show') }}" class="checkout-btn">
                    <i class="fas fa-check-circle me-2"></i> Proceed to Checkout
                </a>
                <a href="{{ route('home') }}" class="continue-shopping mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="text-center">
                <p>&copy; 2024 Laundrify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
