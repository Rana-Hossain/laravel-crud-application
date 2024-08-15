<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/product',[ProductController::class,'index'])->name('product.index');
Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
Route::post('/product',[ProductController::class,'store'])->name('product.store');
Route::get('/product/{product}/update',[ProductController::class,'edit'])->name('product.update');
Route::put('/product/{product}/update1',[ProductController::class,'update'])->name('product.update1');
Route::delete('/product/{product}/delete',[ProductController::class,'delete'])->name('product.delete');
Route::post('/category/store', [CategoryController::class, 'storeCategory'])->name('category.store');
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/products/export', [ProductController::class, 'export'])->name('product.export');
Route::get('/registration',[RegistrationController::class,'showRegistrationForm'])->name('user.userRegistration');
Route::get('/login',[LoginController::class,'showLoginForm'])->name('user.login');
Route::post('/registration',[RegistrationController::class,'register'])->name('user.userRegistration');
Route::post('/login',[LoginController::class,'login'])->name('user.login');
