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

  public function dataKeranjang() {
    return $this->hasMany(Keranjang::class, 'transaksi_id', 'id');
  }

  public function dataKecamatan() {
    return $this->belongsTo(WilayahDistrict::class, 'kecamatan', 'dis_id');
  }

  public function dataKabupaten() {
    return $this->belongsTo(WilayahCity::class, 'kabupaten', 'city_id');
  }

  public function dataProvinsi() {
    return $this->belongsTo(WilayahProvince::class, 'provinsi', 'prov_id');
  }
}
