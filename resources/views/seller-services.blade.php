<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Services</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<section class="seller-services">
    <div class="container">
        <h2>Services by {{ $seller->name }}</h2>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if ($services->isEmpty())
            <p>No services available for this seller.</p>
        @else
            <div class="service-cards">
                @foreach ($services as $service)
                    <div class="service-card">
                        <h3>{{ $service->service_name }}</h3>
                        <p>Start Price: {{ $service->service_price }} PKR</p>
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" width="200">
                        @endif
                        <p><strong>Description:</strong> {{ $service->service_description }}</p>
                        <div class="button-container">
                            <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                            <a href="#" class="btn btn-secondary see-more">See More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Cart Icon with Count -->
<a href="{{ route('cart.view') }}" class="cart-icon">
    <span class="icon">🛒</span>
    <span class="count">{{ Session::get('cart') ? count(Session::get('cart')) : 0 }}</span>
</a>

</body>
</html>
