<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileContoller;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;

// Public routes
Auth::routes();
// Route for the registration page
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('profile', ProfileContoller::class)->only(['show', 'update']);
    Route::resource('stores', StoreController::class);
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{id}', [BrandController::class, 'show'])->name('brands.show');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store'); 
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); 

});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
