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
use App\Http\Controllers\SellerVerificationController;
use App\Http\Controllers\FavoriteController;



// Default route
Route::get('/', function () {
    return view('welcome');
});

// Home route
Route::get('/', [HomeController::class, 'showHomePage'])->name('home');

// Auth routes for users
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
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
Route::middleware(['auth:seller', 'check.seller.suspension'])->group(function () {
    Route::put('/seller/services/{id}', [SellerServiceController::class, 'update'])->name('seller.updateService');
    Route::get('/seller/add-service', [SellerServiceController::class, 'showAddServiceForm'])->name('add.service');
    Route::post('/seller/add-service', [SellerServiceController::class, 'storeService'])->name('store.service');
    Route::get('/seller/edit-service/{id}', [SellerServiceController::class, 'edit'])->name('seller.editService');
    Route::delete('/seller/delete-service/{id}', [SellerServiceController::class, 'delete'])->name('seller.deleteService');
    Route::get('/search-services', [ServiceController::class, 'searchServices'])->name('search.services');
    
    // Earnings feature
    Route::get('/seller/earnings', [SellerController::class, 'earnings'])->name('seller.earnings');
    
    // Notifications
    Route::post('/seller/notifications/mark-as-read', [SellerController::class, 'markNotificationsAsRead'])->name('seller.notifications.markAsRead');
});

// Seller Verification routes
Route::middleware(['auth:seller', 'check.seller.suspension'])->group(function () {
    Route::get('/seller/verification/apply', [SellerVerificationController::class, 'showVerificationForm'])->name('seller.verification.apply');
    Route::post('/seller/verification/submit', [SellerVerificationController::class, 'submitVerificationRequest'])->name('seller.verification.submit');
    Route::get('/seller/verification/status', [SellerVerificationController::class, 'showVerificationStatus'])->name('seller.verification.status');
});

// Admin routes

Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/approve-seller/{id}', [AdminController::class, 'approveSeller'])->name('admin.approveSeller');
    Route::post('/admin/reject-seller/{id}', [AdminController::class, 'rejectSeller'])->name('admin.rejectSeller');
    Route::get('/admin/pending-services', [AdminController::class, 'viewPendingServices'])->name('admin.pending-services');
    Route::post('/admin/approve-service/{id}', [AdminController::class, 'approveService'])->name('admin.approveService');
    Route::post('/admin/reject-service/{id}', [AdminController::class, 'rejectService'])->name('admin.rejectService');
    Route::get('/admin/services', [AdminController::class, 'manageServices'])->name('admin.services');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/login-seller/{id}', [AdminController::class, 'loginAsSeller'])->name('admin.loginSeller');
    Route::post('/admin/return-to-admin', [AdminController::class, 'returnToAdmin'])->name('admin.returnToAdmin');
    
    // Admin Verification Management
    Route::get('/admin/verifications', [\App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('admin.verifications.index');
    Route::get('/admin/verifications/{verification}', [\App\Http\Controllers\Admin\VerificationController::class, 'show'])->name('admin.verifications.show');
    Route::post('/admin/verifications/{verification}/approve', [\App\Http\Controllers\Admin\VerificationController::class, 'approve'])->name('admin.verifications.approve');
    Route::post('/admin/verifications/{verification}/reject', [\App\Http\Controllers\Admin\VerificationController::class, 'reject'])->name('admin.verifications.reject');
});   

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class]);
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class]);

Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('notifications/{id}/redirect', [NotificationController::class, 'redirectToService'])->name('notifications.redirect');
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
Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
    Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('order.track');
    Route::get('/order/track/{order}', [OrderController::class, 'trackOrder'])->name('order.track');
    Route::post('/order/{order}/accept-reject', [OrderController::class, 'acceptRejectOrder'])->name('order.acceptReject');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    
    // Order cancellation routes
    Route::get('/orders/{order}/cancel', [OrderController::class, 'showCancelForm'])->name('order.cancel.form');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
});

