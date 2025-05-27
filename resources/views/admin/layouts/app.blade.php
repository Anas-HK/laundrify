@php
    use Illuminate\Support\Facades\Route;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard') | Laundrify Admin</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Admin Layout CSS -->
    <link href="{{ asset('css/adminLayout.css') }}" rel="stylesheet">
    
    <!-- Custom Admin Dashboard CSS -->
    <link href="{{ asset('css/adminDashboard.css') }}" rel="stylesheet">
    
    <!-- Toast Notifications CSS -->
    <link href="{{ asset('css/admin-toast.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    @yield('styles')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
        }
        
        .sidebar {
            background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .brand-content {
            display: flex;
            align-items: center;
        }
        
        .sidebar-title {
            font-size: 1.2rem;
            margin-left: 0.75rem;
            margin-bottom: 0;
            font-weight: 600;
            color: white;
        }
        
        .nav-item {
            margin-bottom: 0.25rem;
        }
        
        .nav-link {
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }
        
        .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 1rem;
        }
        
        .content-area {
            padding: 1.5rem;
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 1rem 1.5rem;
        }
        
        .admin-user {
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
        }
        
        .admin-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 0.75rem;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-info {
            flex: 1;
            min-width: 0;
        }
        
        .admin-name {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .admin-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 50rem;
        }
        
        .btn-icon {
            width: 2rem;
            height: 2rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-content">
                    <i class="fas fa-tshirt fa-2x text-white"></i>
                    <h1 class="sidebar-title">Laundrify</h1>
                </div>
            </div>
            
            <!-- Admin User Info -->
            <div class="admin-user">
                <div class="admin-avatar">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=fff" alt="Admin" class="img-fluid">
                </div>
                <div class="admin-info">
                    <div class="admin-name">{{ Auth::user()->name }}</div>
                    <div class="admin-role">Administrator</div>
                </div>
            </div>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                            <i class="fas fa-chart-line"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.sellers.index') }}" class="nav-link {{ request()->routeIs('admin.sellers.index') || request()->routeIs('admin.sellers.show') ? 'active' : '' }}">
                            <i class="fas fa-store"></i>
                            <span>Seller Management</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.verifications.index') }}" class="nav-link {{ request()->routeIs('admin.verifications.index') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <span>Verifications</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.show') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    
                    <div class="sidebar-divider"></div>
                    
                    <li class="nav-item mt-auto">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Mobile Menu Button (appears only on small screens) -->
            <button class="mobile-nav-toggle d-md-none" id="mobileNavToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Begin Page Content -->
            <div class="content-area">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">@yield('title', 'Dashboard')</h1>
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">@yield('title', 'Dashboard')</li>
                    </ol>
                </div>
                
                <!-- Success/Error Messages - Hidden but kept for compatibility -->
                <div class="d-none">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                
                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Toast Container -->
    <div id="toast-container" class="toast-container"></div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toast Notifications JS -->
    <script src="{{ asset('js/admin-toast.js') }}"></script>
    
    <!-- Admin Layout JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileNavToggle = document.getElementById('mobileNavToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (mobileNavToggle) {
                mobileNavToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('toggled');
                });
            }
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Pass flash messages to toast system
            @if(session('success'))
                toast.success("{{ session('success') }}");
            @endif
            
            @if(session('error'))
                toast.error("{{ session('error') }}");
            @endif
            
            @if(session('warning'))
                toast.warning("{{ session('warning') }}");
            @endif
            
            @if(session('info'))
                toast.info("{{ session('info') }}");
            @endif
            
            @if(session('status'))
                toast.success("{{ session('status') }}");
            @endif
        });
    </script>
    
    <!-- Page Specific Scripts -->
    @yield('scripts')
</body>
</html> 