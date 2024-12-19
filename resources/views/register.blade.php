<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laundrify</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* General Form Styles */
form {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

h3 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
    font-family: Arial, sans-serif;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="file"],
select {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    outline: none;
    box-sizing: border-box;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
input[type="file"]:focus,
select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

input[type="checkbox"] {
    margin-right: 5px;
}

.form-group .form-control {
    margin-bottom: 5px;
}

.form-group small {
    color: #666;
    font-size: 12px;
}

.error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }
}

    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Laundrify</div>
            <a href="{{ route('home') }}" class="nav-btn">Home</a>
        </nav>
    </header>

    <main class="form-page">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('register') }}" method="POST" id="registrationForm">
            @csrf
            <h3>Buyer Registration</h3>
    
            <!-- Full Name -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" 
                    minlength="3" maxlength="255" required>
            </div>
    
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
    
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" minlength="8" required>
            </div>
    
            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>
    
            <!-- Mobile Number -->
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" value="{{ old('mobile') }}" 
                    pattern="[0-9]{11}" title="Please enter a valid 10-digit mobile number" required>
            </div>
    
            <!-- Address -->
            <div class="form-group">
                <label for="address">Address Line 1</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
            </div>
    
            <div class="form-group">
                <label for="address2">Address Line 2 (Optional)</label>
                <input type="text" id="address2" name="address2" class="form-control" value="{{ old('address2') }}">
            </div>
    
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required>
            </div>
    
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" id="state" name="state" class="form-control" value="{{ old('state') }}" required>
            </div>
    
            <div class="form-group">
                <label for="zip">Postal Code</label>
                <input type="text" id="zip" name="zip" class="form-control" value="{{ old('zip') }}" 
                    pattern="[0-9]{6}" title="Please enter a valid 6-digit postal code" required>
            </div>
    
            <!-- Preferences -->
            <div class="form-group">
                <label for="pickup_time">Preferred Pickup Time Slot</label>
                <select id="pickup_time" name="pickup_time" class="form-control" required>
                    <option value="">Select a time slot</option>
                    <option value="morning" {{ old('pickup_time') == 'morning' ? 'selected' : '' }}>Morning</option>
                    <option value="afternoon" {{ old('pickup_time') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                    <option value="evening" {{ old('pickup_time') == 'evening' ? 'selected' : '' }}>Evening</option>
                </select>
            </div>
    
            <!-- Terms and Conditions -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                    <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                </div>
            </div>
    
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </main>
    
    <script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default submission
    
        // Check if all required fields are filled
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
    
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
    
        // Check password match
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        if (password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
            alert('Passwords do not match');
            return;
        }
    
        // Submit the form if everything is valid
        if (isValid) {
            this.submit();
        } else {
            alert('Please fill in all required fields correctly');
        }
    });
    </script>
    
    <style>
    .is-invalid {
        border-color: red !important;
    }
    </style>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2025 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
