<?php

use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAnalysisController;
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
Route::get('/growth-data', [DashboardController::class, 'getGrowthData']);
Route::get('/available-years', [DashboardController::class, 'getAvailableYears']);
Route::post('/send-ai-message', [AIController::class, 'sendMessage']);
//Option 1
// Route::post('/generate-sql', [DataAnalysisController::class, 'generateSQL']);
// Route::post('/execute-sql', [DataAnalysisController::class, 'executeSQL']);
// Route::post('/analyze-data', [DataAnalysisController::class, 'analyzeData']);
//Option 2
Route::post('/generate-and-analyze-data', [DataAnalysisController::class, 'generateAndAnalyzeData']);

});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
