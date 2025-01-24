<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundrify - Your Laundry Service Solution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
</head>
<body>
    {{-- <pre>{{ var_dump(session()->all()) }}</pre> --}}
    <div class="container-fluid fixed-top" style="top: 56px; z-index: 1030;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">Laundrify</div>
            <div class="search-bar">
                <input 
                    type="text" 
                    id="serviceSearch" 
                    placeholder="Search for services..." 
                    onkeyup="searchServices()" 
                    onclick="toggleSearchResults()"
                />
                <div id="searchResults" class="search-results" style="display: none;"></div>
            </div>
            
            <div class="nav-icons">
                <!-- Static Navigation Links -->
                <a href="#home">Home</a>
                <a href="#sellers">Sellers</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>

                <!-- Notification Icon with Dropdown -->
                <div class="notification-dropdown dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @auth
                            @php
                                $unreadCount = Auth::user()->unreadNotifications->count();
                            @endphp

                            @if($unreadCount > 0)
                                <span class="badge bg-danger rounded-pill position-absolute top-0 end-0 translate-middle" style="font-size: 0.75rem;">{{ $unreadCount }}</span>
                            @endif
                        @endauth
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <span>Notifications</span>
                            @auth
                                <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-sm text-muted">Mark all as read</button>
                                </form>
                            @endauth
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @auth
                            @php
                                $notifications = Auth::user()->notifications()->latest()->take(5)->get();
                            @endphp
                            @forelse($notifications as $notification)
                                <li class="dropdown-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}" data-id="{{ $notification->id }}">
                                    <a href="{{ route('notifications.redirect', $notification->id) }}" class="text-dark">
                                        {{ $notification->data['message'] ?? 'No message available' }}
                                    </a>
                                </li>
                            @empty
                                <li class="dropdown-item text-muted">No notifications available</li>
                            @endforelse
                        @else
                            <li class="dropdown-item text-muted">Please login to see notifications.</li>
                        @endauth
                    </ul>
                </div>

                <!-- Profile Icon with Dropdown -->
                <div class="dropdown">
                    @auth
                        @php
                            $profileUpdate = \App\Models\UserProfileUpdate::where('user_id', Auth::id())->first();
                        @endphp
                        <button class="btn btn-link dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($profileUpdate && $profileUpdate->profile_image)
                                <img src="{{ asset('storage/' . $profileUpdate->profile_image) }}" alt="Profile Image" class="rounded-circle" style="width: 30px; height: 30px;">
                            @else
                                <i class="fas fa-user-circle" style="font-size: 30px;"></i>
                            @endif
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><span class="dropdown-item">Welcome, {{ Auth::user()->name }}!</span></li>
                            <li><a href="{{ route('profile.edit') }}" class="dropdown-item">Update Profile</a></li>
                            <li><a href="{{ route('order.all') }}" class="dropdown-item">View Your Orders</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none">Logout</button>
                                </form>
                            </li>
                            @if(Auth::user()->sellerType == 1)
                                <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin Dashboard</a></li>
                            @elseif(Auth::user()->sellerType == 3)
                                <li><a href="{{ route('seller.panel') }}" class="dropdown-item">Seller Panel</a></li>
                            @endif
                            <li><a href="{{ route('register.seller') }}" class="dropdown-item">Register as Seller</a></li>
                            <li><a href="{{ route('login.seller') }}" class="dropdown-item">Login as Seller</a></li>
                        </ul>
                    @else
                        <button class="btn btn-link dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle" style="font-size: 30px;"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                            <li><a href="{{ route('register') }}" class="dropdown-item">Register</a></li>
                        </ul>
                    @endauth
                </div>
                
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
                                @if ($seller->profile_image && file_exists(public_path('storage/' . $seller->profile_image)))
                                    <img src="{{ asset('storage/' . $seller->profile_image) }}" alt="{{ $seller->name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                @else
                                    <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                                @endif
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $seller->name }}</h5>
                                <p class="card-text"><strong>City:</strong> {{ $seller->city }}</p>
                                <p class="card-text"><strong>Area:</strong> {{ $seller->area }}</p>
                                <a href="{{ route('seller.services', $seller->id) }}" class="btn btn-primary">View Services</a>
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
                                    <!-- Seller Profile Image -->
                                    <div class="card-img-top d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; overflow: hidden; margin: 0 auto;">
                                        @if ($service->seller->profile_image && file_exists(public_path('storage/' . $service->seller->profile_image)))
                                            <img src="{{ asset('storage/' . $service->seller->profile_image) }}" alt="{{ $service->seller->name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                        @else
                                            <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                                        @endif
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-center">{{ $service->service_name }}</h5>

                                        <div class="service-details">
                                            <p><strong>Seller:</strong> {{ $service->seller->name }}</p>
                                            <p><strong>Email:</strong> {{ $service->seller->email }}</p>
                                            <p><strong>City:</strong> {{ $service->seller->city }}</p>
                                            <p><strong>Area:</strong> {{ $service->seller->area }}</p>
                                            <p><strong>Start Price:</strong> {{ $service->service_price }} PKR</p>
                                        </div>

                                        <!-- Service Image with Font Awesome Icon as Placeholder -->
                                        <div class="d-flex justify-content-center" style="width: 100%; height: 200px; background-color: #f0f0f0; align-items: center; justify-content: center;">
                                            @if ($service->image && file_exists(public_path('storage/' . $service->image)))
                                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                            @else
                                                <i class="fas fa-image" style="font-size: 70px; color: #aaa;"></i>
                                            @endif
                                        </div>

                                        <!-- Description (Limited to 3-4 lines) -->
                                        <p class="card-text description-line-clamp">
                                            <strong>Description:</strong> {{ $service->service_description }}
                                        </p>

                                        <div class="service-meta d-flex justify-content-between">
                                            <p><strong>Availability:</strong> {{ $service->availability }}</p>
                                            <p><strong>Delivery Time:</strong> {{ $service->service_delivery_time }}</p>
                                        </div>

                                        <div class="button-container d-flex justify-content-between mt-auto">
                                            <button class="btn btn-primary">Avail</button>
                                            <a href="#" class="btn btn-outline-secondary">See More</a>
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
        <h2 style="font-size: 40px">What Our Customers Say</h2>
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
                    <li>✔️ Don’t overload your washing machine for better results.</li>
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
// Function to search for services
function searchServices() {
    let searchTerm = document.getElementById('serviceSearch').value;
    let resultContainer = document.getElementById('searchResults');

    if (searchTerm.length >= 3) {
        fetch(`/search-services?q=${searchTerm}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                let results = data.services || [];
                resultContainer.innerHTML = '';

                if (results.length > 0) {
                    resultContainer.style.display = 'block';  // Show results container
                    results.forEach(service => {
                        let name = service.service_name || "Unnamed Service";
                        let description = service.service_description || "No description available";

                        resultContainer.innerHTML += `
                            <div class="service-item">
                                <h5>${name}</h5>
                                <p>${description}</p>
                            </div>
                        `;
                    });
                } else {
                    resultContainer.style.display = 'none';  // Hide results if no services found
                    resultContainer.innerHTML = '<p>No services found.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
                resultContainer.style.display = 'none';  // Hide results in case of error
                resultContainer.innerHTML = '<p>An error occurred while searching. Please try again.</p>';
            });
    } else {
        resultContainer.style.display = 'none';  // Hide results if search term is too short
        resultContainer.innerHTML = '';
    }
}

// Function to toggle the visibility of search results
function toggleSearchResults() {
    let resultContainer = document.getElementById('searchResults');
    resultContainer.style.display = 'block';  // Always show when clicking on the search input
}

// Function to handle click outside of search bar
document.addEventListener('click', function(event) {
    const searchBar = document.getElementById('serviceSearch');
    const resultContainer = document.getElementById('searchResults');

    // Hide results if clicked outside search bar and results container
    if (!searchBar.contains(event.target) && !resultContainer.contains(event.target)) {
        resultContainer.style.display = 'none';
    }
});

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
</script>
</html>