<?php

use App\Http\Controllers\BeerController;
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

Route::group(['prefix' => 'beers'], function () {
    Route::get('/', [BeerController::class, 'index'])->name('beers.index')->middleware(['auth', 'verified']);
    Route::get('/export', [BeerController::class, 'export'])->name('beers.export')->middleware(['auth', 'verified']);
});

