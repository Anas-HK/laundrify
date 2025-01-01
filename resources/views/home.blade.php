<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundrify - Your Laundry Service Solution</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            /* max-width: 1200px; */
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header styles */
        header {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .nav-icons {
            display: flex;
            align-items: center;
        }

        .nav-icons a {
            margin-left: 15px;
            color: #333;
            text-decoration: none;
        }

        .profile-icon {
            margin-left: 15px;
            color: #333;
            font-size: 24px;
            cursor: pointer;
        }
        
    /* ...existing styles... */
    .profile-dropdown {
    position: relative;
    display: inline-block;
}

.profile-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px;
    overflow: hidden;
    min-width: 200px;
}

.profile-dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-menu span {
    display: block;
    padding: 12px 16px;
    font-weight: bold;
    background-color: #f1f1f1;
    border-bottom: 1px solid #ddd;
}

.dropdown-item {
    display: block;
    padding: 12px 16px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s ease-in-out;
}

.dropdown-item:hover {
    background-color: #f1f1f1;
}

.logout-btn {
    background: none;
    border: none;
    color: #333;
    width: 100%;
    text-align: left;
    padding: 12px 16px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.logout-btn:hover {
    background-color: #f1f1f1;
}

@media (max-width: 768px) {
    .dropdown-menu {
        right: auto;
        left: 0;
        min-width: 100%;
    }
}

/* Add necessary CSS for the dropdown visibility */
.notification-dropdown {
    position: relative;
    display: inline-block;
}

.notification-count {
    background-color: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 6px;
    position: absolute;
    top: -5px;
    right: -5px;
}

.dropdown-item.unread {
    font-weight: bold;
    background-color: #f9f9f9;
    color: red;
}

.dropdown-item.unread:hover {
    background-color: #e2e2e2;
}

.notification-dropdown .dropdown-menu {
    max-height: 300px; /* Set the maximum height */
    overflow-y: auto; /* Enable vertical scrolling */
    background-color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
}

.notification-dropdown .notification-list {
    max-height: 250px; /* Set the maximum height for the list */
    overflow-y: auto; /* Enable vertical scrolling */
}

.notification-dropdown .fa-bell {
    font-size: 20px;
    cursor: pointer;
    color: #333;
    margin: 20px;
}

.notification-dropdown .dropdown-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background-color: #f1f1f1;
    border-bottom: 1px solid #ddd;
}

.notification-dropdown .mark-read {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 3px;
}

.notification-dropdown .mark-read:hover {
    background-color: #0056b3;
}

.notification-dropdown .dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    background-color: #fff;
    min-width: 300px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
}

.notification-dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown-item {
    padding: 15px 20px;
    text-decoration: none;
    color: #333;
    display: block;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s ease;
}

.dropdown-item:hover {
    background-color: #f5f5f5;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-footer {
    padding: 10px 20px;
    background-color: #f1f1f1;
    text-align: center;
    border-top: 1px solid #ddd;
}

.dropdown-footer a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

