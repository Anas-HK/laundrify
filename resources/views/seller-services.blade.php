<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            text-transform: capitalize;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
        }
        .service-img {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .see-more {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .card-footer {
            background-color: #fafafa;
            border-top: 1px solid #ddd;
        }
        .cart-icon {
            font-size: 2rem;
            color: #ffffff;
            background-color: #007bff;
            padding: 12px;
            border-radius: 50%;
            position: fixed;
            bottom: 10px;
            right: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
        .cart-icon .count {
            font-size: 1.2rem;
            position: absolute;
            top: -5px;
            left: 12px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 4px 9px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
<section class="seller-services py-5">
    <div class="container">
        <h2 class="text-center mb-5">Services by {{ $seller->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($services->isEmpty())
            <p class="text-center">No services available for this seller.</p>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($services as $service)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 200px; background-color: #f0f0f0;">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="service-img w-100">
                                @else
                                    <i class="fas fa-image" style="font-size: 50px; color: #aaa;"></i>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $service->service_name }}</h5>
                                <p class="card-text">
                                    <strong>Start Price:</strong> {{ $service->service_price }} PKR
                                </p>
                                    <p class="card-text description-line-clamp">
                                    <strong>Description:</strong> {{ Str::limit($service->service_description, 100) }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <small class="text-muted"><strong>Availability:</strong> {{ $service->availability }}</small>
                                <small class="text-muted"><strong>Delivery Time:</strong> {{ $service->service_delivery_time }} days</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@if(isset($feedbacks) && $feedbacks->count() > 0)
    <section class="feedback mt-4">
        <h3 class="text-center">Customer Feedback</h3>
        <div class="feedback-cards">
            @foreach ($feedbacks as $feedback)
                <div class="feedback-card p-3 mb-3 border rounded shadow-sm">
                    <p>"{{ $feedback->feedback }}"</p>
                    <small><strong>Customer:</strong> {{ $feedback->user->name ?? 'Anonymous' }}</small><br>
                    <small><strong>Order ID:</strong> {{ $feedback->order_id }}</small>
                </div>
            @endforeach
        </div>
    </section>
@else
    <p class="text-center mt-3 text-muted">No feedback available for this seller yet.</p>
@endif




<a href="{{ route('cart.view') }}" class="cart-icon">
    <span class="icon">🛒</span>
    <span class="count">
        {{ Session::get('cart') ? array_sum(array_column(Session::get('cart'), 'quantity')) : 0 }}
    </span>
</a>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqI+K+hHdzprg5sxVtbuK0aW9syD1Lg/eVbBpQTSQH+Xx" crossorigin="anonymous"></script>

</body>
</html>
