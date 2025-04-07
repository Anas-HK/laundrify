<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Laundrify</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005f73;
            padding: 20px;
            color: #fff;
        }

        .header-container h1 {
            margin: 0;
            font-size: 24px;
        }

        .seller-nav {
            display: flex;
            gap: 10px;
        }

        .seller-nav .nav-btn {
            padding: 10px 15px;
            color: #fff;
            background-color: #0a9396;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .seller-nav .nav-btn:hover {
            background-color: #94d2bd;
        }

        .seller-nav .logout-btn {
            background-color: #ee9b00;
        }

        .seller-nav .logout-btn:hover {
            background-color: #ca6702;
        }

        main {
            padding: 20px;
        }

        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        /* Verification badge styling */
        .verified-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            font-size: 0.65em;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            vertical-align: middle;
        }
        
        .verified-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .verified-badge i {
            margin-right: 3px;
            font-size: 0.9em;
        }
        
        .verified-text {
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Welcome to the Seller Panel, {{ auth()->guard('seller')->user()->name }}!</h1>
            <nav class="seller-nav">
                <a href="{{ route('add.service') }}" class="nav-btn">Add Service</a>
                <a href="{{ route('seller.panel') }}" class="nav-btn">Dashboard</a>
                <a href="{{ route('seller.earnings') }}" class="nav-btn">Earnings</a>
                <a href="{{ route('seller.verification.apply') }}" class="nav-btn">
                    <i class="fas fa-certificate"></i> Get Verified
                </a>

                <form id="logout-form" action="{{ route('logout.seller') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn logout-btn">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <script>
        // Initialize Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html> 