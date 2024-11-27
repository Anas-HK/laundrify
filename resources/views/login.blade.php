<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buyer.css') }}">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Laundrify</div>
            <a href="{{ route('home') }}" class="nav-btn">Home</a>
        </nav>
    </header>
    <main class="form-page">
    <form class="auth-form" method="POST" action="{{ route('login') }}">
    @csrf
    <h2 class="register-login-heading">Login to Laundrify</h2>
    @if($errors->has('login'))
        <div class="error-message">
            <p>{{ $errors->first('login') }}</p>
        </div>
    @endif
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" class="cta-btn">Login</button>
</p>

    <p class="login-below-btn">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
</form>

    </main>
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>