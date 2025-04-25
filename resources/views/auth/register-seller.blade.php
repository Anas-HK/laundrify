<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration - Laundrify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .auth-container {
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            margin-top: 70px;
            margin-bottom: 40px;
            background-color: var(--light-color);
        }

        .auth-card {
            width: 100%;
            max-width: 650px;
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

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            height: 50px;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-md);
            padding: 10px 15px;
            font-size: 15px;
            margin-bottom: 20px;
            transition: all var(--transition-normal);
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px rgba(46, 204, 113, 0.2);
            border-color: var(--secondary-color);
        }

        input[type="file"].form-control {
            padding: 12px 15px;
            height: auto;
        }

        .form-text {
            color: var(--text-muted);
            font-size: 12px;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .btn {
            height: 50px;
            font-weight: 600;
            font-size: 16px;
            border-radius: var(--border-radius-md);
            background: linear-gradient(to right, var(--secondary-color), var(--secondary-dark));
            border: none;
            transition: all var(--transition-normal);
            color: white !important;
        }

        .btn:hover {
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

        footer {
            margin-top: 0;
        }

        /* Toast notification style */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            background-color: #ffffff;
            color: #333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-left: 4px solid #2ecc71;
        }
        
        .toast-header {
            background-color: transparent;
            border-bottom: 1px solid #eee;
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
                    <a href="{{ route('login.seller') }}" class="nav-link">Seller Login</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Toast notification -->
    <div class="toast-container">
        <div class="toast" id="registrationToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="me-auto"><i class="fas fa-check-circle text-success me-2"></i> Registration Successful</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Thank you for registering! Your account is now pending approval from our admin team. You will be notified when your account is approved.
            </div>
        </div>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <form class="auth-form" method="POST" action="{{ route('register.seller') }}" enctype="multipart/form-data" id="sellerRegistrationForm">
                @csrf
                <h2>Seller Registration</h2>

                @if ($errors->any())
                    <div class="error-messages">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            <div id="nameError" class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            <div id="emailError" class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div id="passwordError" class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <div id="confirmPasswordError" class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" required>
                            <div class="form-text">Upload a professional profile image (JPG, PNG)</div>
                            <div id="imageError" class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                            <div id="cityError" class="invalid-feedback"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="area" class="form-label">Service Area</label>
                            <input type="text" class="form-control" id="area" name="area" value="{{ old('area') }}" required>
                            <div class="form-text">The specific area within the city where you provide service</div>
                            <div id="areaError" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the terms and conditions for sellers
                        </label>
                        <div id="termsError" class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn" style="background-color: #2ecc71; color: white;">Register as Seller</button>
                </div>
                
                <p class="mt-4">Already have a seller account? <a href="{{ route('login.seller') }}">Login here</a></p>
            </form>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('sellerRegistrationForm');

            // Check if we need to show success toast based on query param
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('registration') === 'success') {
                const toast = new bootstrap.Toast(document.getElementById('registrationToast'));
                toast.show();
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                let isValid = true;
                
                // Reset error messages
                const inputs = form.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
                
                // Validate name
                const name = document.getElementById('name');
                if (!name.value.trim()) {
                    showError(name, 'nameError', 'Full name is required');
                    isValid = false;
                }
                
                // Validate email
                const email = document.getElementById('email');
                // More comprehensive email validation regex
                const emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                
                if (!email.value.trim()) {
                    showError(email, 'emailError', 'Email address is required');
                    isValid = false;
                } else if (!emailRegex.test(email.value)) {
                    // More specific error message
                    let errorMsg = 'Please enter a valid email address';
                    
                    // Check for common email mistakes
                    if (!email.value.includes('@')) {
                        errorMsg = 'Email must include an @ symbol';
                    } else if (email.value.indexOf('@') === email.value.length - 1) {
                        errorMsg = 'Email must include a domain after the @ symbol';
                    } else if (!email.value.includes('.', email.value.indexOf('@'))) {
                        errorMsg = 'Email domain must include a dot (.)';
                    } else if (email.value.split('@').length > 2) {
                        errorMsg = 'Email cannot contain multiple @ symbols';
                    }
                    
                    showError(email, 'emailError', errorMsg);
                    isValid = false;
                }
                
                // Validate password
                const password = document.getElementById('password');
                if (password.value.length < 8) {
                    showError(password, 'passwordError', 'Password must be at least 8 characters');
                    isValid = false;
                }
                
                // Validate password confirmation
                const confirmPassword = document.getElementById('password_confirmation');
                if (password.value !== confirmPassword.value) {
                    showError(confirmPassword, 'confirmPasswordError', 'Passwords do not match');
                    isValid = false;
                }
                
                // Validate profile image
                const profileImage = document.getElementById('profile_image');
                if (!profileImage.files || !profileImage.files[0]) {
                    showError(profileImage, 'imageError', 'Please select a profile image');
                    isValid = false;
                } else {
                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!allowedTypes.includes(profileImage.files[0].type)) {
                        showError(profileImage, 'imageError', 'Please select a valid image format (JPG, PNG, GIF)');
                        isValid = false;
                    }
                    // Validate file size (max 2MB)
                    if (profileImage.files[0].size > 2 * 1024 * 1024) {
                        showError(profileImage, 'imageError', 'Image size should be less than 2MB');
                        isValid = false;
                    }
                }
                
                // Validate city
                const city = document.getElementById('city');
                if (!city.value.trim()) {
                    showError(city, 'cityError', 'City is required');
                    isValid = false;
                }
                
                // Validate area
                const area = document.getElementById('area');
                if (!area.value.trim()) {
                    showError(area, 'areaError', 'Service area is required');
                    isValid = false;
                }
                
                // Validate terms
                const terms = document.getElementById('terms');
                if (!terms.checked) {
                    terms.classList.add('is-invalid');
                    document.getElementById('termsError').textContent = 'You must agree to the terms and conditions';
                    isValid = false;
                }
                
                if (isValid) {
                    // Add a loading state to the submit button
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalText = submitButton.textContent;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                    
                    // Submit the form
                    form.submit();
                    // The success toast will show after redirect with success param
                }
            });
            
            function showError(input, errorId, message) {
                input.classList.add('is-invalid');
                document.getElementById(errorId).textContent = message;
            }
        });
    </script>
</body>
</html>
