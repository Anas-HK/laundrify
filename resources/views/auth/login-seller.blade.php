<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login - Laundrify</title>
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
            background: linear-gradient(to bottom, var(--secondary-color), var(--secondary-dark));
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
            background: linear-gradient(90deg, var(--secondary-color), var(--secondary-dark));
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
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
            border-color: var(--secondary-color);
        }

        .auth-form .btn {
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            border-radius: var(--border-radius-md);
            background: linear-gradient(to right, var(--secondary-color), var(--secondary-dark));
            border: none;
            transition: all var(--transition-normal);
            color: white !important;
        }

        .auth-form .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(to right, var(--secondary-dark), var(--secondary-color));
            color: white !important;
        }

        .auth-form p {
            text-align: center;
            margin-top: 20px;
            color: var(--text-color);
        }

        .auth-form p a {
            color: var(--secondary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-fast);
        }

        .auth-form p a:hover {
            color: var(--secondary-dark);
            text-decoration: underline;
        }

        .error-messages {
            background-color: var(--danger-light);
            border-radius: var(--border-radius-md);
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid var(--danger);
        }

        .error-messages ul {
            margin: 0;
            padding-left: 20px;
            color: var(--danger);
        }

        .error-messages li {
            margin-bottom: 5px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me input {
            margin-right: 10px;
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
                    <a href="{{ route('login') }}" class="nav-link">Customer Login</a>
                </div>
            </div>
        </div>
    </header>

    <main class="auth-container">
        <div class="auth-card">
            <form class="auth-form" method="POST" action="{{ route('login.seller') }}" onsubmit="return validateForm()">
                @csrf
                <h2>Seller Login</h2>
                
                @if ($errors->any())
                    <div class="error-messages">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <div class="mb-3">
                    <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                </div>
                
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn w-100" style="background-color: #2ecc71; color: white;">Login as Seller</button>
            
                <p class="mt-4">Don't have a seller account? <a href="{{ route('register.seller') }}">Register here</a></p>
                
                <p class="mt-2">
                    <a href="javascript:void(0);" onclick="document.getElementById('password-hint').style.display='block'">
                        <i class="fas fa-question-circle"></i> Having trouble logging in?
                    </a>
                </p>
                
                <div id="password-hint" style="display:none; margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px; font-size: 14px;">
                    <p><strong>Password Guidelines:</strong></p>
                    <ul>
                        <li>Make sure your keyboard Caps Lock is not enabled</li>
                        <li>Check that there are no extra spaces before or after your password</li>
                        <li>The system is case-sensitive (uppercase and lowercase letters are treated differently)</li>
                        <li>If you have forgotten your password, please contact admin support</li>
                    </ul>
                </div>
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
            let isValid = true;
            
            // Clear previous error indicators
            email.style.borderColor = "";
            password.style.borderColor = "";
            
            // Remove any previous error elements
            const existingErrors = document.querySelectorAll('.validation-error');
            existingErrors.forEach(elem => elem.remove());
            
            // Email validation
            if (email.value === "") {
                showError(email, "Email address is required");
                isValid = false;
            } else {
                // Comprehensive email validation regex
                const emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                
                if (!emailRegex.test(email.value)) {
                    let errorMsg = "Please enter a valid email address";
                    
                    // Check for common email mistakes
                    if (!email.value.includes('@')) {
                        errorMsg = "Email must include an @ symbol";
                    } else if (email.value.indexOf('@') === email.value.length - 1) {
                        errorMsg = "Email must include a domain after the @ symbol";
                    } else if (!email.value.includes('.', email.value.indexOf('@'))) {
                        errorMsg = "Email domain must include a dot (.)";
                    } else if (email.value.split('@').length > 2) {
                        errorMsg = "Email cannot contain multiple @ symbols";
                    }
                    
                    showError(email, errorMsg);
                    isValid = false;
                }
            }
            
            // Password validation
            if (password.value === "") {
                showError(password, "Password is required");
                isValid = false;
            }
            
            // Log the values (for debugging only, not for production)
            console.log("Email:", email.value.trim());
            console.log("Password length:", password.value.length);
            
            return isValid;
        }
        
        function showError(inputElement, message) {
            // Visual indication of error
            inputElement.style.borderColor = "red";
            
            // Create error message element
            const errorDiv = document.createElement('div');
            errorDiv.className = 'validation-error';
            errorDiv.style.color = 'red';
            errorDiv.style.fontSize = '12px';
            errorDiv.style.marginTop = '-15px';
            errorDiv.style.marginBottom = '15px';
            errorDiv.textContent = message;
            
            // Insert error message after the input
            inputElement.parentNode.insertBefore(errorDiv, inputElement.nextSibling);
        }
    </script>
</body>
</html>