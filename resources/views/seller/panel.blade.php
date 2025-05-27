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
    <style>
        /* Styles for unread notifications */
        .notification-item.unread {
            background-color: rgba(13, 110, 253, 0.05);
            font-weight: 500;
        }
        
        .notification-item.unread::before {
            content: '';
            display: block;
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #0d6efd;
        }
        
        .notification-item {
            position: relative;
            padding-left: 20px;
        }
    </style>
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
                        <a class="nav-link notification-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="markNotificationsAsRead()">
                            <i class="fas fa-bell"></i>
                            @if($unreadNotificationsCount > 0)
                                <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
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
                                        <li class="dropdown-item notification-item {{ is_null($notification->read_at) ? 'unread' : '' }}">
                                            <div class="notification-content">
                                                @if(isset($notification->data['type']) && $notification->data['type'] == 'service_approved')
                                                    <p>
                                                        <strong><i class="fas fa-check-circle text-success"></i> Service Approved</strong><br>
                                                        {{ $notification->data['message'] }}
                                                    </p>
                                                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                                @elseif(isset($notification->data['order_id']) && isset($notification->data['cancellation_reason']))
                                                    <p>
                                                        <strong><i class="fas fa-times-circle text-danger"></i> Order Cancelled</strong><br>
                                                        {{ $notification->data['message'] }}
                                                        <br>
                                                        <small class="text-muted">Reason: {{ \Illuminate\Support\Str::limit($notification->data['cancellation_reason'], 50) }}</small>
                                                    </p>
                                                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                                @elseif(isset($notification->data['order_id']))
                                                    @if(isset($notification->data['order_details']) && is_string($notification->data['order_details']))
                                                        @php
                                                            $details = json_decode($notification->data['order_details'], true);
                                                        @endphp
                                                    @elseif(isset($notification->data['order_details']))
                                                        @php
                                                            $details = $notification->data['order_details'];
                                                        @endphp
                                                    @else
                                                        @php
                                                            $details = null;
                                                        @endphp
                                                    @endif
                                                    
                                                    <p>
                                                        <strong><i class="fas fa-shopping-bag text-primary"></i> New Order from {{ $notification->data['seller_name'] ?? 'Customer' }}</strong><br>
                                                        Order ID: <span class="text-primary">#{{ $notification->data['order_id'] }}</span>
                                                        
                                                        @if(is_array($details))
                                                            <br>
                                                            <small class="notification-time">
                                                                @foreach($details as $detail)
                                                                    Service: #{{ $detail['service_id'] ?? 'N/A' }}, 
                                                                    Qty: {{ $detail['quantity'] ?? 'N/A' }}, 
                                                                    Price: {{ $detail['price'] ?? 'N/A' }} PKR<br>
                                                                @endforeach
                                                            </small>
                                                        @endif
                                                    </p>
                                                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                                @endif
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
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $feedbacks->count() }}</h3>
                            <p class="stats-label">Customer Feedback</p>
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
                        <i class="fas fa-shopping-bag"></i> Your Orders
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
                                        <th>Payment Type</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
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

                                            <!-- ✅ Payment Type Column -->
                                            <td>
                                                @if($order->transaction_id)
                                                    <span class="badge bg-info text-dark">Online</span>
                                                    <div class="small text-muted">Txn: {{ $order->transaction_id }}</div>
                                                @else
                                                    <span class="badge bg-secondary">Cash on Delivery</span>
                                                @endif
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
            <!-- Customer Feedback Section -->
            <div class="section-card animate__animated animate__fadeIn">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-comment"></i> Customer Feedback
                    </h2>
                </div>
                
                <div class="section-body">
                    @if($feedbacks->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <p>No feedback received yet. Feedback will appear here when customers leave reviews.</p>
                        </div>
                    @else
                        <div class="feedback-list">
                            @foreach($feedbacks as $feedback)
                                <div class="feedback-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <span class="fw-bold">{{ $feedback->user->name ?? 'Anonymous User' }}</span>
                                                <span class="badge bg-primary ms-2">Order #{{ $feedback->order_id }}</span>
                                            </div>
                                            <small class="text-muted">{{ $feedback->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <p class="mb-0">{{ $feedback->feedback }}</p>
                                    </div>
                                </div>
                            @endforeach
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
        // Function to mark notifications as read
        function markNotificationsAsRead() {
            fetch('{{ route('seller.notifications.markAsRead') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the notification badge
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        badge.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }

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

    <!-- Toast container for notifications -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="serviceApprovedToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Service Approved</strong>
                <small>Just now</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span id="toast-message">Your service has been approved by admin!</span>
            </div>
        </div>

        <div id="orderCancelledToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-times-circle me-2"></i>
                <strong class="me-auto">Order Cancelled</strong>
                <small>Just now</small>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span id="cancelled-toast-message">An order has been cancelled by the customer.</span>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL parameters for service_approved
            const urlParams = new URLSearchParams(window.location.search);
            
            @if(session('service_approved'))
                // Show toast for service approval from session
                const toast = new bootstrap.Toast(document.getElementById('serviceApprovedToast'));
                document.getElementById('toast-message').textContent = "{{ session('service_approved') }}";
                toast.show();
            @endif
            
            // Check for new notifications and show appropriate toast
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach(notification => {
                const text = notification.textContent;
                
                // Check for service approval notifications
                if (text.includes('Service Approved') && notification.getAttribute('data-read') !== 'true') {
                    const toast = new bootstrap.Toast(document.getElementById('serviceApprovedToast'));
                    const message = notification.querySelector('p').textContent.trim();
                    document.getElementById('toast-message').textContent = message;
                    toast.show();
                    notification.setAttribute('data-read', 'true');
                }
                
                // Check for order cancellation notifications
                if (text.includes('Order Cancelled') && notification.getAttribute('data-read') !== 'true') {
                    const toast = new bootstrap.Toast(document.getElementById('orderCancelledToast'));
                    const message = notification.querySelector('p').textContent.trim();
                    document.getElementById('cancelled-toast-message').textContent = message;
                    toast.show();
                    notification.setAttribute('data-read', 'true');
                }
            });
        });
    </script>
    @endsection
</body>
</html>
