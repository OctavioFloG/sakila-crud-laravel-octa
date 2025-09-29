<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ActorController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StoreController;

use App\Models\Film;
use App\Models\Actor;
use App\Models\Customer;
use App\Models\Rental;

Route::get('/', function () {
    $stats = [
        'films'          => Film::count(),
        'actors'         => Actor::count(),
        'customers'      => Customer::count(),
        'active_rentals' => Rental::whereNull('return_date')->count(),
    ];

    $recentRentals = Rental::with(['inventory.film','customer'])
        ->orderByDesc('rental_id')
        ->limit(10)
        ->get();

    return view('welcome', compact('stats','recentRentals'));
});


Route::resource('actors', ActorController::class);
Route::resource('films', FilmController::class);

// Renta
Route::get('rentals/create', [RentalController::class, 'create'])->name('rentals.create');
Route::post('rentals', [RentalController::class, 'store'])->name('rentals.store');
// Devolución
Route::patch('rentals/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');

Route::resource('customers', CustomerController::class);
Route::resource('staff', StaffController::class)->parameters(['staff' => 'staff']); // evita choque con palabra reservada
Route::resource('stores', StoreController::class)->only(['index','show']); // suelen ser más “read-only”
