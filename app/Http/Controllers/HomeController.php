<?php

namespace App\Http\Controllers;

use App\Models\CaraPesan;
use App\Models\CaraPesanGambar;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\PromoProduk;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $slide = Slide::get();
    $kategori = Kategori::get();
    $produk = Produk::where('tampil', 'y')->orderBy('id', 'desc')->get();
    $cara_pesan = CaraPesan::get();
    $cara_pesan_gambar = CaraPesanGambar::first();
    $promo = Promo::where('aktif', 'y')->first();
    $promo_arr = [];

    if ($promo) {
      foreach ($promo->dataPromoProduk as $key => $value_promo) {
        $promo_arr[] = $value_promo->produk_id;
      }
    }

    $promo_produk = PromoProduk::whereHas('dataPromo', function ($query) {
        $query->where('aktif', 'y');
      })
      ->get();

    return view('welcome', [
      'slide' => $slide,
      'kategori' => $kategori,
      'produk' => $produk,
      'promo_arr' => $promo_arr,
      'cara_pesan' => $cara_pesan,
      'cara_pesan_gambar' => $cara_pesan_gambar,
      'promo' => $promo,
      'promo_produk' => $promo_produk
    ]);
  }
  public function cari(Request $request)
  {
    $cari = $request->cari;
    
    if ($cari == "focus") {
      $kategori = Kategori::get();
      $produk = 0;
    } else {
      $kategori = Kategori::where('nama', 'like', '%'.$request->kategori.'%')->get();
      $produk = Produk::where('nama', 'like', '%'.$request->kategori.'%')->get();
    }

    return response()->json([
      'kategori' => $kategori,
      'produk' => $produk
    ]);
  }
}
