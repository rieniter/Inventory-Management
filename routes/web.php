<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SkuController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Public Router
Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Auth Router
Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function(){

    Route::get('/', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoryController::class)->names('dashboard.categories');
    Route::resource('skus', SkuController::class)->names('dashboard.skus');
    Route::resource('products', ProductController::class)->names('dashboard.products');
});



require __DIR__.'/settings.php';
