<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller Panel - Laundrify</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerLayout.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('seller.panel') }}">
                <div class="logo-container">
                    <i class="fas fa-tshirt logo-icon"></i>
                    <span class="logo-text">Laundrify</span>
                </div>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Nav Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.panel') ? 'active' : '' }}" href="{{ route('seller.panel') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('add.service') ? 'active' : '' }}" href="{{ route('add.service') }}">
                            <i class="fas fa-plus-circle me-1"></i> Add Service
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.earnings') ? 'active' : '' }}" href="{{ route('seller.earnings') }}">
                            <i class="fas fa-wallet me-1"></i> Earnings
                        </a>
                    </li>
                    @if(auth()->guard('seller')->user() && !auth()->guard('seller')->user()->is_verified)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('seller.verification.apply') ? 'active' : '' }}" href="{{ route('seller.verification.apply') }}">
                            <i class="fas fa-certificate me-1"></i> Get Verified
                        </a>
                    </li>
                    @endif
                    
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->guard('seller')->user() ? auth()->guard('seller')->user()->name : 'User' }}
                            @if(auth()->guard('seller')->user() && auth()->guard('seller')->user()->is_verified)
                            <span class="verified-badge">
                                <i class="fas fa-check-circle"></i>
                                <span class="verified-text">Verified</span>
                            </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(session('admin_id'))
                                <li>
                                    <form action="{{ route('admin.returnToAdmin') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-primary">
                                            <i class="fas fa-user-shield me-2"></i> Return to Admin
                                        </button>
                                    </form>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form id="logout-form" action="{{ route('logout.seller') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Success Messages -->
            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            <!-- Content -->
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>