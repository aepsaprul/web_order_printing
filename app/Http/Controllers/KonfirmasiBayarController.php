<?php

namespace App\Http\Controllers;

use App\Models\KonfirmasiBayar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiBayarController extends Controller
{
  public function index()
  {
    $transaksi = Transaksi::whereNull('bayar')
      ->where('customer_id', Auth::user()->id)
      ->get();

    return view('konfirmasiBayar', ['transaksi' => $transaksi]);
  }
  public function store(Request $request)
  {
    $bayar = new KonfirmasiBayar;
    $bayar->customer_id = $request->akun_id;
    $bayar->transaksi_id = $request->transaksi_id;
    
    if($request->hasFile('gambar')) {
      $file = $request->file('gambar');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . "." . $extension;
      $file->move('img_bayar/', $filename);
      $bayar->gambar = $filename;
    }

    $bayar->save();

    // transaksi
    $transaksi = Transaksi::find($request->transaksi_id);
    $transaksi->bayar = 'y';
    $transaksi->save();

    return response()->json([
      'status' => 200
    ]);
  }
}
