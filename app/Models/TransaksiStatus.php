<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiStatus extends Model
{
  use HasFactory;

  public function dataStatus() {
    return $this->belongsTo(Status::class, 'status_id', 'id');
  }
}
