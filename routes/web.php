<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [AuthController::class, 'home'])->name('home');  // Home page route handled by AuthController

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  // Login form route
Route::post('/login', [AuthController::class, 'login']);  // Login submission route

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');  // Register form route
Route::post('/register', [AuthController::class, 'register']);  // Register submission route

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
