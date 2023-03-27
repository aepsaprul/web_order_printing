<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
  use HasFactory;
  
  public function dataKeranjangTemplate() {
    return $this->hasMany(KeranjangTemplate::class, 'keranjang_id', 'id');
  }
  public function produk() {
    return $this->belongsTo(Produk::class, 'produk_id', 'id');
  }
  public function dataUlasan() {
    return $this->hasMany(Ulasan::class, 'keranjang_id', 'id');
  }
}
