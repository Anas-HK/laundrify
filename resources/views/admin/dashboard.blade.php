<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            @if(session('impersonate'))
                <form action="{{ route('admin.stopImpersonating') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Logout Seller's Account</button>
                </form>
            @endif
        </div>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h2 class="mb-4">Pending Sellers</h2>
        @if($pendingSellers->isEmpty())
            <div class="alert alert-info">
                No pending sellers at the moment.
            </div>
        @else
            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingSellers as $seller)
                            <tr id="seller-{{ $seller->id }}">
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>
                                    <form action="{{ route('admin.approveSeller', $seller->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.rejectSeller', $seller->id) }}" method="POST" style="display:inline;" onsubmit="return handleDelete(event, {{ $seller->id }})">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <h2 class="mb-4">Pending Services</h2>
        @if($pendingServices->isEmpty())
            <div class="alert alert-info">
                No pending services at the moment.
            </div>
        @else
            <div class="table-responsive mb-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingServices as $service)
                            <tr id="service-{{ $service->id }}">
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->service_price }}</td>
                                <td>{{ $service->service_description }}</td>
                                <td>
                                    <form action="{{ route('admin.approveService', $service->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.rejectService', $service->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <h2 class="mb-4">All Sellers</h2>
        @if($sellers->isEmpty())
            <div class="alert alert-info">
                No sellers available at the moment.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sellers as $seller)
                            <tr>
                                <td>{{ $seller->name }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>
                                    <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info btn-sm">Login Seller's Account</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Reset */
        body, h1, h2, h3, p, ul, ol, li, a, input, button, textarea {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header .nav-btn {
            color: #fff;
            text-decoration: none;
            background-color: #0056b3;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        header .nav-btn:hover {
            background-color: #003f88;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar .active {
            background-color: #007bff;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-bottom: 15px;
        }

        .card p {
            margin-bottom: 10px;
        }

        .card .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card .btn:hover {
            background-color: #0056b3;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Laundrify Admin</div>
        <a href="{{ route('logout') }}" class="nav-btn">Logout</a>
    </header>

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
        <a href="{{ route('admin.sellers') }}">Manage Sellers</a>
        <a href="{{ route('admin.services') }}">Manage Services</a>
        <a href="{{ route('admin.settings') }}">Settings</a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            @if(session('impersonate'))
                <form action="{{ route('admin.stopImpersonating') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Logout Seller's Account</button>
                </form>
            @endif
        </div>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <h3>Pending Sellers</h3>
            @if($pendingSellers->isEmpty())
                <div class="alert alert-info">
                    No pending sellers at the moment.
                </div>
            @else
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingSellers as $seller)
                                <tr id="seller-{{ $seller->id }}">
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.approveSeller', $seller->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.rejectSeller', $seller->id) }}" method="POST" style="display:inline;" onsubmit="return handleDelete(event, {{ $seller->id }})">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card">
            <h3>Pending Services</h3>
            @if($pendingServices->isEmpty())
                <div class="alert alert-info">
                    No pending services at the moment.
                </div>
            @else
                <div class="table-responsive mb-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingServices as $service)
                                <tr id="service-{{ $service->id }}">
                                    <td>{{ $service->service_name }}</td>
                                    <td>{{ $service->service_price }}</td>
                                    <td>{{ $service->service_description }}</td>
                                    <td>
                                        <form action="{{ route('admin.approveService', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.rejectService', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card">
            <h3>All Sellers</h3>
            @if($sellers->isEmpty())
                <div class="alert alert-info">
                    No sellers available at the moment.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sellers as $seller)
                                <tr>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm">Login Seller's Account</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Laundrify. All rights reserved.</p>
    </footer>
</body>
</html>