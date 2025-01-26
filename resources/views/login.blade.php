<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buyer.css') }}">
    <!-- Add Bootstrap CDN for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Laundrify</div>
            <a href="{{ route('home') }}" class="nav-btn">Home</a>
        </nav>
    </header>

    <main class="form-page">
        <form class="auth-form" method="POST" action="{{ route('login') }}" onsubmit="return validateForm()">
            @csrf
            <h2 class="register-login-heading">Login to Laundrify</h2>
        
            <!-- Display Error Alert -->
            @if($errors->has('login'))
                <div class="alert alert-danger">
                    <p>{{ $errors->first('login') }}</p>
                </div>
            @endif
        
            <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="form-control">
            <input type="password" name="password" id="password" placeholder="Password" class="form-control">
            <button type="submit" class="cta-btn btn btn-primary w-100">Login</button>
        
            <p class="login-below-btn mt-3">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
        </form>
        
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 Laundrify. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var email = document.getElementById("email");
            var password = document.getElementById("password");
    
            // Check if email or password is empty
            if (email.value === "" || password.value === "") {
                // Custom validation message
                alert("Email and Password are required.");
                return false; // Prevent form submission
            }
    
            return true; // Allow form submission if no error
        }
    </script>
    
</body>
</html>
