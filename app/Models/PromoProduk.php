<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoProduk extends Model
{
  use HasFactory;

  public function dataProduk() {
    return $this->belongsTo(Produk::class, 'produk_id', 'id');
  }
  public function dataPromo() {
    return $this->belongsTo(Promo::class, 'promo_id', 'id');
  }
}
