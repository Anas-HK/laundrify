@extends('layouts.app')

@section('title', 'My Favorites - Laundrify')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Favorites</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if($favorites->isEmpty())
        <div class="empty-state">
            <i class="fas fa-heart"></i>
            <h3>No Favorites Yet</h3>
            <p>You haven't added any services to your favorites list yet.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Services</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($favorites as $service)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-img-top d-flex justify-content-center align-items-center" style="width: 120px; height: 120px; background-color: #f0f0f0; border-radius: 50%; overflow: hidden; margin: 0 auto;">
                            @if($service->seller->profile_image && file_exists(public_path('storage/' . $service->seller->profile_image)))
                                <img src="{{ asset('storage/' . $service->seller->profile_image) }}" alt="{{ $service->seller->name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                            @else
                                <i class="fas fa-user" style="font-size: 70px; color: #aaa;"></i>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ $service->service_name }}</h5>
                            
                            <div class="service-details">
                                <p><strong>Seller:</strong> 
                                    {{ $service->seller->name }}
                                    @if($service->seller->isVerified())
                                        <span class="verified-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="This seller has been verified by Laundrify">
                                            <i class="fas fa-check-circle"></i><span class="verified-text">Verified</span>
                                        </span>
                                    @endif
                                </p>
                                <p><strong>Email:</strong> {{ $service->seller->email }}</p>
                                <p><strong>City:</strong> {{ $service->seller->city }}</p>
                                <p><strong>Area:</strong> {{ $service->seller->area }}</p>
                                <p><strong>Start Price:</strong> {{ $service->service_price }} PKR</p>
                            </div>
                            
                            <div class="d-flex justify-content-center" style="width: 100%; height: 200px; background-color: #f0f0f0; align-items: center; justify-content: center;">
                                @if($service->image && file_exists(public_path('storage/' . $service->image)))
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->service_name }}" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                @else
                                    <i class="fas fa-image" style="font-size: 70px; color: #aaa;"></i>
                                @endif
                            </div>
                            
                            <p class="card-text description-line-clamp">
                                <strong>Description:</strong> {{ $service->service_description }}
                            </p>
                            
                            <div class="service-meta d-flex justify-content-between">
                                <p><strong>Availability:</strong> {{ $service->availability }}</p>
                                <p><strong>Delivery Time:</strong> {{ $service->service_delivery_time }}</p>
                            </div>
                            
                            <div class="button-container d-flex justify-content-between mt-auto">
                                <a href="{{ route('seller.services', ['seller_id' => $service->seller->id]) }}" class="btn btn-primary">Avail</a>
                                <button class="favorite-btn active" 
                                        data-service-id="{{ $service->id }}" 
                                        onclick="removeFavorite({{ $service->id }}, this)">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 3rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin: 2rem 0;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #dc3545;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    .description-line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .verified-badge {
        color: #28a745;
        font-size: 0.9rem;
        margin-left: 0.3rem;
    }
    
    /* Favorite button styling */
    .favorite-btn {
        transition: all 0.2s ease;
        background: transparent;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    
    .favorite-btn:hover {
        transform: scale(1.1);
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .favorite-btn i {
        font-size: 1.2rem;
    }
    
    .favorite-btn.active i {
        color: #dc3545;
    }
    
    .favorite-btn i.far {
        color: #6c757d;
    }
    
    @keyframes heartBeat {
        0% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(1); }
        75% { transform: scale(1.3); }
        100% { transform: scale(0); }
    }
    
    .heart-remove-animation {
        animation: heartBeat 0.6s ease-in-out forwards;
    }
    
    .service-card-fade {
        animation: fadeOut 0.7s ease-in-out forwards;
    }
    
    @keyframes fadeOut {
        0% { opacity: 1; transform: scale(1); }
        100% { opacity: 0; transform: scale(0.8); }
    }
</style>
@endsection

@section('scripts')
<script>
    function removeFavorite(serviceId, button) {
        // Get the card element to animate
        const card = button.closest('.col');
        const heart = button.querySelector('i');
        
        // Add animation classes
        heart.classList.add('heart-remove-animation');
        
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Wait for animation to complete before making the API call
        setTimeout(() => {
            card.classList.add('service-card-fade');
            
            // Make the API call to remove the favorite
            fetch(`/favorites/remove/${serviceId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the card from the DOM after animation
                    setTimeout(() => {
                        card.remove();
                        
                        // If no more favorites, show empty state
                        const remainingCards = document.querySelectorAll('.col');
                        if (remainingCards.length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    }, 700);
                }
            })
            .catch(error => {
                console.error('Error removing favorite:', error);
                // Remove animation on error
                heart.classList.remove('heart-remove-animation');
                card.classList.remove('service-card-fade');
            });
        }, 600);
    }
</script>
@endsection 