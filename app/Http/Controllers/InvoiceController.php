<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  public function index(Request $request)
  {
    $transaksi = Transaksi::where('kode', $request->kode)->first();

    return view('invoice', ['transaksi' => $transaksi]);
  }
}
