<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Service - Laundrify</title>
    
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
                        <a class="nav-link" href="{{ route('seller.panel') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('add.service') }}">
                            <i class="fas fa-plus-circle me-1"></i> Add Service
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.earnings') }}">
                            <i class="fas fa-wallet me-1"></i> Earnings
                        </a>
                    </li>
                    @if(!Auth::guard('seller')->user()->is_verified)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.verification.apply') }}">
                            <i class="fas fa-certificate me-1"></i> Get Verified
                        </a>
                    </li>
                    @endif
                    
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::guard('seller')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form action="{{ route('logout.seller') }}" method="POST">
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
            <!-- Page Title -->
            <div class="welcome-card animate__animated animate__fadeIn">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">Add New Service</h1>
                        <p class="welcome-text">Create a new laundry service for your customers</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="fas fa-plus-circle welcome-icon"></i>
                    </div>
                </div>
            </div>
            
            <!-- Success Message -->
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
            
            <!-- Add Service Form -->
            <div class="section-card animate__animated animate__fadeIn">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-clipboard-list"></i> Service Details
                    </h2>
                </div>
                <div class="section-body">
                    <form method="POST" action="{{ route('store.service') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="seller_name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Seller Name
                                </label>
                                <input type="text" class="form-control" id="seller_name" value="{{ $seller->name }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="service_name" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Service Name
                                </label>
                                <input type="text" class="form-control" id="service_name" name="service_name" required>
                                <div class="invalid-feedback">Please provide a service name.</div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="service_description" class="form-label">
                                    <i class="fas fa-align-left me-2"></i>Service Description
                                </label>
                                <textarea class="form-control" id="service_description" name="service_description" rows="4" required></textarea>
                                <div class="invalid-feedback">Please provide a service description.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seller_city" class="form-label">
                                    <i class="fas fa-city me-2"></i>City
                                </label>
                                <input type="text" class="form-control" id="seller_city" name="seller_city" required>
                                <div class="invalid-feedback">Please provide your city.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seller_area" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Area
                                </label>
                                <input type="text" class="form-control" id="seller_area" name="seller_area" required>
                                <div class="invalid-feedback">Please provide your area.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="availability" class="form-label">
                                    <i class="fas fa-clock me-2"></i>Availability
                                </label>
                                <input type="text" class="form-control" id="availability" name="availability" placeholder="e.g. Mon-Fri, 9AM-5PM" required>
                                <div class="invalid-feedback">Please provide availability information.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="service_delivery_time" class="form-label">
                                    <i class="fas fa-truck me-2"></i>Service Delivery Time
                                </label>
                                <input type="text" class="form-control" id="service_delivery_time" name="service_delivery_time" placeholder="e.g. 2-3 business days" required>
                                <div class="invalid-feedback">Please provide delivery time information.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="seller_contact_no" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Contact Number
                                </label>
                                <input type="text" class="form-control" id="seller_contact_no" name="seller_contact_no" required>
                                <div class="invalid-feedback">Please provide a contact number.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="service_price" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2"></i>Service Price (PKR)
                                </label>
                                <input type="number" class="form-control" id="service_price" name="service_price" min="1" required>
                                <div class="invalid-feedback">Please provide a valid price.</div>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <label for="image" class="form-label">
                                    <i class="fas fa-image me-2"></i>Upload Image
                                </label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                <div class="form-text">Upload a clear, high-quality image representing your service.</div>
                                <div class="invalid-feedback">Please select an image for your service.</div>
                            </div>
                            
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Add Service
                                </button>
                            </div>
                            
                            <div class="col-12 text-center mt-3">
                                <a href="{{ route('seller.panel') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </form>
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
            
            // Form validation
            (function() {
                'use strict';
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            })();
        });
    </script>
</body>
</html>
