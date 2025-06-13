<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    $controller = new DashboardController();
    return $controller->index(request(), [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'status' => session('status'),
    ]);
})->name('dashboard');

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     // Admin routes can be defined here
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard/Admin');
//     })->name('admin.dashboard');
// });

// Route::middleware(['auth', 'role:authenticated'])->group(function () {
//     // Authenticated user routes can be defined here
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard/Authenticated');
//     })->name('authenticated.dashboard');
// });

// Route::middleware(['auth', 'role:guest'])->group(function () {
//     // Guest user routes can be defined here
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard/Guest');
//     })->name('guest.dashboard');
// });

require __DIR__.'/auth.php';
