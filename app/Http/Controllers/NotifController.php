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
  public function tandai()
  {
    $notif = Notif::where('customer_id', Auth::user()->id)->whereNull('status')->get();
    foreach ($notif as $key => $item) {
      $notif_ = Notif::find($item->id);
      $notif_->status = "read";
      $notif_->save();
    }

    return response()->json([
      'status' => 200
    ]);
  }
}
