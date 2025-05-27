<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laundrify')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="navbar-main">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        @include('components.logo')
                    </a>
                </div>
                
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    @auth
                    <a href="{{ route('favorites.index') }}" class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                        <i class="fas fa-heart"></i> Favorites
                    </a>
                    @endauth
                    <a href="{{ route('cart.view') }}" class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a>
                    <a href="{{ route('order.all') }}" class="nav-link {{ request()->routeIs('order.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i> Orders
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Laundrify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html> 