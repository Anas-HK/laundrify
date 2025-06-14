<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundrify - Your Laundry Service Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
/* Modern Logo Styles */
.logo-container {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 1;
}

.logo-icon {
    font-size: 1.5rem;
    color: var(--white, #fff);
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4361ee, #3a56d4);
    border-radius: 50%;
    margin-right: 0.75rem;
    box-shadow: 0 4px 8px rgba(67, 97, 238, 0.25);
}

.logo-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 1.25rem;
    color: #2d3748;
    position: relative;
}

.logo-text::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 70%;
    height: 2px;
    background: linear-gradient(135deg, #4361ee, #3a56d4);
    border-radius: 8px;
}

/* Favorite button styling */
.favorite-btn {
    transition: all 0.2s ease;
    background: transparent;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.favorite-btn:hover {
    transform: scale(1.1);
    background-color: rgba(220, 53, 69, 0.1);
}

.favorite-btn i {
    font-size: 1.2rem;
    color: #6c757d;
}

.favorite-btn i.fas {
    color: #dc3545;
    animation: heartPulse 0.3s ease-in-out;
}

@keyframes heartPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.favorite-btn.active-favorite {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.favorite-btn.active-favorite i {
    color: white;
}
</style>
</head>
<body>
    {{-- <pre>{{ var_dump(session()->all()) }}</pre> --}}
    <!-- Toast notification container - fixed position that doesn't overflow -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 70px;">
        @if(session('success'))
            <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    
        @if(session('error'))
            <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

<!-- Modern, consistent navbar -->
<header class="navbar-main">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="#home">
                    <div class="logo-container">
                        <i class="fas fa-tshirt logo-icon"></i>
                        <span class="logo-text">Laundrify</span>
                    </div>
                </a>
            </div>
            
            <div class="search-bar">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input 
                        type="text" 
                        id="serviceSearch" 
                        placeholder="Search for services..." 
                        onkeyup="searchServices()" 
                        onclick="toggleSearchResults()"
                    />
                </div>
                <div id="searchResults" class="search-results" style="display: none;"></div>
            </div>
            
            <div class="nav-links">
                <a href="#home" class="nav-link active">Home</a>
                <a href="#sellers" class="nav-link">Sellers</a>
                <a href="#services" class="nav-link">Services</a>
                <a href="#about" class="nav-link">About</a>
            </div>

            <div class="nav-actions">
                <!-- Notification dropdown with improved styling -->
                <div class="notification-dropdown dropdown">
                    <button class="notification-btn" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end notification-menu" aria-labelledby="notificationDropdown">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            @auth
                                <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm p-0 text-primary">Mark all as read</button>
                                </form>
                            @endauth
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @auth
                            @php
                                $notifications = Auth::user()->notifications()->latest()->take(5)->get();
                            @endphp
                            @if(count($notifications) > 0)
                                @foreach($notifications as $notification)
                                    <li class="notification-item dropdown-item {{ is_null($notification->read_at) ? 'unread' : '' }}" data-id="{{ $notification->id }}">
                                        <a href="{{ $notification->data['service_url'] ?? '#' }}" class="notification-link">
                                            <div class="notification-content">
                                                <p>{{ $notification->data['message'] ?? 'No message available' }}</p>
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-footer"><a href="#">View All Notifications</a></li>
                            @else
                                <li class="notification-empty">No notifications yet</li>
                            @endif
                        @else
                            <li class="notification-empty">Please login to see notifications</li>
                        @endauth
                    </ul>
                </div>

                <!-- User profile dropdown with improved styling -->
                <div class="profile-dropdown dropdown">
                    @auth
                        @php
                            $profileUpdate = \App\Models\UserProfileUpdate::where('user_id', Auth::id())->first();
                        @endphp
                        <button class="profile-btn" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($profileUpdate && $profileUpdate->profile_image)
                                <img src="{{ asset('storage/' . $profileUpdate->profile_image) }}" alt="Profile Image" class="profile-img">
                            @else
                                <div class="profile-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                            <li class="dropdown-header">Welcome, {{ Auth::user()->name }}!</li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i>Update Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('favorites.index') }}"><i class="fas fa-heart me-2"></i>My Favorites</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.all') }}"><i class="fas fa-shopping-bag me-2"></i>View Your Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.history') }}"><i class="fas fa-history me-2"></i>Order History</a></li>
                            <li><hr class="dropdown-divider"></li>
                            @if(Auth::user()->sellerType == 1)
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</a></li>
                            @elseif(Auth::user()->sellerType == 3)
                                <li><a class="dropdown-item" href="{{ route('seller.panel') }}"><i class="fas fa-store me-2"></i>Seller Panel</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('register.seller') }}"><i class="fas fa-user-plus me-2"></i>Register as Seller</a></li>
                            <li><a class="dropdown-item" href="{{ route('login.seller') }}"><i class="fas fa-sign-in-alt me-2"></i>Login as Seller</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <button class="profile-btn" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register.form') }}"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                        </ul>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile menu toggle button -->
            <div class="mobile-menu-toggle">
                <button type="button" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile menu dropdown -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="container">
            <div class="mobile-search">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search for services...">
                </div>
            </div>
            <div class="mobile-links">
                <a href="#home" class="active">Home</a>
                <a href="#sellers">Sellers</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>
                @auth
                    <a href="{{ route('profile.edit') }}">Update Profile</a>
                    <a href="{{ route('favorites.index') }}"><i class="fas fa-heart"></i> My Favorites</a>
                    <a href="{{ route('orders.all') }}">View Your Orders</a>
                    <a href="{{ route('orders.history') }}">Order History</a>
                    @if(Auth::user()->sellerType == 1)
                        <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    @elseif(Auth::user()->sellerType == 3)
                        <a href="{{ route('seller.panel') }}">Seller Panel</a>
                    @endif
                    <a href="{{ route('register.seller') }}">Register as Seller</a>
                    <a href="{{ route('login.seller') }}">Login as Seller</a>
                    <form method="POST" action="{{ route('logout') }}" class="mobile-logout">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register.form') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
