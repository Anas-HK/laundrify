<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <main class="form-page">
        <h2>Edit Service</h2>
    
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
    
            <div class="form-group">
                <label for="seller_city">City</label>
                <input type="text" id="seller_city" name="seller_city" class="form-control" 
                    value="{{ old('seller_city', $service->seller_city) }}" required>
            </div>
    
            <div class="form-group">
                <label for="seller_area">Area</label>
                <input type="text" id="seller_area" name="seller_area" class="form-control" 
                    value="{{ old('seller_area', $service->seller_area) }}" required>
            </div>
    
            <div class="form-group">
                <label for="availability">Availability</label>
                <input type="text" id="availability" name="availability" class="form-control" 
                    value="{{ old('availability', $service->availability) }}" required>
            </div>
    
            <div class="form-group">
                <label for="service_delivery_time">Delivery Time</label>
                <input type="text" id="service_delivery_time" name="service_delivery_time" class="form-control" 
                    value="{{ old('service_delivery_time', $service->service_delivery_time) }}" required>
            </div>
    
            <div class="form-group">
                <label for="seller_contact_no">Contact Number</label>
                <input type="text" id="seller_contact_no" name="seller_contact_no" class="form-control" 
                    value="{{ old('seller_contact_no', $service->seller_contact_no) }}" required>
            </div>
    
            <div class="form-group">
                <label for="service_price">Service Price</label>
                <input type="number" id="service_price" name="service_price" class="form-control" 
                    value="{{ old('service_price', $service->service_price) }}" step="0.01" required>
            </div>
    
            <div class="form-group">
                <label for="image">Service Image</label>
                <div class="current-image">
                    <img src="{{ asset('storage/' . $service->image) }}" alt="Current service image" style="max-width: 200px;">
                    <p>Current image</p>
                </div>
                <input type="file" id="image" name="image" class="form-control">
                <small class="form-text text-muted">Leave empty to keep current image</small>
            </div>
    
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Service</button>
                <a href="{{ route('seller.panel') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </main>
    
    <style>
    .form-page {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .current-image {
        margin: 10px 0;
        text-align: center;
    }
    
    .current-image img {
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }
    
    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        text-decoration: none;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    </style>
</body>
</html>