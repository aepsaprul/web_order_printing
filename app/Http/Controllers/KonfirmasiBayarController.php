<?php

namespace App\Http\Controllers;

use App\Models\KonfirmasiBayar;
use App\Models\Transaksi;
use App\Models\TransaksiStatus;
use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiBayarController extends Controller
{
  public function index()
  {
    $transaksi = Transaksi::whereNull('bayar')
      ->where('customer_id', Auth::user()->id)
      ->where('status', '1')
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
    $transaksi->status = 2;
    $transaksi->save();

    // transaksi status
    $transaksi_status = new TransaksiStatus;
    $transaksi_status->transaksi_id = $request->transaksi_id;
    $transaksi_status->status_id = 2;
    $transaksi_status->keterangan = "Pembayaran sedang di cek oleh Admin";
    $transaksi_status->save();

    // notif
    $notif = Notif::where('tipe', 'pembayaran')->where('customer_id', Auth::user()->id)->whereNull('status')->first();
    $notif->status = "read";
    $notif->save();

    $notif_admin = new Notif;
    $notif_admin->tipe = "konfirmasiBayar";
    $notif_admin->deskripsi = "Transaksi " .$transaksi->kode. " Sudah Bayar";
    $notif_admin->link = "transaksi";
    $notif_admin->save();

    return response()->json([
      'status' => 200
    ]);
  }
}
