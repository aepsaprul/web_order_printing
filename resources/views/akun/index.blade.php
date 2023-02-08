@extends('layouts.app')

@section('content')
<div class="m-5 flex justify-between items-center bg-white shadow-md rounded-md">
  <div class="w-1/4 py-2 pl-2">
    <img src="{{ asset('assets/1665988705.jpg') }}" alt="avatar" class="w-16 rounded-full">
  </div>
  <div class="w-3/4 py-2">
    <p class="text-xl">Aep Saprul Mujahid</p>
    <p class="text-md mt-2">081234567890</p>
    <p class="text-md">alamatemail@gmail.com</p>
  </div>
</div>
<div class="m-5 bg-white shadow-md rounded-md">
  <div class="p-2 border-b">
    <a href="#" class="flex justify-between">
      <div>
        <i class="fa fa-user text-slate-600 w-6 text-center"></i> Pengaturan Akun
      </div>
      <div>
        <i class="fa-solid fa-chevron-right text-slate-600"></i>
      </div>
    </a>
  </div>
  <div class="p-2">
    <a href="#" class="flex justify-between">
      <div>
        <i class="fa fa-solid fa-circle-question text-slate-600 w-6 text-center"></i> Pusat Bantuan
      </div>
      <div>
        <i class="fa-solid fa-chevron-right text-slate-600"></i>
      </div>
    </a>
  </div>
  <div class="p-2">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex justify-between">
      <div>
        <i class="fa fa-solid fa-sign-out text-slate-600 w-6 text-center"></i> Logout
      </div>
      <div>
        <i class="fa-solid fa-chevron-right text-slate-600"></i>
      </div>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
    </form>
  </div>
</div>
<div class="m-5">
  <h3 class="font-bold underline mb-2 flex justify-between">
    <div>Alamat</div>
    <div><i class="fa-solid fa-square-plus text-3xl text-slate-600"></i></div>
  </h3>
  <div class="shadow-md rounded-md">
    <p class="p-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. A, nisi.</p>
  </div>
</div>

@include('layouts.navBawah')
@endsection