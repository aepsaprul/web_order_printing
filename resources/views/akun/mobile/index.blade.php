@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="">
  <div class="mx-3">
    <div class="flex border-b">
      <div class="py-2 w-1/4">
        <img src="{{ asset('assets/1665988705.jpg') }}" alt="foto" class="w-full rounded-full">
        <div class="w-full text-center mt-2">
          <button class="py-1 px-3 text-sm rounded text-sky-600 underline">ubah foto</button>
        </div>
      </div>
      <div class="py-2 w-3/4 ml-3">
        <div><span class="capitalize">{{ $customer->nama_lengkap }}</span> <span class="text-sky-600 text-sm underline">ubah</span></div>
        <div class="text-sm my-1">{{ $customer->telepon }} <span class="text-sky-600 underline">ubah</span></div>
        <div class="text-sm my-1">{{ $customer->email }} <span class="text-sky-600 underline">ubah</span></div>
        <div class="mt-4">
          @if ($customer->segmen == "member")
          <div class="capitalize font-bold text-emerald-500">{{ Auth::user()->segmen }}</div>
          @else
          👉 <button class="bg-emerald-600 text-white text-sm font-semibold rounded py-1 px-3">Daftar Member</button>
          @endif
        </div>
      </div>
    </div>
    <div class="py-2">
      <div class="flex justify-between my-2">
        <div>Tanggal Lahir</div>
        <div>
          @php
            $tanggal_lahir = Carbon\Carbon::parse($customer->tanggal_lahir)->locale('id');
            $tanggal_lahir->settings(['formatFunction' => 'translatedFormat']);
          @endphp
          {{ $customer->tanggal_lahir ? $tanggal_lahir->format('d F Y') : '-' }}
        </div>
      </div>
      <div class="flex justify-between my-2">
        <div>Jenis Kelamin</div>
        <div>{{ $customer->jenis_kelamin }}</div>
      </div>
    </div>
    <div class="py-2">
      <div><button class="text-sm underline my-2">Ubah Password</button></div>
      <div><a href="#" class="underline text-sm my-2 font-semibold">Logout</a></div>
    </div>
    <div class="py-5">
      <div class="border-b">
        <div class="font-semibold">Alamat</div>
      </div>
      <div class="my-2">
        <div class="uppercase">{{ $customer->alamat }}, Kec {{ $customer->dataKecamatan->dis_name }}, Kab/Kota {{ $customer->dataKabupaten->city_name }}, {{ $customer->dataProvinsi->prov_name }}</div>
      </div>
    </div>
  </div>
</div>

@include('layouts.navBawah')

@endsection