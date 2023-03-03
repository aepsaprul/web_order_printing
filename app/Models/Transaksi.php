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
}
