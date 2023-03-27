<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
  use HasFactory;

  public function dataProduk() {
    return $this->belongsTo(Produk::class, 'produk_id', 'id');
  }
  public function dataCustomer() {
    return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
