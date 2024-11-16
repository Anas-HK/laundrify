<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>
<header>
    <nav>
        <div class="logo">Laundrify</div>
        <div class="menu-toggle">&#9776;</div>
        <div class="nav-items">
            <div class="dropdown">
                <button class="dropbtn">All Category &#9662;</button>
            </div>
            <div class="search-container">
                <input type="text" placeholder="Search this blog">
                <button type="submit">&#128269;</button>
            </div>
            <div class="dropdown">
                <button class="dropbtn">English &#9662;</button>
            </div>

            <!-- Check if user is authenticated -->
            @auth
                <span>Welcome, {{ Auth::user()->name }}!</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn logout-btn">Logout</button>
                </form>
            @endauth

            <!-- If the user is not authenticated, show Login and Register buttons -->
            @guest
                <a href="{{ route('login') }}" class="nav-btn">LOGIN</a>
                <a href="{{ route('register') }}" class="nav-btn">REGISTER</a>
            @endguest
        </div>
    </nav>
</header>


    <main>
        <div class="hero">
            <h1>GET STARTED<br>WITH LAUNDRIFY</h1>
            <button class="cta-btn">BUY NOW</button>
        </div>
    </main>
    <h1 class="main-service-heading">Our Services</h1>
    <div class="product-grid">
        <div class="product-card">
            <h2>Iron and CLeaning</h2>
            <p class="price">Start Price 500 PKR</p>
            <img src="{{ asset('images/bgwashing.jpg') }}" alt="Computers">
            <div class="button-container">
                <button class="buy-now">Avail</button>
                <a href="#" class="see-more">See More</a>
            </div>
        </div>
        <div class="product-card">
            <h2>Ironing</h2>
            <p class="price">Start Price 1000 PKR</p>
            <img src="{{ asset('images/bgwashing.jpg') }}" alt="Computers">
            <div class="button-container">
                <button class="buy-now">Avail</button>
                <a href="#" class="see-more">See More</a>
            </div>
        </div>
        <div class="product-card">
            <h2>Cleaning</h2>
            <p class="price">Start Price 1500 PKR</p>
            <img src="{{ asset('images/bgwashing.jpg') }}" alt="Computers">
            <div class="button-container">
                <button class="buy-now">Avail</button>
                <a href="#" class="see-more">See More</a>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 Laundrify. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>