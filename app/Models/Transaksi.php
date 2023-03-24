<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  use HasFactory;

  public function dataRekening() {
    return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
  }
  public function dataStatus() {
    return $this->belongsTo(Status::class, 'status', 'id');
  }
  public function dataTransaksiStatus() {
    return $this->hasMany(TransaksiStatus::class, 'transaksi_id', 'id');
  }
  public function dataKeranjang() {
    return $this->hasMany(Keranjang::class, 'transaksi_id', 'id');
  }
  public function dataKecamatan() {
    return $this->belongsTo(WilKecamatan::class, 'kecamatan', 'id');
  }
  public function dataKabupaten() {
    return $this->belongsTo(WilKabupaten::class, 'kabupaten', 'id');
  }
  public function dataProvinsi() {
    return $this->belongsTo(WilProvinsi::class, 'provinsi', 'id');
  }
}
