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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/logo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sellerPanel.css') }}">
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
                        <a class="nav-link active" href="{{ route('seller.panel') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('add.service') }}">
                            <i class="fas fa-plus-circle me-1"></i> Add Service
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.earnings') }}">
                            <i class="fas fa-wallet me-1"></i> Earnings
                        </a>
                    </li>
                    @if(!auth()->guard('seller')->user()->is_verified)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.verification.apply') }}">
                            <i class="fas fa-certificate me-1"></i> Get Verified
                        </a>
                    </li>
                    @endif
                    
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link notification-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if($notifications->isNotEmpty())
                                <span class="notification-badge">{{ $notifications->count() }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notification-dropdown-menu" aria-labelledby="notificationDropdown">
                            <li>
                                <div class="dropdown-header">
                                    <i class="fas fa-bell me-2"></i> Notifications
                                </div>
                            </li>
                            <div class="notification-list">
                                @if($notifications->isEmpty())
                                    <li class="dropdown-item text-center py-3">
                                        <span class="text-muted">No notifications available</span>
                                    </li>
                                @else
                                    @foreach($notifications as $notification)
                                        <li class="dropdown-item notification-item">
                                            <div class="notification-content">
                                                @if(is_string($notification->data['order_details']))
                                                    @php
                                                        $details = json_decode($notification->data['order_details'], true);
                                                    @endphp
                                                @else
                                                    @php
                                                        $details = $notification->data['order_details'];
                                                    @endphp
                                                @endif
                                                
                                                <p>
                                                    <strong>New Order from {{ $notification->data['seller_name'] }}</strong><br>
                                                    Order ID: <span class="text-primary">#{{ $notification->data['order_id'] }}</span>
                                                    
                                                    @if(is_array($details))
                                                        <br>
                                                        <small class="notification-time">
                                                            @foreach($details as $detail)
                                                                Service: #{{ $detail['service_id'] }}, 
                                                                Qty: {{ $detail['quantity'] }}, 
                                                                Price: {{ $detail['price'] }} PKR<br>
                                                            @endforeach
                                                        </small>
                                                    @endif
                                                </p>
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </div>
                        </ul>
                    </li>
                    
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ auth()->guard('seller')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            @if(session('admin_id'))
                                <li>
                                    <form action="{{ route('admin.returnToAdmin') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-user-shield me-2"></i> Return to Admin
                                        </button>
                                    </form>
                                </li>
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

    <main class="main-content">
        <div class="container dashboard-container">
            <!-- Welcome Card -->
            <div class="welcome-card animate__animated animate__fadeIn">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">Welcome, {{ auth()->guard('seller')->user()->name }}!</h1>
                        <p class="welcome-text">Manage your laundry services, track orders, and grow your business.</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="fas fa-store welcome-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards Row -->
            <div class="row stats-row">
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn">
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $services->count() }}</h3>
                            <p class="stats-label">Total Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
                        <div class="stats-icon bg-success">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $orders->count() }}</h3>
                            <p class="stats-label">Total Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ isset($rating) ? number_format($rating, 1) : '0.0' }}</h3>
                            <p class="stats-label">Average Rating</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Toast Notifications -->
            @if (session('success'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
                <div class="toast show bg-white" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-success text-white">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Services Section -->
            <div class="section-card animate__animated animate__fadeIn">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-store"></i> Your Services
                    </h2>
                    <a href="{{ route('add.service') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus-circle me-1"></i> Add New
                    </a>
                </div>
                
                <div class="section-body">
                    @if($services->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>You haven't added any services yet. Add a service to get started!</p>
                            <a href="{{ route('add.service') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus-circle me-2"></i> Add Your First Service
                            </a>
                        </div>
                    @else
                        <div class="service-grid">
                            @foreach($services as $service)
                                <div class="service-card">
                                    <div class="service-image">
                                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->service_name }}" class="service-img">
                                        <div class="service-overlay">
                                            <div class="service-actions">
                                                <a href="{{ route('seller.editService', $service->id) }}" class="btn btn-sm btn-light">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('seller.deleteService', $service->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light" onclick="return confirm('Are you sure you want to delete this service?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="service-body">
                                        <h3 class="service-title">{{ $service->service_name }}</h3>
                                        <p class="service-price">{{ $service->service_price }} PKR</p>
                                        <div class="service-footer">
                                            <span class="service-category">
                                                <i class="fas fa-tag me-1"></i> {{ $service->category ?? 'Laundry' }}
                                            </span>
                                            <a href="{{ route('seller.editService', $service->id) }}" class="service-edit-link">
                                                Edit <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Orders Section -->
            <div class="section-card animate__animated animate__fadeIn">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-shopping-bag"></i> Recent Orders
                    </h2>
                </div>
                
                <div class="section-body">
                    @if($orders->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p>No orders found. Orders will appear here when customers place them.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Buyer</th>
                                        <th>Services</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->take(5) as $order)
                                        <tr>
                                            <td>
                                                <span class="fw-medium">#{{ $order->id }}</span>
                                                <div class="small text-muted">{{ $order->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>
                                                <div class="services-list">
                                                    @foreach($order->items->take(2) as $item)
                                                        <div>{{ $item->service->service_name }} × {{ $item->quantity }}</div>
                                                    @endforeach
                                                    @if($order->items->count() > 2)
                                                        <div class="small text-muted">+{{ $order->items->count() - 2 }} more</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold">{{ $order->total_amount ?? 'N/A' }} PKR</span>
                                            </td>
                                            <td class="text-md-center">
                                                <div class="badge status-{{ $order->status }}">
                                                    <i class="fas fa-circle"></i> {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                @if($order->status === 'pending')
                                                    <div class="btn-group">
                                                        <form action="{{ route('order.acceptReject', $order) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" name="status" value="accepted" class="btn btn-sm btn-success me-1">
                                                                <i class="fas fa-check me-1"></i> Accept
                                                            </button>
                                                            <button type="submit" name="status" value="rejected" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <a href="{{ route('seller.order.handle', $order) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye me-1"></i> Details
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Laundrify. All rights reserved.</p>
        </div>
    </footer>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Initialize toasts
        document.addEventListener('DOMContentLoaded', function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
            });
            
            // Auto-hide toasts after 5 seconds
            setTimeout(function() {
                toastList.forEach(toast => toast.hide());
            }, 5000);
            
            // Enable all tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
