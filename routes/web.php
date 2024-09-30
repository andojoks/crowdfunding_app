<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DonationController;


// Route for the home page/dashboard
Route::get('/', [HomeController::class, 'index'])->name('dashboard');

// Route to list all open causes (publicly accessible)
Route::get('/causes', [DonationController::class, 'index'])->name('causes.index');

// Routes that require authentication
Route::middleware('auth')->group(function () {

    // Routes for user profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route to list the user's own causes (causes they created)
    Route::get('/my-causes', [DonationController::class, 'myCauses'])->name('causes.my');

    // Route to handle donations to a specific cause (authenticated users)
    Route::post('/causes/{id}/donation', [DonationController::class, 'donate'])->name('cause.donate');

    // Route to show the form to create a new cause
    Route::get('/causes/add', [DonationController::class, 'addCause'])->name('cause.create');

    // Route to handle the creation of a new cause
    Route::post('/causes/add', [DonationController::class, 'store'])->name('cause.create');

    // Route to show the form to edit an existing cause
    Route::get('/causes/{id}/edit', [DonationController::class, 'editCause'])->name('cause.edit');

    // Route to update an existing cause
    Route::put('/causes/{id}', [DonationController::class, 'update'])->name('cause.update');

    // Route to delete a cause (soft delete or permanent delete)
    Route::post('/causes/{id}/delete', [DonationController::class, 'delete'])->name('cause.delete');
});

// Route to show the details of a specific cause (publicly accessible)
Route::get('/causes/{id}', [DonationController::class, 'show'])->name('cause.details');


require __DIR__ . '/auth.php';


// Fallback route for 404 errors
Route::fallback(function () {
    return response()->view('404_not_found', [], 404);
});
