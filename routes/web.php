<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SellerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [AuthController::class, 'home'])->name('home');  

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  
Route::post('/login', [AuthController::class, 'login']);  

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');  
Route::post('/register', [AuthController::class, 'register']);  


Route::get('/register-seller', [SellerController::class, 'showRegisterForm'])->name('register.seller');
Route::post('/register-seller', [SellerController::class, 'register']);
Route::get('/login-seller', [SellerController::class, 'showLoginForm'])->name('login.seller');
Route::post('/login-seller', [SellerController::class, 'login']);
Route::get('/seller-panel', [SellerController::class, 'sellerPanel'])->name('seller.panel')->middleware('auth:seller');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/seller/logout', [SellerController::class, 'logout'])->name('logout.seller');

