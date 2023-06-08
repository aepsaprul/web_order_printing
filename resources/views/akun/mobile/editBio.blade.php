@extends('layouts.app')

@section('title') {{ 'Ubah Data Diri' }} @endsection

@section('content')

@include('layouts.header')

<div class="p-3 rounded">
  <div class="font-bold text-lg text-center">Ubah Data Diri</div>
</div>
<div class="mx-3 p-5 border rounded-lg bg-white">
  <form action="{{ route('mUbahBioUpdate') }}" method="post">
    @csrf
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="nama" class="mb-2 text-slate-500 font-bold">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="border py-1 px-2 outline-none rounded-md" value="{{ $customer->nama_lengkap }}">        
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="tanggal_lahir" class="mb-2 text-slate-500 font-bold">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="border py-1 px-2 outline-none rounded-md" value="{{ $customer->tanggal_lahir }}">
      </div>
    </div>
    <div class="mb-3">
      <div class="mb-2 text-slate-500 font-bold">Jenis Kelamin</div>
      <div class="flex flex-row">
        <div class="mr-10">
          <label for="pria">
            <input type="radio" name="jenis_kelamin" id="pria" value="pria" {{ $customer->jenis_kelamin == "pria" ? "checked" : "" }}> Pria
          </label>
        </div>
        <div>
          <label for="wanita">
            <input type="radio" name="jenis_kelamin" id="wanita" value="wanita" {{ $customer->jenis_kelamin == "wanita" ? "checked" : "" }}> Wanita
          </label>
        </div>
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="telepon" class="mb-2 text-slate-500 font-bold">Telepon</label>
        <input type="text" name="telepon" id="telepon" class="border py-1 px-2 outline-none rounded-md" value="{{ $customer->telepon }}">
      </div>
    </div>
    <div class="mb-3">
      <div class="flex flex-col">
        <label for="email" class="mb-2 text-slate-500 font-bold">Email</label>
        <input type="text" name="email" id="email" class="border py-1 px-2 outline-none rounded-md" value="{{ $customer->email }}" disabled>
      </div>
    </div>
    <div class="mb-3">
      <button type="submit" class="rounded w-full my-3 py-2 text-white font-bold bg-sky-500 ring-1 ring-sky-500 ring-offset-2">Perbaharui</button>
    </div>
  </form>
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