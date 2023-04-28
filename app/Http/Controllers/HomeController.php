<?php

namespace App\Http\Controllers;

use App\Models\CaraPesan;
use App\Models\CaraPesanGambar;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $slide = Slide::get();
    $kategori = Kategori::get();
    $produk = Produk::get();
    $cara_pesan = CaraPesan::get();
    $cara_pesan_gambar = CaraPesanGambar::first();

    return view('welcome', [
      'slide' => $slide,
      'kategori' => $kategori,
      'produk' => $produk,
      'cara_pesan' => $cara_pesan,
      'cara_pesan_gambar' => $cara_pesan_gambar
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
