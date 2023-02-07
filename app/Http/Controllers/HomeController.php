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
    $produk = Produk::limit(10)->get();
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
}
