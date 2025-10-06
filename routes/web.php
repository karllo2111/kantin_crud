<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KantinController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [KantinController::class, 'index'])->name('index');
Route::post('/produk', [KantinController::class, 'store'])->name('kantinProduk.store');
Route::put('/produk/{id}', [KantinController::class, 'update'])->name('kantinProduk.update');
Route::delete('/produk/{id}', [KantinController::class, 'destroy'])->name('kantinProduk.destroy');