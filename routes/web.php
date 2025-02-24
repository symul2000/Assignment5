<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerDashboard;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboard;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\RentalController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Frontend\CarController as FrontendCarController;

use App\Http\Controllers\Frontend\RentalController as FrontendRentalController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Show car details (GET)
Route::get('/carDetails/{car}', [FrontendCarController::class, 'show'])->name('cars.details');
Route::get('/cars', [FrontendCarController::class, 'index'])->name('cars.index');
Route::post('/cars/book', [FrontendRentalController::class, 'store'])->name('rentals.create');
Route::get('/rentals', [FrontendRentalController::class, 'rentalHistory'])->name('rentals.index');
Route::middleware('auth')->post('/rentals/{rentalId}/cancel', [FrontendRentalController::class, 'cancelBooking'])->name('rentals.cancel');

// Customer Dashboard
Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard')->middleware('auth');

// Authentication Routes
Route::get('/login', [PageController::class, 'showLoginForm'])->name('login');
Route::post('/login', [PageController::class, 'login']);
Route::get('/register', [PageController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [PageController::class, 'register']);

// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/dashboard', [CustomerDashboard::class, 'index'])->name('customer.dashboard');

    // Customer Profile Management
    Route::get('/customer/profile', [CustomerController::class, 'editProfile'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    Route::get('/customer/password', [CustomerController::class, 'editPassword'])->name('customer.password');
    Route::put('/customer/password/update', [CustomerController::class, 'updatePassword'])->name('customer.password.update');

    Route::get('/customer/address', [CustomerController::class, 'editAddress'])->name('customer.address');
    Route::post('/customer/address/update', [CustomerController::class, 'updateAddress'])->name('customer.address.update');
    
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-submit', [PageController::class, 'store'])->name('contact.submit');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');

// Home Page
Route::get('/', [PageController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('admin.rentals.index');
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('admin.rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('admin.rentals.store');
    Route::get('/rentals/{id}/edit', [RentalController::class, 'edit'])->name('admin.rentals.edit');
    Route::put('/rentals/{id}', [RentalController::class, 'update'])->name('admin.rentals.update');
    Route::delete('/rentals/{id}', [RentalController::class, 'destroy'])->name('admin.rentals.destroy');
    Route::patch('/rentals/{rental}/cancel', [RentalController::class, 'cancel'])->name('admin.rentals.cancel');

    // Car Management
    Route::get('/cars', [CarController::class, 'index'])->name('admin.cars.index');
    Route::get('/cars/create', [CarController::class, 'create'])->name('admin.cars.create');
    Route::post('/cars', [CarController::class, 'store'])->name('admin.cars.store');
    Route::get('/cars/{id}/edit', [CarController::class, 'edit'])->name('admin.cars.edit');
    Route::put('/cars/{id}', [CarController::class, 'update'])->name('admin.cars.update');
    Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name('admin.cars.destroy');

    // Customers Management
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('admin.customer.index');
    Route::get('/customers/create', [AdminCustomerController::class, 'create'])->name('admin.customer.create');
    Route::post('/customers', [AdminCustomerController::class, 'store'])->name('admin.customer.store');
    Route::get('/customers/{id}/edit', [AdminCustomerController::class, 'edit'])->name('admin.customer.edit');
    Route::put('/customers/{id}', [AdminCustomerController::class, 'update'])->name('admin.customer.update');
    Route::delete('/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customer.destroy');
});

// Admin Registration Route
Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.register')->middleware('auth', 'admin');
Route::post('/admin/register', [AdminController::class, 'register'])->middleware('auth', 'admin');

// Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'dashboard'])->name('admin.dashboard');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Password Reset
Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');


Route::delete('/rentals/{id}/cancel', [RentalController::class, 'cancel'])->name('rentals.cancel')->middleware('auth');