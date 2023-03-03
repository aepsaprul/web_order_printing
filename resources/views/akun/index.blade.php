@extends('layouts.app')

@section('content')

@include('layouts.headerLg')

<div class="lg:hidden">
  <div class="m-5 flex justify-between items-center bg-white shadow-md rounded-md">
    <div class="w-1/4 py-2 pl-2">
      <img src="{{ asset('assets/1665988705.jpg') }}" alt="avatar" class="w-16 rounded-full">
    </div>
    <div class="w-3/4 py-2">
      <p class="text-xl">{{ Auth::user()->nama_lengkap }}</p>
      <p class="text-md mt-2">{{ Auth::user()->telepon }}</p>
      <p class="text-md">{{ Auth::user()->email }}</p>
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
</div>

<div class="hidden lg:flex lg:justify-center">
  <div class="lg:w-4/5 2xl:w-3/5 flex mt-5">
    <div class="w-1/5 border rounded-md">
      <div class="flex items-center p-3 border-b">
        <div class="mr-3">
          @if (Auth::user()->gambar)
            <img src="{{ asset('assets/pembayaran-mandiri.png') }}" alt="avatar" class="w-10 h-10 rounded-full object-contain border">            
          @else
            <div class="w-10 h-10 rounded-full border flex justify-center items-center">
              <i class="fa fa-user"></i>
            </div>
          @endif
        </div>
        <div class="capitalize">{{ Auth::user()->nama_lengkap }}</div>
      </div>
      <div class="p-2">
        <div class="px-3 py-2 text-sm font-light cursor-pointer bg-sky-200 rounded"><a href="{{ route('akun') }}">Data Diri</a></div>
        <div class="px-3 py-2 text-sm font-light cursor-pointer"><a href="{{ route('akun.transaksi') }}">Transaksi</a></div>
        <div class="px-3 py-2 text-sm font-light cursor-pointer"><a href="{{ route('akun.ulasan') }}">Ulasan</a></div>
        <div class="px-3 py-2 text-sm font-semibold cursor-pointer underline"><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></div>
      </div>
    </div>
    <div class="w-4/5 px-5">
      @yield('content_akun')
    </div>
  </div>
</div>

@include('layouts.navBawah')
@include('layouts.footer')

@endsection