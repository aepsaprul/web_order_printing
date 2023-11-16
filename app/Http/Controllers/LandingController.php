<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use Illuminate\Http\Request;

class LandingController extends Controller
{
  public function index()
  {
    $landing = Landing::find(1);

    return view('landing.satu.index', ['landing' => $landing]);
  }
}
