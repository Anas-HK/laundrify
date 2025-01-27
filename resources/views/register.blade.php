<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laundrify</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .registration-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .form-label {
            font-weight: 600;
        }
        .error-text {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Laundrify</a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">Home</a>
        </div>
    </nav>

    @if ($errors->has('error'))
    <div class="alert alert-danger">
        {{ $errors->first('error') }}
    </div>
    @endif


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="registration-container">
                    <!-- Registration Form -->
                    <form id="registrationForm" action="{{ route('register') }}" method="POST" novalidate>
                        @csrf
                        <h3 class="text-center mb-4">Buyer Registration</h3>

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

                        <!-- City, State, Zip Row -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                                <div id="cityError" class="error-text"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                                <div id="stateError" class="error-text"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip" class="form-label">Postal Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" 
                                       pattern="[0-9]{6}" required>
                                <div id="zipError" class="error-text"></div>
                            </div>
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

                        <!-- Terms and Conditions -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the terms and conditions
                            </label>
                            <div id="termsError" class="error-text"></div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light text-center">
        <div class="container">
            <span class="text-muted">&copy; 2025 Laundrify. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

        // Validate required fields
        const name = document.getElementById('name');
        validateField(name, 'Full Name is required');

        const email = document.getElementById('email');
        if (!email.value.includes('@')) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address';
            isValid = false;
        }

        const password = document.getElementById('password');
        if (password.value.length < 8) {
            document.getElementById('passwordError').textContent = 'Password must be at least 8 characters';
            isValid = false;
        }

        const confirmPassword = document.getElementById('password_confirmation');
        if (password.value !== confirmPassword.value) {
            document.getElementById('passwordConfirmationError').textContent = 'Passwords do not match';
            isValid = false;
        }

        const mobile = document.getElementById('mobile');
        if (!/^[0-9]{11}$/.test(mobile.value)) {
            document.getElementById('mobileError').textContent = 'Please enter a valid 11-digit mobile number';
            isValid = false;
        }

        const address = document.getElementById('address');
        validateField(address, 'Address is required');

        const city = document.getElementById('city');
        validateField(city, 'City is required');

        const state = document.getElementById('state');
        validateField(state, 'State is required');

        const zip = document.getElementById('zip');
        if (!/^[0-9]{6}$/.test(zip.value)) {
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

        // If all validations pass
        if (isValid) {
            this.submit();
        }
    });
    </script>
</body>
</html>