@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-primary">Cancel Order #{{ $order->id }}</h4>
                    <span class="badge text-bg-{{ $order->status === 'pending' ? 'warning' : 'primary' }}">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please note:</strong> Once an order is cancelled, it cannot be reinstated. Please be sure before proceeding.
                    </div>
                    
                    <div class="order-summary mb-4">
                        <h5 class="border-bottom pb-2 mb-3">Order Summary</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                                <p class="mb-2"><strong>Seller:</strong> {{ $order->seller->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Total Amount:</strong> {{ number_format($order->total_amount, 2) }} PKR</p>
                                <p class="mb-2"><strong>Status:</strong> {{ ucwords(str_replace('_', ' ', $order->status)) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('order.cancel', $order->id) }}" id="cancelOrderForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="cancellation_reason" class="form-label">Please tell us why you're cancelling this order <span class="text-danger">*</span></label>
                            <textarea 
                                class="form-control @error('cancellation_reason') is-invalid @enderror" 
                                id="cancellation_reason" 
                                name="cancellation_reason" 
                                rows="4" 
                                required
                                placeholder="Please provide the reason for cancellation..."
                            >{{ old('cancellation_reason') }}</textarea>
                            @error('cancellation_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Your feedback helps us improve our services.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Order
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmCancellationModal">
                                <i class="fas fa-times-circle me-1"></i> Cancel Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmCancellationModal" tabindex="-1" aria-labelledby="confirmCancellationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCancellationModalLabel">Confirm Order Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
                <p class="text-danger"><strong>Note:</strong> Your money will be refunded according to our refund policy.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Keep My Order</button>
                <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel Order</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('cancelOrderForm');
        const confirmBtn = document.getElementById('confirmCancelBtn');
        
        confirmBtn.addEventListener('click', function() {
            form.submit();
        });
    });
</script>
@endsection 