<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WilayahCity;
use App\Models\WilayahDistrict;
use App\Models\WilayahProvince;
use Illuminate\Http\Request;

class AkunController extends Controller
{
  public function index()
  {
    return view('akun.dataDiri');
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
    $provinsi = WilayahProvince::get();

    return response()->json([
      'customer' => $customer,
      'provinsi' => $provinsi
    ]);
  }
  public function editAlamatKota($id)
  {
    $kota = WilayahCity::where('prov_id', $id)->get();

    return response()->json([
      'kota' => $kota
    ]);
  }
  public function editAlamatKecamatan($id)
  {
    $kecamatan = WilayahDistrict::where('city_id', $id)->get();

    return response()->json([
      'kecamatan' => $kecamatan
    ]);
  }
  public function transaksi()
  {
    return view('akun.transaksi');
  }
  public function ulasan()
  {
    return view('akun.ulasan');
  }
}
