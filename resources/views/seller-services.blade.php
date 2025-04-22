<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seller->name }} Services - Laundrify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .services-header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            border-radius: var(--border-radius-lg);
        }

        .seller-info {
            text-align: center;
        }

        .seller-info h1 {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 2.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .seller-info p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
        }

        .service-card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            overflow: hidden;
            height: 100%;
            background-color: var(--white);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .service-img-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .service-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .service-card:hover .service-img {
            transform: scale(1.05);
        }

        .service-card .card-body {
            padding: 20px;
        }

        .service-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--dark-color);
        }

        .service-price {
            font-size: 1.1rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .service-description {
            color: var(--text-color);
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .service-footer {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: var(--light-color);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
        }

        .service-footer span {
            color: var(--text-muted);
        }

        .service-footer strong {
            color: var(--dark-color);
        }

        .cart-button {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            transition: all var(--transition-normal);
        }

        .cart-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
        }

        .cart-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            z-index: 999;
            transition: all var(--transition-normal);
        }

        .cart-float:hover {
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .feedback-section {
            margin-top: 60px;
            padding: 40px 0;
            background-color: var(--light-color);
            border-radius: var(--border-radius-lg);
        }

        .feedback-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--dark-color);
            position: relative;
        }

        .feedback-title::after {
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

        .feedback-card {
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-normal);
        }

        .feedback-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-5px);
        }

        .feedback-text {
            font-style: italic;
            color: var(--text-color);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .feedback-user {
            display: flex;
            align-items: center;
        }

        .feedback-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: 600;
        }

        .feedback-user-info {
            flex: 1;
        }

        .feedback-user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .feedback-order-id {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .empty-state {
            text-align: center;
            padding: 40px 0;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--light-gray);
        }

        .services-container {
            min-height: 300px;
        }

        /* Alert styling */
        .alert {
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-sm);
            border: none;
        }

        .alert-success {
            background-color: var(--success-light);
            color: var(--success);
            border-left: 4px solid var(--success);
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
                    <a href="{{ route('cart.view') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="badge bg-danger rounded-pill">
                            {{ Session::get('cart') ? array_sum(array_column(Session::get('cart'), 'quantity')) : 0 }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Seller Header -->
    <div class="container mt-5">
        <div class="services-header">
            <div class="seller-info">
                <h1>{{ $seller->name }}</h1>
                <p>Professional laundry services in {{ $seller->city }}, {{ $seller->area }}</p>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section class="container mb-5">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="services-container">
            @if ($services->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-shirt"></i>
                    <h3>No Services Available</h3>
                    <p>This seller hasn't added any services yet.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card">
                                <div class="service-img-container">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="service-img">
                                    @else
                                        <div class="d-flex justify-content-center align-items-center h-100" style="background-color: #f5f5f5;">
                                            <i class="fas fa-shirt" style="font-size: 3rem; color: #ddd;"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h3 class="service-title">{{ $service->service_name }}</h3>
                                    <div class="service-price">{{ $service->service_price }} PKR</div>
                                    <p class="service-description">{{ $service->service_description }}</p>
                                    
                                    <div class="mt-auto">
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                                            <button type="submit" class="cart-button w-100">
                                                <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="service-footer">
                                    <span><strong>Availability:</strong> {{ $service->availability }}</span>
                                    <span><strong>Delivery:</strong> {{ $service->service_delivery_time }} days</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Feedback Section -->
    @if(isset($feedbacks) && $feedbacks->count() > 0)
        <section class="container feedback-section mb-5">
            <h2 class="feedback-title">Customer Feedback</h2>
            
            <div class="row g-4 mt-4">
                @foreach ($feedbacks as $feedback)
                    <div class="col-md-6">
                        <div class="feedback-card">
                            <p class="feedback-text">"{{ $feedback->feedback }}"</p>
                            <div class="feedback-user">
                                <div class="feedback-user-avatar">
                                    {{ substr($feedback->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div class="feedback-user-info">
                                    <div class="feedback-user-name">{{ $feedback->user->name ?? 'Anonymous' }}</div>
                                    <div class="feedback-order-id">Order #{{ $feedback->order_id }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @else
        <div class="container mb-5">
            <div class="text-center py-4 text-muted">
                <i class="fas fa-comments d-block mb-3" style="font-size: 2rem; color: #ddd;"></i>
                <p>No feedback available for this seller yet.</p>
            </div>
        </div>
    @endif

    <!-- Floating Cart Button -->
    <a href="{{ route('cart.view') }}" class="cart-float">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">
            {{ Session::get('cart') ? array_sum(array_column(Session::get('cart'), 'quantity')) : 0 }}
        </span>
    </a>

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
