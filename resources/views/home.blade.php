<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Global Styles for Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-items: center;
        }

        /* Individual Product Card */
        .product-card {
            background-color: #fff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;  /* Rounded corners */
            padding: 20px;
            width: 100%;
            max-width: 350px;  /* Increased width for better content fit */
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #ddd;  /* Border to define card edges */
            display: flex;
            flex-direction: column; /* Vertical layout for content */
            justify-content: space-between; /* Ensures equal spacing */
            height: 100%;  /* Stretch to fill available space */
        }

        .product-card:hover {
            transform: translateY(-8px);  /* Slightly less aggressive hover effect */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);  /* Stronger shadow on hover */
        }

        /* Service Name */
        .product-card h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        /* Price Styling */
        .product-card .price {
            font-size: 20px;
            color: #00796b;
            font-weight: bold;
            margin: 10px 0;
        }

        /* Image */
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;  /* Ensures the image is well cropped */
            border-radius: 8px;
            margin-bottom: 15px;
        }

        /* Additional Information Styling */
        .product-card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
            text-align: left;
        }

        /* Strong Text Styling */
        .product-card p strong {
            font-weight: bold;
            color: #333;
        }

        /* Button Container */
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Avail Button */
        .buy-now {
            background-color: #00796b;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 48%;  /* Reduced button width for better spacing */
        }

        .buy-now:hover {
            background-color: #004d40;
        }

        /* See More Link */
        .see-more {
            text-decoration: none;
            color: #00796b;
            font-size: 14px;
            transition: color 0.3s ease;
            width: 48%;
            text-align: right;  /* Align see more to the right */
        }

        .see-more:hover {
            color: #004d40;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .product-card {
                max-width: 100%;
                padding: 15px;
            }

            .product-card h2 {
                font-size: 20px;
            }

            .product-card .price {
                font-size: 18px;
            }

            .buy-now, .see-more {
                width: 100%;  /* Full width buttons on smaller screens */
                text-align: center;
                margin-bottom: 10px;
            }
        }

    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">Laundrify</div>
        <div class="menu-toggle">&#9776;</div>
        <div class="nav-items">
            <div class="dropdown">
                <button class="dropbtn">All Category &#9662;</button>
            </div>
            <!-- If the user is not authenticated, show Login and Register buttons -->
            @guest
            <a href="{{ route('login.seller') }}" class="nav-btn">LOGIN AS SELLER</a>
            <a href="{{ route('login') }}" class="nav-btn">LOGIN AS BUYER</a>
            @endguest
    
            <div class="search-container">
                <input type="text" placeholder="Search this blog">
                <button type="submit">&#128269;</button>
            </div>
            <div class="dropdown">
                <button class="dropbtn">English &#9662;</button>
            </div>

            <!-- Check if user is authenticated -->
            @auth
                <span>Welcome, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn logout-btn">Logout</button>
                </form>
                @if(Auth::user()->sellerType == 1)
                    <a href="{{ route('admin.dashboard') }}" class="nav-btn">Admin Dashboard</a>
                @elseif(Auth::user()->sellerType == 3)
                    <a href="{{ route('seller.panel') }}" class="nav-btn">Seller Panel</a>
                @endif
            @endauth
        </div>
    </nav>
</header>

<main>
    <div class="hero">
        <h1>GET STARTED<br>WITH LAUNDRIFY</h1>
        <button class="cta-btn">BUY NOW</button>
    </div>
</main>

<h1 class="main-service-heading">Our Services</h1>

<!-- Only show products if the user is authenticated -->
@auth
    <div class="product-grid">
        @foreach ($services as $service)
            <div class="product-card">
                <h2>{{ $service->service_name }}</h2>
                <p class="price">Start Price: {{ $service->service_price }} PKR</p>
                
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}">

                <p><strong>Description:</strong> {{ $service->service_description }}</p>
                <p><strong>City:</strong> {{ $service->seller_city }}</p>
                <p><strong>Area:</strong> {{ $service->seller_area }}</p>
                <p><strong>Availability:</strong> {{ $service->availability }}</p>
                <p><strong>Delivery Time:</strong> {{ $service->service_delivery_time }}</p>
                <p><strong>Contact No:</strong> {{ $service->seller_contact_no }}</p>

                <div class="button-container">
                    <button class="buy-now">Avail</button>
                    <a href="#" class="see-more">See More</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Please log in to see the services.</p>
@endauth

<footer>
    <div class="footer-bottom">
        <p>&copy; 2024 Laundrify. All rights reserved.</p>
    </div>
</footer>
</body>
</html>