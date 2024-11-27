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
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm">Logout</button>
            </form>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function handleDelete(event, sellerId) {
            event.preventDefault();
            if (confirm('Are you sure you want to reject this seller?')) {
                fetch(event.target.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(response => {
                    if (response.ok) {
                        document.getElementById('seller-' + sellerId).remove();
                    } else {
                        alert('Failed to reject the seller.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                    alert('Failed to reject the seller.');
                });
            }
        }
    </script>
</body>
</html>