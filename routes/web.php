<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerServiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;



// Default route
Route::get('/', function () {
    return view('welcome');
});

// Home route
Route::get('/', [HomeController::class, 'showHomePage'])->name('home');

// Auth routes for users
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// Auth routes for sellers
Route::get('/register-seller', [SellerController::class, 'showRegisterForm'])->name('register.seller');
Route::post('/register-seller', [SellerController::class, 'register']);
Route::get('/login-seller', [SellerController::class, 'showLoginForm'])->name('login.seller');
Route::post('/login-seller', [SellerController::class, 'login']);
Route::get('/seller-panel', [SellerController::class, 'sellerPanel'])->name('seller.panel')->middleware('auth:seller');
// Logout routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/seller/logout', [SellerController::class, 'logout'])->name('logout.seller');

// Seller service routes
Route::middleware(['auth:seller'])->group(function () {
    Route::put('/seller/services/{id}', [SellerServiceController::class, 'update'])->name('seller.updateService');
    Route::get('/seller/add-service', [SellerServiceController::class, 'showAddServiceForm'])->name('add.service')->middleware('auth:seller');
    Route::post('/seller/add-service', [SellerServiceController::class, 'storeService'])->name('store.service')->middleware('auth:seller');
    Route::get('/seller/edit-service/{id}', [SellerServiceController::class, 'edit'])->name('seller.editService');
    Route::delete('/seller/delete-service/{id}', [SellerServiceController::class, 'delete'])->name('seller.deleteService');
    Route::get('/search-services', [ServiceController::class, 'searchServices'])->name('search.services');
    
    // Earnings feature
    Route::get('/seller/earnings', [SellerController::class, 'earnings'])->name('seller.earnings');
});

// Admin routes

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/approve-seller/{id}', [AdminController::class, 'approveSeller'])->name('admin.approveSeller');
    Route::post('/admin/reject-seller/{id}', [AdminController::class, 'rejectSeller'])->name('admin.rejectSeller');
    Route::get('/admin/pending-services', [AdminController::class, 'viewPendingServices'])->name('admin.pending-services');
    Route::post('/admin/approve-service/{id}', [AdminController::class, 'approveService'])->name('admin.approveService');
    Route::post('/admin/reject-service/{id}', [AdminController::class, 'rejectService'])->name('admin.rejectService');
    Route::get('/admin/sellers', [AdminController::class, 'manageSellers'])->name('admin.sellers');
    Route::get('/admin/services', [AdminController::class, 'manageServices'])->name('admin.services');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/login-seller/{id}', [AdminController::class, 'loginAsSeller'])->name('admin.loginSeller');
    Route::post('/admin/return-to-admin', [AdminController::class, 'returnToAdmin'])->name('admin.returnToAdmin');

});   

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

Route::middleware('auth')->group(function () {
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('notifications/{id}/redirect', 'NotificationController@redirectToService')->name('notifications.redirect');
Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

Route::get('/sellers/{seller}', [ServiceController::class, 'showSellerServices'])->name('sellers.services');
Route::get('sellers/{sellerId}/services', [ServiceController::class, 'showSellerServices'])->name('sellers.services');

Route::get('services/{id}', [ServiceController::class, 'showService'])->name('service.show');

// Notification route
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Routes for cart functionality
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Routes for order placement and tracking (protected by 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('order.track');
    Route::get('/order/track/{order}', [OrderController::class, 'trackOrder'])->name('order.track');
    Route::post('/order/{order}/accept-reject', [OrderController::class, 'acceptRejectOrder'])->name('order.acceptReject');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

});

// Remove this duplicate route that's causing confusion
// Route::get('/seller/order/{order}/handle', [OrderController::class, 'handleOrder'])->name('order.handle');
Route::post('/seller/order/{order}/update-status', [OrderController::class, 'updateOrderStatus'])->name('order.updateStatus');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'allOrders'])->name('order.all');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('order.track');
    // Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
});

Route::get('/sellers/{seller_id}/services', [SellerController::class, 'showServices'])->name('seller.services');




// User (buyer) chat routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat/{order}', [MessageController::class, 'chat'])->name('chat.index');
    Route::post('/chat/{order}/send', [MessageController::class, 'send'])->name('chat.send');
    Route::post('/chat/{order}/read', [MessageController::class, 'markAsRead'])->name('chat.mark-read');
});

// Seller chat routes
Route::middleware(['auth:seller'])->group(function () {
    Route::get('/seller/chat/{order}', [MessageController::class, 'chat'])->name('seller.chat.index');
    Route::post('/seller/chat/{order}/send', [MessageController::class, 'send'])->name('seller.chat.send');
    Route::post('/seller/chat/{order}/read', [MessageController::class, 'markAsRead'])->name('seller.chat.mark-read');
});

Route::get('/seller/order/{order}/handle', [OrderController::class, 'handleOrder'])
    ->name('seller.order.handle')
    ->middleware('auth:seller');