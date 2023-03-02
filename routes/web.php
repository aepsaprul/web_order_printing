<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Monolog\Registry;
use Whoops\Run;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/auth', [LoginController::class, 'auth'])->name('login.auth');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register/store', [RegisterController::class, 'store'])->name('register.store');

// kategori
Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('kategori/{id}/show', [KategoriController::class, 'show'])->name('kategori.show');

// produk detail
Route::get('produk', [ProdukController::class, 'index'])->name('produk');
Route::get('produk/{id}/show', [ProdukController::class, 'show'])->name('produk.show');

Route::middleware(['auth'])->group(function() {
  
  // keranjang
  Route::get('keranjang', [KeranjangController::class, 'index'])->name('keranjang');
  Route::post('keranjang/store', [KeranjangController::class, 'store'])->name('keranjang.store');
  Route::post('keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
  Route::post('keranjang/kurang', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
  Route::post('keranjang/inputText', [KeranjangController::class, 'inputText'])->name('keranjang.inputText');
  Route::post('keranjang/hapus', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
  Route::get('keranjang/beli', [KeranjangController::class, 'beli'])->name('keranjang.beli');
  Route::get('keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
  Route::post('keranjang/bayar', [KeranjangController::class, 'bayar'])->name('keranjang.bayar');
  
  // akun
  Route::get('akun', [AkunController::class, 'index'])->name('akun');
  Route::get('akun/{id}/editDataDiri', [AkunController::class, 'editDataDiri'])->name('akun.editDataDiri');
  Route::post('akun/updateDataDiri', [AkunController::class, 'updateDataDiri'])->name('akun.updateDataDiri');
  Route::get('akun/{id}/editAlamat', [AkunController::class, 'editAlamat'])->name('akun.editAlamat');
  Route::get('akun/{id}/editAlamatKota', [AkunController::class, 'editAlamatKota'])->name('akun.editAlamatKota');
  Route::get('akun/{id}/editAlamatKecamatan', [AkunController::class, 'editAlamatKecamatan'])->name('akun.editAlamatKecamatan');
  Route::get('akun/transaksi', [AkunController::class, 'transaksi'])->name('akun.transaksi');
  Route::get('akun/ulasan', [AkunController::class, 'ulasan'])->name('akun.ulasan');
});

