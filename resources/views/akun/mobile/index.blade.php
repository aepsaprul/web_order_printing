@extends('layouts.app')

@section('title') {{ 'Data Diri' }} @endsection

@section('content')

@include('layouts.header')

<div class="md:hidden pb-10">
  <div class="m-3 relative">
    <div class="absolute text-sky-500 pl-3 pr-2 pt-2 pb-3 right-0">
      <a href="{{ route('mUbahGambar') }}">edit</a>
    </div>
    <div class="py-2 w-full border bg-white rounded-lg flex justify-center items-center">
      <div class="w-32 h-32 border rounded-full flex justify-center items-center bg-slate-100 p-2">
        @if (Auth::user()->gambar)
          <img src="{{ asset('img_customer/' . Auth::user()->gambar) }}" alt="img" class="object-cover rounded-full border">
        @else
          <img src="{{ asset('assets/1665988705.jpg') }}" id="preview_image" alt="img" class="object-cover rounded-full border">
        @endif
      </div>
    </div>
    <div class="my-2 bg-white border rounded-lg p-3">
      <div>
        <a href="{{ route('mUbahBio') }}" class="flex justify-between border-b-2 mb-3">
          <div class="font-bold text-base text-slate-800">Data Diri</div>
          <div class="text-sky-500">edit</div>
        </a>
      </div>
      <div class="flex justify-between">
        <div>Nama</div>
        <div class="font-bold capitalize">{{ $customer->nama_lengkap }}</div>
      </div>
      <div class="flex justify-between">
        <div>Tanggal Lahir</div>
        <div>
          @php
            $tanggal_lahir = Carbon\Carbon::parse($customer->tanggal_lahir)->locale('id');
            $tanggal_lahir->settings(['formatFunction' => 'translatedFormat']);
          @endphp
          {{ $customer->tanggal_lahir ? $tanggal_lahir->format('d F Y') : '-' }}
        </div>
      </div>
      <div class="flex justify-between">
        <div>Jenis Kelamin</div>
        <div class="capitalize">{{ $customer->jenis_kelamin ? $customer->jenis_kelamin : '-' }}</div>
      </div>
      <div class="flex justify-between">
        <div>Telepon</div>
        <div>{{ $customer->telepon }}</div>
      </div>
      <div class="flex justify-between">
        <div>Email</div>
        <div>{{ $customer->email }}</div>
      </div>
    </div>
    <div class="p-1 my-3 flex justify-between">
      <div>
        <a href="{{ route('mUlasan') }}" class="text-sm text-white rounded px-5 py-2 bg-sky-500 ring-offset-2 ring-2 ring-sky-500">Ulasan</a>
      </div>
      <div>
        <a href="{{ route('mUbahPassword') }}" class="text-sm text-white rounded px-5 py-2 bg-sky-500 ring-offset-2 ring-2 ring-sky-500">Ubah Password</a>
      </div>
      <div>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-white rounded px-5 py-2 bg-rose-500 ring-offset-2 ring-2 ring-rose-500">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
        </form>
      </div>
    </div>
    <hr class="border-2">
    <div class="p-1 my-3">
      @if (Auth::user()->segmen == "member")
        <div>{{ Auth::user()->segmen }}</div>
      @elseif (Auth::user()->segmen == "proses_baru" || Auth::user()->segmen == "proses_perpanjang")
        <div class="text-rose-500 italic text-center"><a href="{{ route('akun.memberBayar') }}" class="bg-sky-500 ml-2 rounded-full py-1 px-3 text-white ring-offset-1 ring-1 ring-sky-500">Klik Disini</a> untuk detail daftar member</div>
      @elseif (Auth::user()->segmen == "proses_lama")
        <div class="text-rose-500 italic text-center">Proses member sedang dicek</div>
      @else
        <a href="{{ route('akun.memberForm') }}">
          <button class="w-full text-base text-white font-bold rounded py-2 bg-emerald-500 ring-offset-2 ring-2 ring-emerald-500">Daftar Member</button>
        </a>
      @endif
    </div>
    <div class="bg-white border rounded-lg p-2">
      <div>
        <a href="{{ route('mUbahAlamat') }}" class="flex justify-between border-b-2 mb-3">
          <div class="font-bold text-base text-slate-800">Alamat</div>
          <div class="text-sky-500">edit</div>
        </a>
      </div>
      <div class="my-2">
        <div class="uppercase text-sm">{{ Auth::user()->alamat ? Auth::user()->alamat : '-' }}, Kecamatan {{ Auth::user()->kecamatan ? Auth::user()->dataKecamatan->kecamatan : '-' }}, Kabupaten/Kota {{ Auth::user()->kabupaten ? Auth::user()->dataKabupaten->kabupaten : '-' }}, Provinsi {{ Auth::user()->provinsi ? Auth::user()->dataProvinsi->provinsi : '-' }}, Kodepos {{ Auth::user()->kodepos ? Auth::user()->kodepos : '-' }}</div>
      </div>
    </div>
  </div>
</div>

@include('layouts.navBawah')

<script>
  /* Storing user's device details in a variable*/
  let details = navigator.userAgent;
  
  /* Creating a regular expression
  containing some mobile devices keywords
  to search it in details string*/
  let regexp = /android|iphone|kindle|ipad/i;
  
  /* Using test() method to search regexp in details
  it returns boolean value*/
  let isMobileDevice = regexp.test(details);
  
  if (!isMobileDevice) {
    window.location.href = "{{ route('akun') }}";
  }
</script>
@endsection