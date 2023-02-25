<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
  public function index()
  {
    $keranjang = Keranjang::get();
    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))->first();

    return view('keranjang', [
      'keranjang' => $keranjang,
      'keranjang_total' => $keranjang_total
    ]);
  }
  public function store(Request $request)
  {
    $keranjang = new Keranjang;
    $keranjang->customer_id = 1;
    $keranjang->produk_id = $request->produk_id;
    $keranjang->qty = $request->qty;
    $keranjang->total = $request->total;
    $keranjang->save();

    return response()->json([
      'status' => 200
    ]);
  }
}
