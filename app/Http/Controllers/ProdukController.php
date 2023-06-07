<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukTemplate;
use App\Models\ProdukTemplateDetail;
use App\Models\Promo;
use App\Models\Template;
use App\Models\TemplateDetail;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
  public function index()
  {
    $produk = Produk::where('tampil', 'y')->orderBy('id', 'desc')->get();

    return view('produk', ['produk' => $produk]);
  }
  public function show($id)
  {
    $produk = Produk::find($id);
    $produk_template = ProdukTemplate::where('produk_id', $id)->get();
    $produk_template_detail = ProdukTemplateDetail::where('produk_id', $id)->get();
    $template = Template::get();
    $template_detail = TemplateDetail::get();
    $ulasan = Ulasan::where('produk_id', $id)->get();
    $ulasan_total = Ulasan::select(DB::raw('SUM(rating) as total_rating'))
      ->where('produk_id', $id)
      ->first();
    $promo = Promo::where('aktif', 'y')->first();
    if ($promo) {
      if ($promo->satuan == "persen") {
        $diskon = $produk->harga * ($promo->diskon / 100);
        $produk_harga = $produk->harga - $diskon;
      } else {
        $produk_harga = $produk->harga - $promo->diskon;
      }
    } else {
      $produk_harga = $produk->harga;
    }
    
    
    return view('produkDetail', [
      'produk' => $produk,
      'produk_template' => $produk_template,
      'produk_harga' => $produk_harga,
      'produk_template_detail' => $produk_template_detail,
      'template' => $template,
      'template_detail' => $template_detail,
      'ulasan' => $ulasan,
      'ulasan_total' => $ulasan_total,
      'promo' => $promo
    ]);
  }
}
