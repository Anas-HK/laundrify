<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerServiceController;
use App\Http\Controllers\Admin\AdminController;


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
Route::post('/register', [AuthController::class, 'register']);

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
Route::get('/seller/add-service', [SellerServiceController::class, 'showAddServiceForm'])->name('add.service')->middleware('auth:seller');
Route::post('/seller/add-service', [SellerServiceController::class, 'storeService'])->name('store.service')->middleware('auth:seller');
Route::get('/seller/edit-service/{id}', [SellerServiceController::class, 'edit'])->name('seller.editService');
Route::delete('/seller/delete-service/{id}', [SellerServiceController::class, 'delete'])->name('seller.deleteService');

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/approve-seller/{id}', [AdminController::class, 'approveSeller'])->name('admin.approveSeller');
    Route::post('/admin/reject-seller/{id}', [AdminController::class, 'rejectSeller'])->name('admin.rejectSeller');
});
