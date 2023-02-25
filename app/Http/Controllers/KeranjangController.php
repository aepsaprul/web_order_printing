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
  public function tambah(Request $request)
  {
    $keranjang = Keranjang::find($request->id);
    $keranjang->qty = $request->qty;
    $keranjang->total = $keranjang->total + $request->harga;
    $keranjang->save();

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))->first();

    return response()->json([
      'total_harga' => $keranjang_total->total_harga
    ]);
  }
  public function kurang(Request $request)
  {
    $keranjang = Keranjang::find($request->id);
    $keranjang->qty = $request->qty;
    $keranjang->total = $keranjang->total - $request->harga;
    $keranjang->save();

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))->first();

    return response() ->json([
      'total_harga' => $keranjang_total->total_harga
    ]);
  }
  public function inputText(Request $request)
  {
    $id = $request->id;
    $harga = $request->harga;
    $qty = $request->qty;

    $keranjang = Keranjang::find($id);
    $diffQty = $qty > $keranjang->qty; // jika qty lebih besar dari yg ada di DB

    if ($diffQty) {
      $calcQty = $qty - $keranjang->qty; // value qty di kurangi qty yg ada di DB untuk mendapatkan qty yg baru
      $calcHarga = $calcQty * $harga; // qty yg baru kemudian dikali harga produk

      $keranjang->total = $keranjang->total + $calcHarga; // update qty
    } else {
      $calc = $keranjang->qty - $qty; // qty yg ada di DB di kurangi value qty
      $calcHarga = $calc * $harga; // qty yg yg sudah dikurangi kemudian di kali harga produk
      
      $keranjang->total = $keranjang->total - $calcHarga; // update qty
    }
    $keranjang->qty = $request->qty;
    $keranjang->save();

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))->first();

    return response() ->json([
      'total_harga' => $keranjang_total->total_harga
    ]);
  }
  public function hapus(Request $request)
  {
    $keranjang = Keranjang::find($request->id);
    $keranjang->delete();

    return response()->json([
      'status' => 200
    ]);
  }
  public function hapusAll()
  {
    
  }
}
