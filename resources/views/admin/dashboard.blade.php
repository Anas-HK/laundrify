<!DOCTYPE html>
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
</html>