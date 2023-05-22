<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
  use HasFactory;

  public function dataPromoProduk() {
    return $this->hasMany(PromoProduk::class, 'promo_id', 'id');
  }
}
