<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\WilKabupaten;
use App\Models\WilKecamatan;
use App\Models\WilProvinsi;
use App\Models\Ulasan;
use App\Models\Produk;
use App\Models\Notif;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
      'status' => 200
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
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->limit(10)->orderBy('id', 'desc')->get();

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
  public function ulasanForm($id)
  {
    $keranjang = Keranjang::find($id);
    $produk = Produk::find($keranjang->produk_id);
    
    return view('akun.ulasanForm', ['keranjang' => $keranjang, 'produk' => $produk]);
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

    return redirect()->route('akun.ulasan');
  }
  public function ubahPassword()
  {
    return view('akun.ubahPassword');
  }
  public function ubahPasswordStore(Request $request)
  {
    // validation
    $request->validate([
      'old_password' => 'required',
      'new_password' => 'required'
    ]);

    // match old password
    if (!Hash::check($request->old_password, auth()->user()->password)) {
      return back()->with("error", "Password lama tidak cocok");
    } else if ($request->new_password_confirmation != $request->new_password) {
      return back()->with("error", "Password Konfirmasi tidak cocok");
    }

    // update password baru
    Customer::whereId(auth()->user()->id)->update([
      'password' => Hash::make($request->new_password)
    ]);

    return back()->with("status", "Password berhasil diperbaharui");
  }

  // mobile
  public function mAkun()
  {
    $customer = Customer::find(Auth::user()->id);

    return view('akun.mobile.index', ['customer' => $customer]);
  }
  public function mTransaksi()
  {
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->orderBy('id', 'desc')->limit(10)->get();

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
  public function mUlasan()
  {
    $ulasan = Ulasan::where('customer_id', Auth::user()->id)->get();
    $transaksi = Transaksi::where('customer_id', Auth::user()->id)->where('status', '6')->get();

    return view('akun.mobile.ulasan', [
      'ulasan' => $ulasan,
      'transaksi' => $transaksi
    ]);
  }
  public function mUlasanForm($id)
  {
    $keranjang = Keranjang::find($id);
    $produk = Produk::find($keranjang->produk_id);
    
    return view('akun.mobile.ulasanForm', ['keranjang' => $keranjang, 'produk' => $produk]);
  }
  public function mUlasanStore(Request $request)
  {
    $ulasan = new Ulasan;
    $ulasan->customer_id = Auth::user()->id;
    $ulasan->keranjang_id = $request->keranjang_id;
    $ulasan->produk_id = $request->produk_id;
    $ulasan->rating = $request->rating;
    $ulasan->keterangan = $request->keterangan;
    $ulasan->save();

    return redirect()->route('mUlasan');
  }
  public function mUbahPassword()
  {
    return view('akun.mobile.ubahPassword');
  }
  public function mUbahPasswordStore(Request $request)
  {
    // validation
    $request->validate([
      'old_password' => 'required',
      'new_password' => 'required'
    ]);

    // match old password
    if (!Hash::check($request->old_password, auth()->user()->password)) {
      return back()->with("error", "Password lama tidak cocok");
    } else if ($request->new_password_confirmation != $request->new_password) {
      return back()->with("error", "Password Konfirmasi tidak cocok");
    }

    // update password baru
    Customer::whereId(auth()->user()->id)->update([
      'password' => Hash::make($request->new_password)
    ]);

    return back()->with("status", "Password berhasil diperbaharui");
  }
  public function mUbahGambar()
  {
    return view('akun.mobile.editGambar');
  }
  public function mUbahGambarUpdate(Request $request)
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
      'status' => 200
    ]);
  }
  public function mUbahBio()
  {
    $customer = Customer::find(Auth::user()->id);

    return view('akun.mobile.editBio', ['customer' => $customer]);
  }
  public function mUbahBioUpdate(Request $request)
  {
    $customer = Customer::find(Auth::user()->id);
    $customer->nama_lengkap = $request->nama;
    $customer->telepon = $request->telepon;
    $customer->jenis_kelamin = $request->jenis_kelamin;
    $customer->tanggal_lahir = $request->tanggal_lahir;
    $customer->save();

    return redirect()->route('mAkun');
  }
  public function mUbahAlamat()
  {
    $customer = Customer::find(Auth::user()->id);
    $provinsi = WilProvinsi::get();
    $kota = WilKabupaten::get();
    $kecamatan = WilKecamatan::get();
    
    return view('akun.mobile.editAlamat', [
      'customer' => $customer,
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan
    ]);
  }
  public function mUbahAlamatUpdate(Request $request)
  {
    $customer = Customer::find(Auth::user()->id);
    $customer->provinsi = $request->select_provinsi;
    $customer->kabupaten = $request->select_kota;
    $customer->kecamatan = $request->select_kecamatan;
    $customer->alamat = $request->alamat;
    $customer->kodepos = $request->kodepos;
    $customer->save();

    return redirect()->route('mAkun');
  }

  // member
  public function memberForm()
  {
    $customer = Customer::find(Auth::user()->id);

    return view('memberForm', ['customer' => $customer]);
  }
  public function memberStore(Request $request)
  {
    $customer = Customer::find(Auth::user()->id);
    
    if ($request->member_title == "baru") {
      $customer->nik = $request->nik;
      $customer->email = $request->email;
    }

    $customer->nama_lengkap = $request->nama;
    $customer->telepon = $request->telepon;    
    $customer->segmen = "proses_" . $request->member_title;
    $customer->save();

    // notif
    $notif = new Notif;
    $notif->tipe = "member_" . $request->member_title;
    $notif->link = "akun";
    $notif->customer_id = Auth::user()->id;

    if ($request->member_title == "baru") {
      $notif->deskripsi = "Segera lakukan pembayaran sejumlah Rp 15.000 untuk jadi member";
    } else {
      $notif->deskripsi = "Data Anda sedang di cek oleh Admin";
    }
    
    $notif->save();

    $notif_admin = new Notif;
    $notif_admin->tipe = "member";
    $notif_admin->deskripsi = $request->nama . " daftar member " . $request->member_title;
    $notif_admin->link = "customer";
    $notif_admin->save();

    return redirect()->route('akun.memberBayar');
  }
  public function memberBayar()
  {
    $rekening = Rekening::first();

    return view('memberBayar', ['rekening' => $rekening]);
  }
}
