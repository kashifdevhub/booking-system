<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Services\SearchServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    // Flights search
    Route::get('/search/flights', [SearchController::class, 'flights'])->name('search.flights');

    // Hotels search
    Route::get('/search/hotels', [SearchController::class, 'hotels'])->name('search.hotels');

    // Item details page (flight/hotel)

    Route::get('/flights/{id}', [SearchController::class, 'flightDetails'])->name('flights.details');
    Route::get('/hotels/{id}', [SearchController::class, 'hotelDetails'])->name('hotels.details');

    // Cart
    Route::post('/cart/add', [SearchController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [SearchController::class, 'showCart'])->name('cart.show');


    // Cart routes
    Route::post('/cart/add', [SearchController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [SearchController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/remove', [SearchController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [SearchController::class, 'clearCart'])->name('cart.clear');

    Route::get('/checkout', [BookingController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [BookingController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings',[AdminController::class,'bookings'])->name('bookings');
});
require __DIR__ . '/auth.php';
