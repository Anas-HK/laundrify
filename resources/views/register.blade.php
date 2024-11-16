<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Laundrify</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Laundrify</div>
            <a href="{{ route('home') }}" class="nav-btn">Home</a>
        </nav>
    </header>
    <main class="form-page">
    <form class="auth-form" method="POST" action="{{ route('register') }}">
    @csrf
    <h2 class="register-login-heading">Register for Laundrify</h2>
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <button type="submit" class="cta-btn">Register</button>
    <p class="register-below-btn">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
</form>

    </main>
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2023 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>