<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\DataVoucherController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/home');

// Public Routes
Route::get('/home', [LandingPageController::class, 'home'])->name('home');
Route::get('/shop', [LandingPageController::class, 'shop'])->name('shop');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/loginCheck', [LoginController::class, 'loginCheck'])->name('loginCheck');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.store');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('dashboard', DashboardController::class);
        Route::get('dataOrder', [DashboardController::class, 'dataOrder'])->name('dataOrder');
        Route::get('dataUsers', [DashboardController::class, 'dataUsers'])->name('dataUsers');
        Route::put('dashboard/updateRole/{id}', [DashboardController::class, 'updateRole'])->name('dataUsers.updateRole');
        Route::delete('dashboard/destroyUsers/{id}', [DashboardController::class, 'destroyUsers'])->name('destroyUsers');
        Route::delete('dataProduk/forceDelete/{id}', [DataProdukController::class, 'forceDelete'])->name('forceDeleteProduk');
    });

// Admin & Kasir Shared Routes
Route::middleware('role:admin,kasir')->group(function () {
    Route::resource('dataProduk', DataProdukController::class);
    Route::get('kasir', [LandingPageController::class, 'kasir'])->name('kasir');
    Route::post('/pembayaran/{id}', [LandingPageController::class, 'pembayaran'])->name('pembayaran');
    Route::get('nota/{id}', [LandingPageController::class, 'nota'])->name('nota');
    Route::delete('dataProduk/softDelete/{id}', [DataProdukController::class, 'softDelete'])->name('softDeleteProduk');
    Route::get('/recyclebin', [DataProdukController::class, 'recyclebin'])->name('recyclebin');
    Route::patch('dataProduk/restore/{id}', [DataProdukController::class, 'restore'])->name('restoreProduk');
    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('updateProfile');
});

// Admin, Kasir, Pelanggan Shared Routes
Route::middleware('role:admin,kasir,pelanggan')->group(function () {
    Route::post('keranjang/updateJumlah', [KeranjangController::class, 'updateKeranjang'])->name('keranjang.updateKeranjang');
    Route::delete('/keranjang/delete', [KeranjangController::class, 'deleteKeranjang'])->name('keranjang.deleteKeranjang');
    Route::get('/keranjang/count', [KeranjangController::class, 'getCartCount'])->name('keranjang.count');
    Route::get('keranjangPage', [KeranjangController::class, 'keranjangPage'])->name('keranjangPage');
    Route::get('keranjangCheckout', [KeranjangController::class, 'keranjangCheckout'])->name('keranjangCheckout');
});




// Route::redirect('/', '/home');

// Route::get('/home', function () {
//     return view('landingPage.home');
// });

// Route::get('home', [LandingPageController::class, 'home'])->name('home');
// Route::get('shop', [LandingPageController::class, 'shop'])->name('shop');

// Route::resource('dashboard', DashboardController::class);
// Route::resource('dataProduk', DataProdukController::class);

// Route::Post('keranjang/updateJumlah', [KeranjangController::class, 'updateKeranjang'])->name('keranjang.updateKeranjang');
// Route::delete('/keranjang/delete', [KeranjangController::class, 'deleteKeranjang'])->name('keranjang.deleteKeranjang');
// Route::get('/keranjang/count', [KeranjangController::class, 'getCartCount'])->name('keranjang.count');
// Route::get('keranjangPage', [KeranjangController::class, 'keranjangPage'])->name('keranjangPage');
// Route::get('keranjangCheckout', [KeranjangController::class, 'keranjangCheckout'])->name('keranjangCheckout');

// Route::get('/checkout', [KeranjangController::class, 'keranjangCheckout'])->name('keranjangCheckout');
// Route::get('kasir', [LandingPageController::class, 'kasir'])->name('kasir');
// Route::post('/pembayaran/{id}', [LandingPageController::class, 'pembayaran'])->name('pembayaran');
// Route::get('nota/{id}', [LandingPageController::class, 'nota'])->name('nota');

// Route::resource('login', LoginController::class);
// Route::post('loginCheck', [LoginController::class, 'loginCheck'])->name('loginCheck');
// Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('register', [LoginController::class, 'register'])->name('register');