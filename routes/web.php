<?php

use App\Http\Controllers\BeerController;
use App\Http\Controllers\ExportController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', function () {
    return Inertia::render('Profile');
})->middleware(['auth', 'verified'])->name('profile');

require __DIR__.'/auth.php';

Route::group(['prefix' => 'beers', 'middleware' => 'auth'], function () {
    Route::get('/', [BeerController::class, 'index'])->name('beers');
    Route::post('/export', [BeerController::class, 'export'])->name('beers.export');
    Route::resource('/reports', ExportController::class)
        ->only(['index', 'destroy', 'show']);
});

