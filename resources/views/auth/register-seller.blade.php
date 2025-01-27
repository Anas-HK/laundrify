<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration - Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Laundrify</div>
            {{-- <a href="{{ route('seller.panel') }}" class="nav-btn">Seller Panel</a> --}}
        </nav>
    </header>
    
    <main class="form-page">
        <form class="auth-form" method="POST" action="{{ route('register.seller') }}" enctype="multipart/form-data">
            @csrf
            <h2 class="register-login-heading">Seller Registration</h2>

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <input type="file" name="profile_image" placeholder="Profile Image" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="area" placeholder="Area" required>
            <button type="submit" class="cta-btn">Register as Seller</button>

            <p class="register-below-btn">Already have a seller account? <a href="{{ route('login.seller') }}">Login here</a></p>
        </form>
    </main>
    
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2023 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.auth-form');

            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Check if all fields are filled
                const inputs = form.querySelectorAll('input[required]');
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = 'red'; 
                    } else {
                        input.style.borderColor = ''; 
                    }
                });

                // If form is invalid, prevent submission
                if (!isValid) {
                    event.preventDefault();
                    alert('Please fill in all required fields.');
                } else {
                    // Display success message on successful form submission
                    alert('Registration in processk, please wait for admin approval.');
                }
            });
        });
    </script>
</html>
