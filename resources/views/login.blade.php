<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundrify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .auth-container {
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            margin-top: 70px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background-color: var(--white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            padding: 40px;
            overflow: hidden;
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-dark));
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-form h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .auth-form h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            border-radius: 2px;
        }

        .auth-form .form-control {
            height: 50px;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-md);
            padding: 10px 15px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: all var(--transition-normal);
        }

        .auth-form .form-control:focus {
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            border-color: var(--primary-color);
        }

        .auth-form .btn {
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            border-radius: var(--border-radius-md);
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            transition: all var(--transition-normal);
        }

        .auth-form .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .auth-form p {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
        }

        .auth-form p a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .auth-form p a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .alert {
            border-radius: var(--border-radius-md);
            padding: 15px;
            margin-bottom: 20px;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Modern Navbar -->
    <header class="navbar-main">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <span class="logo-text">Laundrify</span>
                        <span class="logo-icon"><i class="fas fa-tshirt"></i></span>
                    </a>
                </div>
                
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </div>
            </div>
        </div>
    </header>

    <main class="auth-container">
        <div class="auth-card">
            <form class="auth-form" method="POST" action="{{ route('login') }}" onsubmit="return validateForm()">
                @csrf
                <h2>Login to Laundrify</h2>
                
                @if($errors->has('login'))
                    <div class="alert alert-danger">
                        <p>{{ $errors->first('login') }}</p>
                    </div>
                @endif
            
                <div class="mb-3">
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            
                <p class="mt-4">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="text-center">
                <p>&copy; 2024 Laundrify. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            var email = document.getElementById("email");
            var password = document.getElementById("password");
    
            // Check if email or password is empty
            if (email.value === "" || password.value === "") {
                // Custom validation message
                alert("Email and Password are required.");
                return false; 
            }
    
            return true; // Allow form submission if no error
        }
    </script>
</body>
</html>