</header>

<section class="slider" id="home">
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

<section class="sellers" id="sellers">
    <div class="container">
        <div class='text-center'>
            <h2 class="my-4" style="font-size: 40px">Our Sellers</h2>
        </div>
        @auth
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($sellers as $seller)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-img-top d-flex justify-content-center align-items-center" 
                                style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; overflow: hidden; margin: 0 auto;">
                                @if ($seller->profile_image)
                                    <img src="{{ $seller->profile_image }}" alt="{{ $seller->name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                @else
                                    <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                                @endif

                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">
                                    {{ $seller->name }}
                                    @if($seller->isVerified())
                                        <span class="verified-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="This seller has been verified by Laundrify">
                                            <i class="fas fa-check-circle"></i><span class="verified-text">Verified</span>
                                        </span>
                                    @endif
                                </h5>
                                <p class="card-text"><strong>City:</strong> {{ $seller->city }}</p>
                                <p class="card-text"><strong>Area:</strong> {{ $seller->area }}</p>
                                <a href="{{ route('sellers.services', ['sellerId' => $seller->id]) }}" class="btn btn-primary">View Services</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Please <a href="{{ route('login') }}">log in</a> to view our sellers.</p>
        @endauth
    </div>
</section>

<section class="services" id="services">
    <div class="container">
        <h2 class="my-4">Our Services</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @auth
                @if ($services->isEmpty())
                    <p>No services available.</p>
                @else
                    @foreach ($services as $service)
                        @if ($service->is_approved)
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-img-top d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; overflow: hidden; margin: 0 auto;">
                                    @if ($service->seller->profile_image)
                                        <img src="{{ $service->seller->profile_image }}" alt="{{ $service->seller->name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                    @else
                                        <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                                    @endif

                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-center">{{ $service->service_name }}</h5>

                                        <div class="service-details">
                                            <p><strong>Seller:</strong> 
                                                {{ $service->seller->name }}
                                                @if($service->seller->isVerified())
                                                    <span class="verified-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="This seller has been verified by Laundrify">
                                                        <i class="fas fa-check-circle"></i><span class="verified-text">Verified</span>
                                                    </span>
                                                @endif
                                            </p>
                                            <p><strong>Email:</strong> {{ $service->seller->email }}</p>
                                            <p><strong>City:</strong> {{ $service->seller->city }}</p>
                                            <p><strong>Area:</strong> {{ $service->seller->area }}</p>
                                            <p><strong>Start Price:</strong> {{ $service->service_price }} PKR</p>
                                        </div>

                                        <div class="d-flex justify-content-center" style="width: 100%; height: 200px; background-color: #f0f0f0; align-items: center; justify-content: center;">
                                        @if ($service->image)
                                            <img src="{{ $service->image }}" alt="{{ $service->service_name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                        @else
                                            <i class="fas fa-image" style="font-size: 70px; color: #aaa;"></i>
                                        @endif

                                        </div>

                                        <p class="card-text description-line-clamp">
                                            <strong>Description:</strong> {{ $service->service_description }}
                                        </p>

                                        <div class="service-meta d-flex justify-content-between">
                                            <p><strong>Availability:</strong> {{ $service->availability }}</p>
                                            <p><strong>Delivery Time:</strong> {{ $service->service_delivery_time }}</p>
                                        </div>

                                        <div class="button-container d-flex justify-content-between mt-auto">
                                        <a href="{{ route('sellers.services', ['sellerId' => $service->seller->id]) }}" class="btn btn-primary">Avail</a>
                                            @auth
                                            <button class="favorite-btn" 
                                                    data-service-id="{{ $service->id }}" 
                                                    data-is-favorited="false" 
                                                    onclick="toggleFavorite({{ $service->id }}, this)">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @else
                <p>Please <a href="{{ route('login') }}">log in</a> to see the services.</p>
            @endauth
        </div>
    </div>
