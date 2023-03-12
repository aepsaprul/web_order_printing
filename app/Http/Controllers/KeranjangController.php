<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ekspedisi;
use App\Models\Keranjang;
use App\Models\KeranjangTemplate;
use App\Models\Rekening;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KeranjangController extends Controller
{
  public function index()
  {
    $keranjang = Keranjang::where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->get();
    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
      ->where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->first();

    return view('keranjang', [
      'keranjang' => $keranjang,
      'keranjang_total' => $keranjang_total
    ]);
  }
  public function ajaks()
  {
    $keranjang = Keranjang::where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->get();

    return response()->json([
      'keranjang' => $keranjang
    ]);
  }
  public function store(Request $request)
  {
    $keranjang = new Keranjang;
    $keranjang->customer_id = Auth::user()->id;
    $keranjang->produk_id = $request->produk_id;
    $keranjang->harga = $request->harga;
    $keranjang->qty = $request->qty;
    $keranjang->total = $request->total;
    $keranjang->keterangan = $request->keterangan;
    $keranjang->save();

    $template = $request->template;
    $template_detail = $request->template_detail;

    foreach ($template as $key => $value) {
      $keranjang_template = new KeranjangTemplate;
      $keranjang_template->template_id = $value;
      $keranjang_template->template_detail_id = $template_detail[$key];
      $keranjang_template->keranjang_id = $keranjang->id;
      $keranjang_template->save();
    }

    $jml_keranjang = Keranjang::where('customer_id', Auth::user()->id)
    ->where('transaksi_id', null)
    ->get();

    return response()->json([
      'status' => 200,
      'jml_keranjang' => $jml_keranjang
    ]);
  }
  public function tambah(Request $request)
  {
    $keranjang = Keranjang::find($request->id);
    $keranjang->qty = $request->qty;
    $keranjang->total = $keranjang->total + $request->harga;
    $keranjang->save();

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
      ->where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->first();

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

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
      ->where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->first();

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

    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
      ->where('customer_id', Auth::user()->id)
      ->where('transaksi_id', null)
      ->first();

    return response() ->json([
      'total_harga' => $keranjang_total->total_harga
    ]);
  }
  public function hapus(Request $request)
  {
    $keranjang = Keranjang::find($request->id);

    $keranjang_template = KeranjangTemplate::where('keranjang_id', $request->id);
    $keranjang_template->delete();

    $keranjang->delete();

    return response()->json([
      'status' => 200
    ]);
  }
  public function beli()
  {
    $session_checkout = session('checkout');
    session(['checkout' => "true"]);

    return response()->json([
      'status' => 200
    ]);
  }
  public function checkout(Request $request)
  {
    if ($request->session()->has('checkout')) {
      $keranjang = Keranjang::where('customer_id', Auth::user()->id)
        ->where('transaksi_id', null)
        ->get();
      $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
        ->where('customer_id', Auth::user()->id)
        ->where('transaksi_id', null)
        ->first();
      $ekspedisi = Ekspedisi::get();
      $rekening = Rekening::get();
      $rekening_bank = Rekening::where('grup', 'bank')->get();
      $rekening_ewallet = Rekening::where('grup', 'e-wallet')->get();
      
      return view('checkout', [
        'keranjang' => $keranjang,
        'keranjang_total' => $keranjang_total,
        'ekspedisi' => $ekspedisi,
        'rekening' => $rekening,
        'rekening_bank' => $rekening_bank,
        'rekening_ewallet' => $rekening_ewallet
      ]);
    } else {
      return redirect()->route('home');
    }
  }
  public function bayar(Request $request)
  {
    $customer = Customer::find($request->customer_id);
    $ekspedisi = Ekspedisi::find($request->ekspedisi);
    $kode_unik = rand(000, 333);

    $transaksi = new Transaksi;
    $transaksi->kode = Str::random(8);
    $transaksi->customer_id = $request->customer_id;
    $transaksi->status = 1;
    $transaksi->penerima = $customer->nama_lengkap;
    $transaksi->total = $request->total_harga + $kode_unik;
    $transaksi->kode_unik = $kode_unik;
    $transaksi->rekening_id = $request->rekening;
    $transaksi->alamat = $customer->alamat;
    $transaksi->provinsi = $customer->provinsi;
    $transaksi->kabupaten = $customer->kabupaten;
    $transaksi->kecamatan = $customer->kecamatan;
    $transaksi->kodepos = $customer->kodepos;
    $transaksi->ekspedisi = $ekspedisi->nama;
    $transaksi->ongkir = $ekspedisi->harga;
    $transaksi->save();

    $keranjang_id = $request->keranjang_id;
    foreach ($keranjang_id as $key => $value) {
      $keranjang = Keranjang::find($value);
      $keranjang->transaksi_id = $transaksi->id;
      $keranjang->save();
    }

    $request->session()->forget('checkout');
    
    return response()->json([
      'status' => $transaksi->kode
    ]);
  }
}
