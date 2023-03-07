<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukTemplate;
use App\Models\ProdukTemplateDetail;
use App\Models\Template;
use App\Models\TemplateDetail;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
  public function index()
  {
    $produk = Produk::get();

    return view('produk', ['produk' => $produk]);
  }
  public function show($id)
  {
    $produk = Produk::find($id);
    $produk_template = ProdukTemplate::where('produk_id', $id)->get();
    $produk_template_detail = ProdukTemplateDetail::where('produk_id', $id)->get();
    $template = Template::get();
    $template_detail = TemplateDetail::get();

    return view('produkDetail', [
      'produk' => $produk,
      'produk_template' => $produk_template,
      'produk_template_detail' => $produk_template_detail,
      'template' => $template,
      'template_detail' => $template_detail
    ]);
  }
}