</section>
<section class="feedback">
    <div class="container">
        <h2 style="font-size: 40px; text-align: center;">What Our Customers Say</h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($feedbacks as $feedback)
                    <div class="swiper-slide">
                        <div class="feedback-card p-4 shadow-sm border rounded">
                            <p style="font-size: 24px; font-weight: bold;">"{{ $feedback->feedback }}"</p>
                            
                            
                            <h5><strong>Order Date:</strong> {{ $feedback->order->created_at->format('d M Y - h:i A') }}</h5>

                            <h5><strong>Customer:</strong> {{ $feedback->user->name ?? 'Anonymous' }}</h5>
                            <h5><strong>Seller:</strong> {{ $feedback->seller->name ?? 'N/A' }}</h5>
                        </div>
                    </div>
                @endforeach
          
    </div>
</section>




<section class="about" id="about">
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

<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <!-- About Laundrify Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">About Laundrify</h5>
                <p>
                    Laundrify is your one-stop solution for hassle-free laundry services. From pickup to delivery, we ensure your clothes are handled with care, giving you more time for the things that matter.
                </p>
                <p>Because fresh, clean clothes make a difference!</p>
            </div>

            <!-- Tips & Tricks Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">Laundry Tips & Tricks</h5>
                <ul class="list-unstyled">
                    <li>✔️ Separate whites and colors to avoid bleeding.</li>
                    <li>✔️ Use cold water to preserve fabric quality.</li>
                    <li>✔️ Turn clothes inside out to reduce wear and tear.</li>
                    <li>✔️ Don't overload your washing machine for better results.</li>
                </ul>
            </div>

            <!-- Subscribe Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">Stay Connected</h5>
                <p>Join our newsletter to get updates and exclusive discounts.</p>
                <form action="#" method="POST" class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email" required>
                    <button class="btn btn-primary" type="submit">Subscribe</button>
                </form>
                <div class="mt-3">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4">
            <p class="mb-0">&copy; 2025 Laundrify. All rights reserved.</p>
            <p class="mb-0">Designed with ❤️ by the Laundrify Team.</p>
        </div>
    </div>
</footer>

<!-- Font Awesome for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>

<script>
    document.querySelector('.fas.fa-bell').addEventListener('click', function() {
        document.querySelector('.dropdown-menu').classList.toggle('show');
    });
</script>

<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Check if services are favorited
        checkFavoritedServices();
    });

    function checkFavoritedServices() {
        const favoriteButtons = document.querySelectorAll('.favorite-btn');
        favoriteButtons.forEach(button => {
            const serviceId = button.dataset.serviceId;
            fetch(`/favorites/is-favorited/${serviceId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isFavorited) {
                        button.dataset.isFavorited = 'true';
                        button.querySelector('i').classList.remove('far');
                        button.querySelector('i').classList.add('fas');
                        console.log('Service ' + serviceId + ' is favorited');
                    } else {
                        console.log('Service ' + serviceId + ' is not favorited');
                    }
                })
                .catch(error => {
                    console.error('Error checking favorites:', error);
                });
        });
    }

    function toggleFavorite(serviceId, button) {
        // Optimistic UI update - show the change immediately
        const isFavorited = button.dataset.isFavorited === 'true';
        const icon = button.querySelector('i');
    
        if (!isFavorited) {
            // Optimistically mark as favorited
            button.dataset.isFavorited = 'true';
            icon.classList.remove('far');
            icon.classList.add('fas');
        } else {
            // Optimistically mark as unfavorited
            button.dataset.isFavorited = 'false';
            icon.classList.remove('fas');
            icon.classList.add('far');
        }
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Make the API call in the background
        fetch(`/favorites/toggle/${serviceId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
            .then(data => {
            // If the server response doesn't match our optimistic update, revert
            if (data.success && data.isFavorited !== (button.dataset.isFavorited === 'true')) {
                button.dataset.isFavorited = data.isFavorited ? 'true' : 'false';
                if (data.isFavorited) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
                }
            })
            .catch(error => {
            console.error('Error:', error);
            // On error, revert to original state
            button.dataset.isFavorited = isFavorited ? 'true' : 'false';
            if (isFavorited) {
                icon.classList.remove('far');
                icon.classList.add('fas');
    } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
    }
});
    }
</script>


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

    
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 3000,
        },
    });

</script>

<script>
    // Initialize all toasts
    document.addEventListener('DOMContentLoaded', function() {
        var toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toast) {
            var bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 5000
            });
            bsToast.show();
        });
    });
</script>
</html>