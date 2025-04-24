<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laundrify</title>
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
            max-width: 700px;
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

        .auth-form h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .auth-form h3::after {
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

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control, .form-select {
            height: 48px;
            border: 1px solid var(--light-gray);
            border-radius: var(--border-radius-md);
            padding: 10px 15px;
            font-size: 15px;
            transition: all var(--transition-normal);
            background-color: var(--white);
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            border-color: var(--primary-color);
        }

        .error-text {
            color: var(--danger);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn {
            height: 48px;
            font-weight: 600;
            font-size: 16px;
            border-radius: var(--border-radius-md);
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            transition: all var(--transition-normal);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .alert {
            border-radius: var(--border-radius-md);
            padding: 15px;
            margin-top:100px;
            margin-bottom: 20px;
            border: none;
        }

        footer {
            margin-top: 0;
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

    @if ($errors->has('error'))
    <div class="container mt-4">
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    </div>
    @endif

    <div class="auth-container">
        <div class="auth-card">
            <!-- Registration Form -->
            <form id="registrationForm" class="auth-form" action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                <h3>Buyer Registration</h3>

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                minlength="3" maxlength="255" required>
                            <div id="nameError" class="error-text"></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div id="emailError" class="error-text"></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                minlength="8" required>
                            <div id="passwordError" class="error-text"></div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                name="password_confirmation" required>
                            <div id="passwordConfirmationError" class="error-text"></div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" 
                                pattern="[0-9]{11}" required>
                            <div id="mobileError" class="error-text"></div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                            <div id="addressError" class="error-text"></div>
                        </div>

                        <!-- Optional Address Line 2 -->
                        <div class="mb-3">
                            <label for="address2" class="form-label">Address Line 2 (Optional)</label>
                            <input type="text" class="form-control" id="address2" name="address2">
                        </div>

                        <!-- City, State, Zip -->
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                            <div id="cityError" class="error-text"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                            <div id="stateError" class="error-text"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="zip" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" 
                                pattern="[0-9]{6}" required>
                            <div id="zipError" class="error-text"></div>
                        </div>

                        <!-- Pickup Time -->
                        <div class="mb-3">
                            <label for="pickup_time" class="form-label">Preferred Pickup Time Slot</label>
                            <select class="form-select" id="pickup_time" name="pickup_time" required>
                                <option value="">Select a time slot</option>
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                                <option value="evening">Evening</option>
                            </select>
                            <div id="pickupTimeError" class="error-text"></div>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the terms and conditions
                        </label>
                    </div>
                    <div id="termsError" class="error-text"></div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                
                <p class="text-center mt-4">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
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
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Reset previous error messages
    const errorFields = document.querySelectorAll('.error-text');
    errorFields.forEach(field => field.textContent = '');

    let isValid = true;

    // Validation functions
    const validateField = (field, errorMessage) => {
        const errorElement = document.getElementById(`${field.id}Error`);
        if (!field.value.trim()) {
            errorElement.textContent = errorMessage;
            isValid = false;
        }
    };

    // Validate Full Name (only English alphabet, 3-20 chars)
    const name = document.getElementById('name');
    if (!/^[a-zA-Z ]{3,20}$/.test(name.value.trim())) {
        document.getElementById('nameError').textContent = 'Only English letters allowed (3-20 characters)';
        isValid = false;
    }

    // Validate Email (specific to gmail.com)
    const email = document.getElementById('email');
    if (!/^[a-zA-Z0-9]{3,20}@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/.test(email.value.trim())) {
    document.getElementById('emailError').textContent = '3-20 alphanumeric chars before @, no special chars allowed';
    isValid = false;
}

    // Validate Password
    const password = document.getElementById('password');
    if (password.value.length < 8) {
        document.getElementById('passwordError').textContent = 'Password must be at least 8 characters';
        isValid = false;
    }

    // Validate Confirm Password
    const confirmPassword = document.getElementById('password_confirmation');
    if (password.value !== confirmPassword.value) {
        document.getElementById('passwordConfirmationError').textContent = 'Passwords do not match';
        isValid = false;
    }

    // Validate Mobile (exactly 11 digits)
    const mobile = document.getElementById('mobile');
    if (!/^[0-9]{11}$/.test(mobile.value.trim())) {
        document.getElementById('mobileError').textContent = 'Please enter a valid 11-digit mobile number';
        isValid = false;
    }

    // Validate Address (must contain both letters and numbers, 10-50 chars)
    const address = document.getElementById('address');
    if (!/^(?=.*[a-zA-Z])(?=.*[0-9]).{10,50}$/.test(address.value.trim())) {
        document.getElementById('addressError').textContent = 'Must contain both letters and numbers (10-50 characters)';
        isValid = false;
    }

    // Validate City (only English letters)
    const city = document.getElementById('city');
    if (!/^[a-zA-Z ]+$/.test(city.value.trim())) {
        document.getElementById('cityError').textContent = 'Only English letters allowed';
        isValid = false;
    }

    // Validate State (only English letters)
    const state = document.getElementById('state');
    if (!/^[a-zA-Z ]+$/.test(state.value.trim())) {
        document.getElementById('stateError').textContent = 'Only English letters allowed';
        isValid = false;
    }

    // Validate Zip (exactly 6 digits)
    const zip = document.getElementById('zip');
    if (!/^[0-9]{6}$/.test(zip.value.trim())) {
        document.getElementById('zipError').textContent = 'Please enter a valid 6-digit postal code';
        isValid = false;
    }

    const pickupTime = document.getElementById('pickup_time');
    if (!pickupTime.value) {
        document.getElementById('pickupTimeError').textContent = 'Please select a pickup time';
        isValid = false;
    }

    const terms = document.getElementById('terms');
    if (!terms.checked) {
        document.getElementById('termsError').textContent = 'Please accept the terms and conditions';
        isValid = false;
    }

    if (isValid) {
        this.submit();
    }
});
    </script>
</body>
</html>