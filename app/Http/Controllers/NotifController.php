<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifController extends Controller
{
  public function index()
  {
    return view('notif');
  }
  public function list()
  {
    $notif = Notif::where('customer_id', Auth::user()->id)->whereNull('status')->get();

    return response()->json([
      'notif' => $notif
    ]);
  }
}
