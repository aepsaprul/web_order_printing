<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangTemplate extends Model
{
  use HasFactory;

  public function dataTemplate() {
    return $this->belongsTo(Template::class, 'template_id', 'id');
  }
  public function dataTemplateDetail() {
    return $this->belongsTo(TemplateDetail::class, 'template_detail_id', 'id');
  }
}
