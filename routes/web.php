<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('home');
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'admin_index'])->name('admin.products.index');
    Route::get('/admin/getProducts', [ProductController::class, 'getProducts']);
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}/update', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    
    Route::get('/admin/reviews', [ReviewController::class, 'admin_index'])->name('admin.reviews.index');
    Route::get('/admin/getReviews', [ReviewController::class, 'getReviews']);
    Route::get('/admin/reviews/{review}/valid', [ReviewController::class, 'valid'])->name('admin.reviews.valid');
    Route::get('/admin/reviews/{review}/invalid', [ReviewController::class, 'invalid'])->name('admin.reviews.invalid');
    Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/products/{productId}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
