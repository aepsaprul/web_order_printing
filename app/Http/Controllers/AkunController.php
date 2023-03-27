<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\WilKabupaten;
use App\Models\WilKecamatan;
use App\Models\WilProvinsi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AkunController extends Controller
{
  public function index()
  {
    return view('akun.dataDiri');
  }
  public function updateGambar(Request $request)
  {
    $customer = Customer::find($request->akun_id);

    if($request->hasFile('gambar')) {
      if (file_exists("img_customer/" . $customer->gambar)) {
        File::delete("img_customer/" . $customer->gambar);
      }
      $file = $request->file('gambar');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . "." . $extension;
      $file->move('img_customer/', $filename);
      $customer->gambar = $filename;
    }
    $customer->save();

    return response()->json([
      'status' => $request->all()
    ]);
  }
  public function editDataDiri($id)
  {
    $customer = Customer::find($id);

    return response()->json([
      'customer' => $customer
    ]);
  }
  public function updateDataDiri(Request $request)
  {
    $customer = Customer::find($request->id);

    if ($request->title == "nama_lengkap") {
      $customer->nama_lengkap = $request->nama;
    } else if ($request->title == "tanggal_lahir") {
      $customer->tanggal_lahir = $request->tanggal_lahir;
    } else if ($request->title == "jenis_kelamin") {
      $customer->jenis_kelamin = $request->jenis_kelamin;
    } else if ($request->title == "alamat") {
      if ($request->telepon) {
        $customer->telepon = $request->telepon;
      }
      $customer->provinsi = $request->provinsi;
      $customer->kabupaten = $request->kabupaten;
      $customer->kecamatan = $request->kecamatan;
      $customer->alamat = $request->alamat;
      $customer->kodepos = $request->kodepos;
    }

    $customer->save();

    return response()->json([
      'status' => 200
    ]);
  }
  public function editAlamat($id)
  {
    $customer = Customer::find($id);
    $provinsi = WilProvinsi::get();

    return response()->json([
      'customer' => $customer,
      'provinsi' => $provinsi
    ]);
  }
  public function editAlamatKota($id)
  {
    $kota = WilKabupaten::where('provinsi_id', $id)->get();

    return response()->json([
      'kota' => $kota
    ]);
  }
  public function editAlamatKecamatan($id)
  {
    $kecamatan = WilKecamatan::where('kabupaten_id', $id)->get();

    return response()->json([
      'kecamatan' => $kecamatan
    ]);
  }
  public function transaksi()
  {
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->limit(7)->orderBy('id', 'desc')->get();

    return view('akun.transaksi', ['transaksi' => $transaksi]);
  }
  public function ulasan()
  {
    $ulasan = Ulasan::where('customer_id', Auth::user()->id)->get();
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->where('status', '6')->get();

    return view('akun.ulasan', [
      'ulasan' => $ulasan,
      'transaksi' => $transaksi
    ]);
  }
  public function ulasanStore(Request $request)
  {
    $ulasan = new Ulasan;
    $ulasan->customer_id = Auth::user()->id;
    $ulasan->keranjang_id = $request->keranjang_id;
    $ulasan->produk_id = $request->produk_id;
    $ulasan->rating = $request->rating;
    $ulasan->keterangan = $request->keterangan;
    $ulasan->save();

    return response()->json([
      'status' => 200
    ]);
  }

  // mobile
  public function mAkun()
  {
    $customer = Customer::find(Auth::user()->id);

    return view('akun.mobile.index', ['customer' => $customer]);
  }
  public function mTransaksi()
  {
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->limit(10)->get();

    return view('akun.mobile.transaksi', ['transaksi' => $transaksi]);
  }
  public function mTransaksiDetail($id)
  {
    $transaksi = Transaksi::with([
        'dataKeranjang', 
        'dataKeranjang.produk',
        'dataKecamatan',
        'dataKabupaten',
        'dataProvinsi',
        'dataRekening',
        'dataTransaksiStatus',
        'dataTransaksiStatus.dataStatus'
      ])
      ->find($id);
    
    $keranjang_total = Keranjang::select(DB::raw('SUM(total) as total_harga'))
      ->where('customer_id', Auth::user()->id)
      ->where('transaksi_id', $id)
      ->first();

    return response()->json([
      'transaksi' => $transaksi,
      'keranjang_total' => $keranjang_total
    ]);
  }
}
