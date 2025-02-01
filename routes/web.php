<?php

use App\Http\Controllers\DashboardPetugasController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\DataVoucherController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\landingPage;
use App\Http\Controllers\landingPageController;
use App\Http\Controllers\LoginController;
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

Route::get('/home', function () {
    return view('landingPage.home');
});

Route::get('home', [landingPageController::class, 'home'])->name('home');
Route::get('shop', [landingPageController::class, 'shop'])->name('shop');

Route::resource('dashboardPetugas', DashboardPetugasController::class);
Route::resource('dataProduk', DataProdukController::class);
Route::resource('dataVoucher', DataVoucherController::class);

Route::Post('keranjang/updateJumlah', [KeranjangController::class, 'updateKeranjang'])->name('keranjang.updateKeranjang');
Route::delete('/keranjang/delete', [KeranjangController::class, 'deleteKeranjang'])->name('keranjang.deleteKeranjang');
Route::get('/keranjang/count', [KeranjangController::class, 'getCartCount'])->name('keranjang.count');

Route::resource('login', LoginController::class);
Route::post('loginCheck', [LoginController::class, 'loginCheck'])->name('loginCheck');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [LoginController::class, 'register'])->name('register');
