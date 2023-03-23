<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
  public function index()
  {
    if (Auth::user()) {
      return redirect('/');
    } else {
      return view('auth.register');
    }
  }
  public function store(Request $request)
  {
    $validated = $request->validate([
      'nama_lengkap' => 'required|min:3|max:30',
      'nik' => 'required',
      'telepon' => 'required|numeric|digits_between:10,13|unique:customers',
      'email' => 'required|email|unique:customers',
      'password' => [
        'required',
        'confirmed',
        // Password::min(8)
        // ->symbols()
      ]
    ]);
    
    $customer = new Customer;
    $customer->nama_lengkap = $request->nama_lengkap;
    $customer->nik = $request->nik;
    $customer->telepon = $request->telepon;
    $customer->username = $request->username;
    $customer->email = $request->email;
    $customer->password = Hash::make($request->password);
    $customer->save();

    auth()->login($customer);

    return redirect()->intended('/');
  }
}
