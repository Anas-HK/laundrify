@extends('seller.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sellerOrderHandle.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">Order Management</h1>
    
    <!-- Order Overview Card -->
    <div class="order-overview">
        <div class="row">
            <div class="col-md-4">
                <h2 class="order-id">Order #{{ $order->id }}</h2>
                <p class="text-muted small">{{ $order->created_at->format('F d, Y - h:i A') }}</p>
            </div>
            <div class="col-md-4 text-md-center">
                <div class="badge status-{{ $order->status }}">
                    <i class="fas fa-circle"></i> {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="order-total">
                    <span class="text-muted">Total:</span> {{ $order->total_amount }} PKR
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Order Items -->
            <div class="info-card">
                <h3 class="card-title"><i class="fas fa-shopping-bag"></i> Order Items</h3>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->service->service_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }} PKR</td>
                                <td>{{ $item->quantity * $item->price }} PKR</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Customer Details -->
            <div class="info-card">
                <h3 class="card-title"><i class="fas fa-user"></i> Customer Details</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Name</span>
                        <span class="info-value">{{ $order->user->name }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $order->user->email }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Mobile</span>
                        <span class="info-value">{{ $order->user->mobile }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Address</span>
                        <span class="info-value">{{ $order->user->address }}</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Payment Details -->
            <div class="info-card">
                <h3 class="card-title"><i class="fas fa-credit-card"></i> Payment Details</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Payment Mode</span>
                        <span class="info-value">{{ $order->transaction_id ? 'Online' : 'Cash on Delivery' }}</span>
                    </li>
                    @if($order->transaction_id)
                    <li class="info-item">
                        <span class="info-label">Transaction ID</span>
                        <span class="info-value">{{ $order->transaction_id }}</span>
                    </li>
                    @endif
                </ul>
            </div>
            
            <!-- Seller Details -->
            <div class="info-card">
                <h3 class="card-title"><i class="fas fa-store"></i> Seller Details</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Name</span>
                        <span class="info-value">{{ $order->seller->name }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $order->seller->email }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Contact</span>
                        <span class="info-value">{{ $order->seller->mobile }}</span>
                    </li>
                </ul>
            </div>
            <!-- Update Status -->
<div class="info-card status-form">
    <h3 class="card-title"><i class="fas fa-clipboard-check"></i> Update Status</h3>
    
    <form action="{{ route('order.updateStatus', $order) }}" method="POST">
        @csrf

        @php
            $statusFlow = [
                'accepted' => 'pickup_departed',
                'pickup_departed' => 'picked_up',
                'picked_up' => 'started_washing',
                'started_washing' => 'ironing',
                'ironing' => 'ready_for_delivery',
                'ready_for_delivery' => 'delivered',
                'delivered' => 'completed',
            ];
            $nextStatus = $statusFlow[$order->status] ?? null;
        @endphp

        <div class="status-select-container">
            <label for="status" class="status-select-label">Change Order Status:</label>

            @if($order->status === 'rejected' || !$nextStatus)
                <select class="status-select" disabled>
                    <option selected>No further actions</option>
                </select>
            @else
                <select name="status" id="status" class="status-select" required>
                    <option value="{{ $nextStatus }}">
                        {{ ucfirst(str_replace('_', ' ', $nextStatus)) }}
                    </option>
                </select>
            @endif
        </div>

        <div class="btn-container">
            @if($order->status !== 'rejected' && $nextStatus)
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Status
                </button>
            @else
                <button type="button" class="btn btn-disabled" disabled>
                    <i class="fas fa-ban"></i> Cannot Update - {{ $order->status === 'rejected' ? 'Order Rejected' : 'Already Completed' }}
                </button>
            @endif

            <!-- Chat Button (Only for specific statuses) -->
            @if(in_array($order->status, ['accepted', 'pickup_departed', 'picked_up', 'started_washing', 'ironing', 'ready_for_delivery', 'delivered', 'completed']))
                <a href="{{ route('seller.chat.index', $order->id) }}" class="btn btn-info">
                    <i class="fas fa-comments"></i> Chat with Customer
                </a>
            @endif

            <a href="{{ route('seller.panel') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </form>
</div>

        </div>
    </div>
</div>
@endsection
