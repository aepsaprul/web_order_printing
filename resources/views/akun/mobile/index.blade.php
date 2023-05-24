@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="md:hidden pb-10">
  <div class="m-3">
    <div class="flex justify-between">
      <div class="py-2 w-full border bg-white rounded-lg flex justify-center items-center">
        <div class="w-32 h-32 border rounded-full flex justify-center items-center bg-slate-100 p-2">
          @if (Auth::user()->gambar)
            <img src="{{ asset('img_customer/' . Auth::user()->gambar) }}" alt="img" class="object-cover rounded-full border">
          @else
            <img src="{{ asset('assets/1665988705.jpg') }}" id="preview_image" alt="img" class="object-cover rounded-full border">
          @endif
        </div>
      </div>
      {{-- <div class="py-2 w-2/4 ml-3 p-2 bg-white rounded-lg border">
        <div><span class="capitalize font-bold">{{ $customer->nama_lengkap }}</span> <span class="text-sky-600 text-sm underline">ubah</span></div>
        <div class="text-sm my-1">{{ $customer->telepon }} <span class="text-sky-600 underline">ubah</span></div>
        <div class="text-sm my-1">{{ $customer->email }} <span class="text-sky-600 underline">ubah</span></div>
        <div class="mt-4">
          @if ($customer->segmen == "member")
          <div class="capitalize font-bold text-emerald-500">{{ Auth::user()->segmen }}</div>
          @else
          👉 <button class="bg-emerald-600 text-white text-sm font-semibold rounded py-1 px-3">Daftar Member</button>
          @endif
        </div>
      </div> --}}
    </div>
    <div class="my-2 bg-white border rounded-lg p-2">
      <div class="flex justify-between">
        <div>Nama</div>
        <div class="font-bold">{{ $customer->nama_lengkap }}</div>
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
        <div>{{ $customer->jenis_kelamin }}</div>
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
    <div class="p-1 my-5 flex justify-between">
      <div>
        <a href="{{ route('mUlasan') }}" class="text-sm text-white rounded px-5 py-2 bg-sky-500">Ulasan</a>
      </div>
      <div>
        <a href="{{ route('mUbahPassword') }}" class="text-sm text-white rounded px-5 py-2 bg-sky-500">Ubah Password</a>
      </div>
      <div>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-white rounded px-5 py-2 bg-rose-500">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
        </form>
      </div>
    </div>
    <div class="bg-white border rounded-lg p-2">
      <div class="border-b">
        <div class="font-semibold">Alamat</div>
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