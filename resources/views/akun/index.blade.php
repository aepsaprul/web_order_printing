@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="flex justify-center">
  <div class="w-4/5 2xl:w-3/5 flex mt-5">
    <div class="w-1/5">
      <div class="bg-white rounded border">
        <div class="flex items-center p-3 border-b">
          <div class="mr-3">
            @if (Auth::user()->gambar)
              <img src="{{ asset('img_customer/' . Auth::user()->gambar) }}" alt="avatar" class="w-10 h-10 rounded-full object-cover border">            
            @else
              <div class="w-10 h-10 rounded-full border flex justify-center items-center">
                <i class="fa fa-user"></i>
              </div>
            @endif
          </div>
          <div class="capitalize">{{ Auth::user()->nama_lengkap }}</div>
        </div>
        <div class="p-2">
          <div class="px-3 py-2 text-sm font-light cursor-pointer {{ request()->is(['akun']) ? 'bg-sky-200' : '' }} rounded"><a href="{{ route('akun') }}">Data Diri</a></div>
          <div class="px-3 py-2 text-sm font-light cursor-pointer {{ request()->is(['akun/transaksi']) ? 'bg-sky-200' : '' }}"><a href="{{ route('akun.transaksi') }}">Transaksi</a></div>
          <div class="px-3 py-2 text-sm font-light cursor-pointer {{ request()->is(['akun/ulasan']) ? 'bg-sky-200' : '' }}"><a href="{{ route('akun.ulasan') }}">Ulasan</a></div>
          <div class="px-3 py-2 text-sm font-semibold cursor-pointer underline">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
            </form>
          </div>
        </div>
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