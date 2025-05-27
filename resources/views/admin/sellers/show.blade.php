@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Seller Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Sellers
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
                                    <td>{{ $seller->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $seller->email }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $seller->city ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Area</th>
                                    <td>{{ $seller->area ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($seller->is_suspended)
                                            <span class="badge badge-danger">Suspended</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Approval Status</th>
                                    <td>
                                        @if($seller->accountIsApproved == 1)
                                            <span class="badge badge-info">Approved</span>
                                        @elseif($seller->is_deleted == 1)
                                            <span class="badge badge-warning">Rejected</span>
                                        @else
                                            <span class="badge badge-secondary">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Joined</th>
                                    <td>{{ $seller->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            @if($seller->is_suspended)
                                <div class="alert alert-warning">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Account Suspended</h5>
                                    <p><strong>Suspended At:</strong> {{ $seller->suspended_at->format('M d, Y H:i:s') }}</p>
                                    <p><strong>Reason:</strong> {{ $seller->suspension_reason }}</p>
                                    <p><strong>Suspended By:</strong> {{ $suspensionInfo['suspended_by'] }}</p>
                                    
                                    <form action="{{ route('admin.sellers.unsuspend', $seller) }}" method="POST" class="mt-4">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Are you sure you want to unsuspend this seller account?')">
                                            <i class="fas fa-unlock"></i> Unsuspend Account
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-header bg-danger text-white">
                                        <h4 class="mb-0"><i class="fas fa-ban mr-2"></i> Suspend Account</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.sellers.suspend', $seller) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="reason" class="font-weight-bold">Reason for Suspension</label>
                                                <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="5" required placeholder="Please provide a detailed reason for suspending this seller account..."></textarea>
                                                @error('reason')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-4 text-center">
                                                <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to suspend this seller account?')">
                                                    <i class="fas fa-ban"></i> Suspend Account
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <form action="{{ route('admin.loginSeller', $seller->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Login as this Seller
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <h4>Services</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Service Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($seller->services as $service)
                                            <tr>
                                                <td>{{ $service->id }}</td>
                                                <td>{{ $service->service_name }}</td>
                                                <td>{{ number_format($service->service_price, 2) }} PKR</td>
                                                <td>
                                                    @if($service->is_approved)
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No services found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
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
                                        @forelse($seller->orders as $order)
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