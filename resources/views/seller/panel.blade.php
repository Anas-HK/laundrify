<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Panel - Laundrify</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
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

        /* Service Grid Styles */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-items: center;
        }

        .product-card {
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .product-card h2 {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .product-card .price {
            font-size: 18px;
            color: #00796b;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .button-container {
            margin-top: 15px;
        }

        .edit-service, .delete-service {
            background-color: #0a9396;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .edit-service:hover, .delete-service:hover {
            background-color: #00796b;
        }

        /* Notification Icon Styling */
.notification-icon {
    position: relative;
    margin-right: 20px;
    cursor: pointer;
}
.fa-bell{
    color: white !important;

}

.notification-icon i {
    font-size: 24px;
    color: #333;
    transition: color 0.3s ease;
}

.notification-icon i:hover {
    color: #007bff; /* Primary theme color */
}

/* Badge Styling */
.notification-icon .badge {
    position: absolute;
    top: -5px;
    right: -10px;
    font-size: 12px;
    color: #fff;
    background-color: #dc3545; 
    border-radius: 50%;
    padding: 3px 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* Dropdown Menu Styling */
.dropdown-menu {
    position: absolute;
    top: 40px;
    right: 0;
    width: 300px;
    max-height: 300px;
    overflow-y: auto;
    display: none;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border: 1px solid #ddd;
    z-index: 1000;
}

.dropdown-menu .dropdown-item {
    padding: 10px;
    font-size: 14px;
    color: #333;
    border-bottom: 1px solid #f1f1f1;
    line-height: 1.5;
}

.dropdown-menu .dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa; /* Light hover color */
    border-radius: 4px;
}

.dropdown-menu p {
    margin: 0;
    line-height: 1.5;
}

.dropdown-menu small {
    color: #666;
    font-size: 12px;
    display: block;
    margin-top: 5px;
}

/* Show dropdown on hover */
.notification-icon:hover .dropdown-menu {
    display: block;
}

/* Notifications Scrollbar */
.notifications::-webkit-scrollbar {
    width: 6px;
}

.notifications::-webkit-scrollbar-thumb {
    background-color: #007bff;
    border-radius: 3px;
}

.notifications::-webkit-scrollbar-track {
    background-color: #f1f1f1;
    border-radius: 3px;
}

.success-message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }


    </style>
</head>
<body>

<header>
    <div class="header-container">
        <h1>Welcome to the Seller Panel, {{ auth()->guard('seller')->user()->name }}!</h1>
        <nav class="seller-nav">
            <a href="{{ route('add.service') }}" class="nav-btn">Add Service</a>
            <a href="" class="nav-btn">Remove Service</a>
            <a href="" class="nav-btn">Update Service</a>
            <a href="" class="nav-btn">Orders</a>
            <a href="{{ route('seller.earnings') }}" class="nav-btn">Earnings</a>

            @if(session('admin_id'))
                <form action="{{ route('admin.returnToAdmin') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Return to Admin Panel</button>
                </form>
            @endif

            <form id="logout-form" action="{{ route('logout.seller') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-btn logout-btn">Logout</button>
            </form>
        </nav>

     
    <div class="header-container">
        <!-- Notification Icon -->
        <div class="notification-icon">
            <i class="fa fa-bell"></i>
            @if($notifications->isNotEmpty())
                <span class="badge">{{ $notifications->count() }}</span>
            @endif
            <!-- Dropdown Menu -->
            <div class="dropdown-menu">
                @if($notifications->isEmpty())
                    <p>No notifications available.</p>
                @else
                    <div class="notifications">
                        @foreach($notifications as $notification)
                        <div class="dropdown-item">
    @if(is_string($notification->data['order_details']))
        @php
            $details = json_decode($notification->data['order_details'], true);
        @endphp
    @else
        @php
            $details = $notification->data['order_details'];
        @endphp
    @endif

    <p>
        <strong>{{ $notification->data['seller_name'] }}</strong><br>
        Order ID: {{ $notification->data['order_id'] }}<br>
        @if(is_array($details))
            @foreach($details as $detail)
                Service ID: {{ $detail['service_id'] }}, 
                Quantity: {{ $detail['quantity'] }}, 
                Price: {{ $detail['price'] }}<br>
            @endforeach
        @else
            {{ $notification->data['order_details'] }}
        @endif
    </p>
</div>

                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</header>

    <main>
        @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
        <p>This is your dashboard. You can manage your services here.</p>

        <!-- Display services -->
        <div class="seller-panel">
            @if($services->isEmpty())
                <p>You haven't added any services yet.</p>
            @else
                <div class="product-grid">
                    @foreach($services as $service)
                        <div class="product-card">
                            <h2>{{ $service->service_name }}</h2>
                            <p class="price">Start Price {{ $service->service_price }} PKR</p>
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->service_name }}">
                            <div class="button-container">
                                <a href="{{ route('seller.editService', $service->id) }}" class="edit-service">Edit</a>
                                <form action="{{ route('seller.deleteService', $service->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-service">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <h2>Your Orders</h2>
@if($orders->isEmpty())
    <p>No orders found.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Buyer Name</th>
                <th>Services</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td> <!-- Assuming the user relationship is loaded -->
                    <td>
                        <ul>
                            @foreach($order->items as $item) 
                                <li>{{ $item->service->service_name }} ({{ $item->quantity }} x {{ $item->price }} PKR)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->total_amount ?? 'N/A' }} PKR</td> 
                    <td>{{ $order->status }}</td>
                    <td>
                        @if($order->status === 'pending')
                            <form action="{{ route('order.acceptReject', $order) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" name="status" value="accepted" class="btn btn-success">Accept</button>
                                <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                            </form>
                        @else
                            <a href="{{ route('seller.order.handle', $order) }}" class="btn btn-info">View</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

    </main>
</body>
</html>
