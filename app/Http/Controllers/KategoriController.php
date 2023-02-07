<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
  public function index()
  {
    $kategori = Kategori::get();

    return view('kaktegori', ['kategori' => $kategori]);
  }
  public function show($id)
  {
    $kategori = Kategori::find($id);
    $produk = Produk::where('kategori_id', $kategori->id)->get();

    return view('kategoriShow', [
      'kategori' => $kategori,
      'produk' => $produk
    ]);
  }
}