// Remove this duplicate route that's causing confusion
// Route::get('/seller/order/{order}/handle', [OrderController::class, 'handleOrder'])->name('order.handle');
Route::post('/seller/order/{order}/update-status', [OrderController::class, 'updateOrderStatus'])->name('order.updateStatus');

Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
    Route::get('/orders', [OrderController::class, 'allOrders'])->name('order.all');
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])->name('order.track');
    // Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
});

Route::get('/sellers/{seller_id}/services', [SellerController::class, 'showServices'])->name('seller.services');




// User (buyer) chat routes
Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
    Route::get('/chat/{order}', [MessageController::class, 'chat'])->name('chat.index');
    Route::post('/chat/{order}/send', [MessageController::class, 'send'])->name('chat.send');
    Route::post('/chat/{order}/read', [MessageController::class, 'markAsRead'])->name('chat.mark-read');
    Route::get('/chat/{order}/messages', [MessageController::class, 'getMessages'])->name('chat.get-messages');
});

// Seller chat routes
Route::middleware(['auth:seller', 'check.seller.suspension'])->group(function () {
    Route::get('/seller/chat/{order}', [MessageController::class, 'chat'])->name('seller.chat.index');
    Route::post('/seller/chat/{order}/send', [MessageController::class, 'send'])->name('seller.chat.send');
    Route::post('/seller/chat/{order}/read', [MessageController::class, 'markAsRead'])->name('seller.chat.mark-read');
    Route::get('/seller/chat/{order}/messages', [MessageController::class, 'getMessages'])->name('seller.chat.get-messages');
});


Route::get('/order/{id}/feedback', [OrderController::class, 'feedback'])->name('order.feedback');
Route::post('/order/{id}/feedback', [OrderController::class, 'submitFeedback'])->name('order.feedback.submit');


Route::get('/seller/order/{order}/handle', [OrderController::class, 'handleOrder'])
    ->name('seller.order.handle')
    ->middleware(['auth:seller', 'check.seller.suspension']);

// Favorites routes
Route::middleware(['auth', \App\Http\Middleware\CheckAccountSuspension::class])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{service}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites/is-favorited/{service}', [FavoriteController::class, 'isFavorited'])->name('favorites.is-favorited');
    Route::delete('/favorites/remove/{service}', [FavoriteController::class, 'remove'])->name('favorites.remove');
});

// Direct user management routes with controller-level auth check
Route::prefix('admin')->name('admin.')->group(function () {
    // User Management Routes
    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/suspend', [App\Http\Controllers\Admin\UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/unsuspend', [App\Http\Controllers\Admin\UserManagementController::class, 'unsuspend'])->name('users.unsuspend');
    
    // Seller Management Routes
    Route::get('/sellers', [App\Http\Controllers\Admin\SellerManagementController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{seller}', [App\Http\Controllers\Admin\SellerManagementController::class, 'show'])->name('sellers.show');
    Route::post('/sellers/{seller}/suspend', [App\Http\Controllers\Admin\SellerManagementController::class, 'suspend'])->name('sellers.suspend');
    Route::post('/sellers/{seller}/unsuspend', [App\Http\Controllers\Admin\SellerManagementController::class, 'unsuspend'])->name('sellers.unsuspend');
    
    // Analytics Routes
    Route::get('/analytics', [App\Http\Controllers\Admin\AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/users', [App\Http\Controllers\Admin\AdminAnalyticsController::class, 'users'])->name('analytics.users');
    Route::get('/analytics/financial', [App\Http\Controllers\Admin\AdminAnalyticsController::class, 'financial'])->name('analytics.financial');
    Route::get('/analytics/services', [App\Http\Controllers\Admin\AdminAnalyticsController::class, 'services'])->name('analytics.services');
    Route::get('/analytics/sellers', [App\Http\Controllers\Admin\AdminAnalyticsController::class, 'sellers'])->name('analytics.sellers');
});


