<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/san-pham',[ProductController::class,'index'])->name('products.index');
Route::get('/san-pham/{product:slug}',[ProductController::class,'show'])->name('products.show');
Route::get('/cua-hang',[HomeController::class,'store'])->name('store');
Route::get('/lien-he',[ContactController::class,'create'])->name('contact.create');
Route::post('/lien-he',[ContactController::class,'store'])->name('contact.store');

Route::middleware('guest')->group(function(){
 Route::get('/dang-ky',[AuthController::class,'showRegister'])->name('register');
 Route::post('/dang-ky',[AuthController::class,'register'])->name('register.submit');
 Route::get('/dang-nhap',[AuthController::class,'showLogin'])->name('login');
 Route::post('/dang-nhap',[AuthController::class,'login'])->name('login.submit');
});
Route::post('/dang-xuat',[AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function(){
 Route::get('/gio-hang',[CartController::class,'index'])->name('cart.index');
 Route::post('/gio-hang',[CartController::class,'store'])->name('cart.store');
 Route::patch('/gio-hang/{item}',[CartController::class,'update'])->name('cart.update');
 Route::delete('/gio-hang/{item}',[CartController::class,'destroy'])->name('cart.destroy');
 Route::get('/thanh-toan',[OrderController::class,'checkout'])->name('checkout');
 Route::post('/thanh-toan',[OrderController::class,'place'])->name('checkout.place');
 Route::get('/don-hang',[OrderController::class,'index'])->name('orders.index');
 Route::get('/don-hang/{order}',[OrderController::class,'show'])->name('orders.show');
 Route::post('/danh-gia',[ReviewController::class,'store'])->name('reviews.store');
});
Route::prefix('admin')->name('admin.')->middleware(['auth',\App\Http\Middleware\AdminOnly::class])->group(function(){
 Route::get('/',[ProductAdminController::class,'dashboard'])->name('dashboard');
 Route::resource('san-pham',ProductAdminController::class)->parameters(['san-pham'=>'product']);
 Route::get('/don-hang',[OrderAdminController::class,'index'])->name('orders.index');
 Route::patch('/don-hang/{order}',[OrderAdminController::class,'update'])->name('orders.update');
});
