<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
  use HasFactory;

  public function dataProvinsi() {
    return $this->belongsTo(WilayahProvince::class, 'provinsi', 'prov_id');
  }

  public function dataKabupaten() {
    return $this->belongsTo(WilayahCity::class, 'kabupaten', 'city_id');
  }

  public function dataKecamatan() {
    return $this->belongsTo(WilayahDistrict::class, 'kecamatan', 'dis_id');
  }
}
