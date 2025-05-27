@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $user->mobile ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($user->is_suspended)
                                            <span class="badge badge-danger">Suspended</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Joined</th>
                                    <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            @if($user->is_suspended)
                                <div class="alert alert-warning">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Account Suspended</h5>
                                    <p><strong>Suspended At:</strong> {{ $user->suspended_at->format('M d, Y H:i:s') }}</p>
                                    <p><strong>Reason:</strong> {{ $user->suspension_reason }}</p>
                                    <p><strong>Suspended By:</strong> {{ $suspensionInfo['suspended_by'] }}</p>
                                    
                                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to unsuspend this account?')">
                                            <i class="fas fa-unlock"></i> Unsuspend Account
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Suspend Account</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="reason">Reason for Suspension</label>
                                                <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="3" required></textarea>
                                                @error('reason')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to suspend this account?')">
                                                <i class="fas fa-ban"></i> Suspend Account
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Recent Orders</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 