<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\KonfirmasiBayarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NotifController;
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
Route::post('cari', [HomeController::class, 'cari'])->name('home.cari');

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
  Route::get('keranjang/ajaks', [KeranjangController::class, 'ajaks'])->name('keranjang.ajaks');
  Route::post('keranjang/updateGambar', [KeranjangController::class, 'updateGambar'])->name('keranjang.updateGambar');

  Route::middleware(['back-page'])->group(function () {
    Route::get('keranjang/{id}/kecamatan', [KeranjangController::class, 'kecamatan'])->name('keranjang.kecamatan');
    Route::post('keranjang/ongkir', [KeranjangController::class, 'ongkir'])->name('keranjang.ongkir');
    Route::get('keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::post('keranjang/bayar', [KeranjangController::class, 'bayar'])->name('keranjang.bayar');
  
    Route::get('invoice/{kode}', [InvoiceController::class, 'index'])->name('invoice');
  });
  
  // akun
  Route::get('akun', [AkunController::class, 'index'])->name('akun');
  Route::post('akun/gambar', [AkunController::class, 'updateGambar'])->name('akun.updateGambar');
  Route::get('akun/{id}/editDataDiri', [AkunController::class, 'editDataDiri'])->name('akun.editDataDiri');
  Route::post('akun/updateDataDiri', [AkunController::class, 'updateDataDiri'])->name('akun.updateDataDiri');
  Route::get('akun/{id}/editAlamat', [AkunController::class, 'editAlamat'])->name('akun.editAlamat');
  Route::get('akun/{id}/editAlamatKota', [AkunController::class, 'editAlamatKota'])->name('akun.editAlamatKota');
  Route::get('akun/{id}/editAlamatKecamatan', [AkunController::class, 'editAlamatKecamatan'])->name('akun.editAlamatKecamatan');
  Route::get('akun/transaksi', [AkunController::class, 'transaksi'])->name('akun.transaksi');
  Route::get('akun/transaksi/{id}/detail', [AkunController::class, 'transaksiDetail'])->name('akun.transaksiDetail');
  Route::get('akun/ulasan', [AkunController::class, 'ulasan'])->name('akun.ulasan');
  Route::get('akun/ulasan/{id}/form', [AkunController::class, 'ulasanForm'])->name('akun.ulasan.form');
  Route::post('akun/ulasan/store', [AkunController::class, 'ulasanStore'])->name('akun.ulasan.store');
  Route::get('akun/ubahPassword', [AkunController::class, 'ubahPassword'])->name('akun.ubahPassword');
  Route::post('akun/ubahPasswordStore', [AkunController::class, 'ubahPasswordStore'])->name('akun.ubahPasswordStore');

  // akun mobile
  Route::get('mAkun', [AkunController::class, 'mAkun'])->name('mAkun');
  Route::get('mAkun/transaksi', [AkunController::class, 'mTransaksi'])->name('mTransaksi');
  Route::get('mAkun/transaksi/{id}/detail', [AkunController::class, 'mTransaksiDetail'])->name('mTransaksi.detail');
  Route::get('mAkun/ulasan', [AkunController::class, 'mUlasan'])->name('mUlasan');
  Route::get('mAkun/ulasan/{id}/form', [AkunController::class, 'mUlasanForm'])->name('mUlasan.form');
  Route::post('mAkun/ulasan/store', [AkunController::class, 'mUlasanStore'])->name('mUlasan.store');
  Route::get('mAkun/ubahPassword', [AkunController::class, 'mUbahPassword'])->name('mUbahPassword');
  Route::post('mAkun/ubahPasswordStore', [AkunController::class, 'mUbahPasswordStore'])->name('mUbahPasswordStore');

  // konfirmasi bayar
  Route::get('konfirmasi_bayar', [KonfirmasiBayarController::class, 'index'])->name('konfirmasi_bayar');
  Route::post('konfirmasi_bayar/store', [KonfirmasiBayarController::class, 'store'])->name('konfirmasi_bayar.store');

  // notif
  Route::get('notif', [NotifController::class, 'index'])->name('notif');
  Route::get('notif/list', [NotifController::class, 'list'])->name('notif.list');
});

