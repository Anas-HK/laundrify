@extends('seller.layouts.app')

@section('title', 'Edit Service')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sellerEditService.css') }}">
@endsection

@section('content')
<div class="edit-service-container">
    <h2>
        <i class="fas fa-edit me-2"></i>Edit Service
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.updateService', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="service_name">Service Name</label>
            <input type="text" id="service_name" name="service_name" class="form-control" 
                value="{{ old('service_name', $service->service_name) }}" required>
        </div>

        <div class="form-group">
            <label for="service_description">Service Description</label>
            <textarea id="service_description" name="service_description" class="form-control" rows="4" required>{{ old('service_description', $service->service_description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="seller_city">City</label>
                    <input type="text" id="seller_city" name="seller_city" class="form-control" 
                        value="{{ old('seller_city', $service->seller_city) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="seller_area">Area</label>
                    <input type="text" id="seller_area" name="seller_area" class="form-control" 
                        value="{{ old('seller_area', $service->seller_area) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="availability">Availability</label>
                    <input type="text" id="availability" name="availability" class="form-control" 
                        value="{{ old('availability', $service->availability) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="service_delivery_time">Delivery Time</label>
                    <input type="text" id="service_delivery_time" name="service_delivery_time" class="form-control" 
                        value="{{ old('service_delivery_time', $service->service_delivery_time) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="seller_contact_no">Contact Number</label>
                    <input type="text" id="seller_contact_no" name="seller_contact_no" class="form-control" 
                        value="{{ old('seller_contact_no', $service->seller_contact_no) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="service_price">Service Price</label>
                    <div class="input-group">
                        <span class="input-group-text">৳</span>
                        <input type="number" id="service_price" name="service_price" class="form-control" 
                            value="{{ old('service_price', $service->service_price) }}" step="0.01" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Service Image</label>
            <div class="current-image">
                <img src="{{ asset('storage/' . $service->image) }}" alt="Current service image">
                <p>Current image</p>
            </div>
            <input type="file" id="image" name="image" class="form-control">
            <small class="form-text text-muted">Leave empty to keep current image</small>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Service
            </button>
            <a href="{{ route('seller.panel') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection