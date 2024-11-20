<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Laundrify</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005f73;
            padding: 20px;
            color: #fff;
        }

        .header-container h1 {
            margin: 0;
            font-size: 24px;
        }

        .seller-nav {
            display: flex;
            gap: 10px;
        }

        .seller-nav .nav-btn {
            padding: 10px 15px;
            color: #fff;
            background-color: #0a9396;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .seller-nav .nav-btn:hover {
            background-color: #94d2bd;
        }

        .seller-nav .logout-btn {
            background-color: #ee9b00;
        }

        .seller-nav .logout-btn:hover {
            background-color: #ca6702;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        main p {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Welcome to the Seller Panel, {{ auth()->user()->name }}!</h1>
            <nav class="seller-nav">
                <a href="" class="nav-btn">Add Service</a>
                <a href="" class="nav-btn">Remove Service</a>
                <a href="" class="nav-btn">Update Service</a>
                <a href="" class="nav-btn">Orders</a>

                <form id="logout-form" action="{{ route('logout.seller') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="nav-btn logout-btn">Logout</button>
</form>

            </nav>
        </div>
    </header>
    <main>
        <p>This is your dashboard. You can manage your services here.</p>
    </main>
</body>
</html>