.dropdown-footer a:hover {
    text-decoration: underline;
}


        /* Slider section styles */
        .slider {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .slider .container {
            position: relative;
            height: 100%;
        }

        .slider-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #ffffff;
            z-index: 2;
            width: 80%;
            max-width: 800px;
        }

        .slider-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .slider-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slider-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .slider h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .slider p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .slider .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .slider .btn:hover {
            background-color: #2980b9;
        }

        @media (max-width: 768px) {
            .slider h1 {
                font-size: 2rem;
            }

            .slider p {
                font-size: 1rem;
            }

            .slider .btn {
                padding: 10px 20px;
                font-size: 1rem;
            }
        }

        /* USP section styles */
        .usp {
            padding: 50px 0;
            text-align: center;
        }

        .usp h2 {
            margin-bottom: 30px;
        }

        .usp-cards {
            display: flex;
            justify-content: space-between;
            gap: 30px;
        }

        .usp-card {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .usp-card:hover {
            transform: translateY(-5px);
        }

        /* Services section styles */
        .services {
        padding: 50px 0;
        background-color: #f9f9f9;
    }

    .seller-profile {
    width: 50px !important;  /* Size of the icon */
    height: 50px !important;
    border-radius: 50% !important;  /* Makes the image rounded */
    object-fit: cover !important;   /* Ensures the image fits nicely */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;  /* Optional - adds shadow for a professional look */
    margin-bottom: 10px !important;
}


    .services h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5rem;
        color: #333;
    }

    .service-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .service-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .service-card h3 {
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 10px;
    }

    .service-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .service-card p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 10px;
    }

    .service-card p strong {
        color: #333;
    }

    .button-container {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    .buy-now,
    .see-more {
        display: inline-block;
        text-decoration: none;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        font-size: 1rem;
        border-radius: 5px;
        transition: background-color 0.3s;
        cursor: pointer;
    }

    .buy-now:hover,
    .see-more:hover {
        background-color: #0056b3;
    }

    .buy-now {
        background-color: #28a745;
    }

    .buy-now:hover {
        background-color: #218838;
    }


        /* Feedback section styles */
        .feedback {
            padding: 50px 0;
        }

        .feedback h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .feedback-cards {
            display: flex;
            justify-content: space-between;
            gap: 30px;
        }

        .feedback-card {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        /* About section styles */
        .about {
            background-color: #f9f9f9;
            padding: 50px 0;
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-text {
            flex: 1;
        }

        .about-image {
            flex: 1;
        }

        .about-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        /* Footer styles */
        footer {
            background-color: #333;
            color: #fff;
            padding: 30px 0;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
        }

        .footer-section {
            flex: 1;
            margin-right: 30px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #555;
        }
        .nav-btn {
            margin-left: 10px;
            padding: 8px 12px;
            color: #fff;
            background-color: #00796b;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-btn:hover {
            background-color: #004d40;
        }

        .logout-btn {
            background-color: #e53935;
        }

        .logout-btn:hover {
            background-color: #b71c1c;
        }
        .seller-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.seller-card {
    border: 1px solid #ccc;
    padding: 15px;
    text-align: center;
    border-radius: 8px;
    width: 200px;
}

.seller-profile-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}

.view-services-button {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

.view-services-button:hover {
    background-color: #0056b3;
}




    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">Laundrify</div>
            <div class="search-bar">
                <input type="text" placeholder="Search for services...">
            </div>
            <div class="nav-icons">
                <!-- Static Navigation Links -->
                <a href="#">Home</a>
                <a href="#">Services</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
<!-- Notification Icon with Dropdown -->
<!-- Notification Icon with Dropdown -->
<div class="notification-dropdown">
    <i class="fas fa-bell"></i>
    @auth
        @php
            $unreadCount = Auth::user()->unreadNotifications->count();
        @endphp
        @if($unreadCount > 0)
            <span class="notification-count">{{ $unreadCount }}</span>
        @endif
        <div class="dropdown-menu">
            <div class="dropdown-header">
                <span>Notifications</span>
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="mark-all-form">
                    @csrf
                    <button type="submit" class="mark-read">Mark all as read</button>
                </form>
            </div>
            @php
                $notifications = Auth::user()->notifications()->latest()->take(5)->get();
            @endphp
            <div class="notification-list">
                @foreach($notifications as $notification)
                    <div class="dropdown-item {{ is_null($notification->read_at) ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                        <a href="{{ route('notifications.redirect', $notification->id) }}" class="notification-link">
                            {{ $notification->data['message'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="dropdown-item">Please login to see notifications.</div>
    @endauth
</div>
                <!-- Profile Icon with Dropdown -->
                <div class="profile-dropdown">
                    @auth
                        @php
                            $profileUpdate = \App\Models\UserProfileUpdate::where('user_id', Auth::id())->first();
                        @endphp
                        @if ($profileUpdate && $profileUpdate->profile_image)
                            <img src="{{ asset('storage/' . $profileUpdate->profile_image) }}" alt="Profile Image" class="profile-icon">

                        @else
                            <i class="fas fa-user-circle profile-icon"></i>
                        @endif
                        <div class="dropdown-menu">
                            <span>Welcome, {{ Auth::user()->name }}!</span>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Update Profile</a>
                            <a href="{{ route('order.all') }}" class="btn btn-primary" style="margin-top: 20px;">
    View Your Orders
</a>

                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                @csrf
                                <button type="submit" class="logout-btn">Logout</button>
                            </form>
                            @if(Auth::user()->sellerType == 1)
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin Dashboard</a>
                            @elseif(Auth::user()->sellerType == 3)
                                <a href="{{ route('seller.panel') }}" class="dropdown-item">Seller Panel</a>
                            @endif
                            <a href="{{ route('register.seller') }}" class="dropdown-item">Register as Seller</a>
                            <a href="{{ route('login.seller') }}" class="dropdown-item">Login as Seller</a>
                        </div>
                    @else
                        <i class="fas fa-user-circle profile-icon"></i>
                        <div class="dropdown-menu">
                            <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                            <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                        </div>
                        
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>

<section class="slider">
    <div class="container">
        <div class="slider-content">
            <h1>Welcome to Laundrify</h1>
            <p>Experience the convenience of professional laundry services at your doorstep. We take care of your clothes, so you can focus on what matters most.</p>
            <a href="#" class="btn">Get Started</a>
        </div>
        <div class="slider-image">
            <img src="{{ asset('images/main-body.jpg') }}" alt="Laundry Service">
        </div>
    </div>
</section>

<section class="usp">
    <div class="container">
        <h2>Why Choose Laundrify?</h2>
        <div class="usp-cards">
            <div class="usp-card">
                <h3>Quality Service</h3>
                <p>We use the best detergents and state-of-the-art equipment to ensure your clothes are cleaned to perfection.</p>
            </div>
            <div class="usp-card">
                <h3>Fast Turnaround</h3>
                <p>Get your clothes back in as little as 24 hours with our express service option.</p>
            </div>
            <div class="usp-card">
                <h3>Eco-Friendly</h3>
                <p>We use environmentally friendly cleaning methods to reduce our carbon footprint.</p>
            </div>
        </div>
    </div>
</section>
<section class="sellers">
    <div class="container">
        <h2>Our Sellers</h2>
        @auth
            <div class="seller-cards">
                @foreach ($sellers as $seller)
                    <div class="seller-card">
                        <img src="{{ asset('storage/' . $seller->profile_image) }}" alt="{{ $seller->name }}" class="seller-profile-icon">
                        <h3>{{ $seller->name }}</h3>
                        <p><strong>City:</strong> {{ $seller->city }}</p>
                        <p><strong>Area:</strong> {{ $seller->area }}</p>
                        <a href="{{ route('seller.services', $seller->id) }}" class="view-services-button">View Services</a>
                    </div>
                @endforeach
            </div>
        @else
            <p>Please <a href="{{ route('login') }}">log in</a> to view our sellers.</p>
        @endauth
    </div>
</section>

<section class="services">
    <div class="container">
        <h2>Our Services</h2>
        <div class="service-cards">
            @auth
                @if ($services->isEmpty())
                    <p>No services available.</p>
                @else
                    @foreach ($services as $service)
                        @if ($service->is_approved)
                            <div class="service-card">
                                <img src="{{ asset('storage/' . $service->seller->profile_image) }}" alt="{{ $service->seller->name }}" class="seller-profile">
                                <h3>{{ $service->service_name }}</h3>
                                <p><strong>Seller:</strong> {{ $service->seller->name }}</p>
                                <p><strong>Email:</strong> {{ $service->seller->email }}</p>
                                <p><strong>City:</strong> {{ $service->seller->city }}</p>
                                <p><strong>Area:</strong> {{ $service->seller->area }}</p>
                                <p><strong>Start Price:</strong> {{ $service->service_price }} PKR</p>
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}">>
                                <p><strong>Description:</strong> {{ $service->service_description }}</p>
                                <p><strong>Availability:</strong> {{ $service->availability }}</p>
                                <p><strong>Delivery Time:</strong> {{ $service->service_delivery_time }}</p>
                                <p><strong>Contact No:</strong> {{ $service->seller_contact_no }}</p>
                                <div class="button-container">
                                    <button class="buy-now">Avail</button>
                                    <a href="#" class="see-more">See More</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @else
                <p>Please log in to see the services.</p>
            @endauth
        </div>
    </div>
</section>

<section class="feedback">
    <div class="container">
        <h2>What Our Customers Say</h2>
        <div class="feedback-cards">
            <div class="feedback-card">
                <p>"Laundrify has made my life so much easier. Their service is fast, reliable, and my clothes always come back perfectly clean!"</p>
                <h4>- Sarah M.</h4>
            </div>
            <div class="feedback-card">
                <p>"I love how convenient Laundrify is. Their pickup and delivery service saves me so much time, and the quality is always top-notch."</p>
                <h4>- John D.</h4>
            </div>
            <div class="feedback-card">
                <p>"As a busy professional, Laundrify has been a game-changer for me. I can always count on them for clean, fresh clothes."</p>
                <h4>- Emily R.</h4>
            </div>
        </div>
    </div>
</section>

<section class="about">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>About Laundrify</h2>
                <p>Laundrify was founded with a simple mission: to make laundry day stress-free for our customers. We combine cutting-edge technology with eco-friendly practices to deliver the best laundry experience possible.</p>
                <p>Our team of experienced professionals is dedicated to providing top-quality service, ensuring that your clothes are treated with the utmost care and attention to detail.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('images/about-image.jpeg') }}" alt="About Laundrify">
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Wash & Fold</a></li>
                    <li><a href="#">Dry Cleaning</a></li>
                    <li><a href="#">Alterations</a></li>
                    <li><a href="#">Shoe Cleaning</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul>
                    <li>123 Laundry Street, City, Country</li>
                    <li>Phone: (123) 456-7890</li>
                    <li>Email: info@laundrify.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Laundrify. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>

<script>
    document.querySelectorAll('.notification-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const notificationId = this.closest('.dropdown-item').dataset.id;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ _method: 'PATCH' })
            }).then(response => {
                if (response.ok) {
                    this.closest('.dropdown-item').classList.remove('unread');
                    this.closest('.dropdown-item').classList.add('read');
                    const countElement = document.querySelector('.notification-count');
                    let count = parseInt(countElement.textContent);
                    countElement.textContent = count - 1;
                    window.location.href = this.href;
                }
            });
        });
    });
</script>
</html>