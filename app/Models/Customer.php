<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
  use HasFactory;

  public function dataProvinsi() {
    return $this->belongsTo(WilProvinsi::class, 'provinsi', 'id');
  }

  public function dataKabupaten() {
    return $this->belongsTo(WilKabupaten::class, 'kabupaten', 'id');
  }

  public function dataKecamatan() {
    return $this->belongsTo(WilKecamatan::class, 'kecamatan', 'id');
  }
}
