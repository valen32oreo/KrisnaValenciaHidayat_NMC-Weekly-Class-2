<?php

use App\Http\Controllers\FoodItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FoodItemController::class, 'index'])->name('home');
Route::post('/store', [FoodItemController::class, 'store'])->name('store');
Route::post('/reserve/{id}', [FoodItemController::class, 'reserve'])->name('reserve');

Route::get('/perancangan', function () {
    return view('perancangan');
})->name('perancangan');