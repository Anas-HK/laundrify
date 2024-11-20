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
            <a href="{{ route('seller.panel') }}" class="nav-btn">Saller Panel</a>
        </nav>
    </header>
    
    <main class="form-page">
        <form class="auth-form" method="POST" action="{{ route('register.seller') }}">
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
</html>
