<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login - Laundrify</title>
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
        <form class="auth-form" method="POST" action="{{ route('login.seller') }}">
            @csrf
            <h2 class="register-login-heading">Seller Login</h2>

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="cta-btn">Login as Seller</button>

            <p class="register-below-btn">Don't have a seller account? <a href="{{ route('register.seller') }}">Register here</a></p>
        </form>
    </main>
    
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2023 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>