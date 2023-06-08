@extends('layouts.app')

@section('title') {{ 'Daftar' }} @endsection

@section('content')
<div class="lg:flex lg:justify-center lg:items-center lg:min-h-screen">
  <div class="bg-white lg:w-1/4 lg:border lg:border-slate-200 lg:rounded">
    <div class="w-full h-12 bg-white border-b flex justify-between items-center">
      <div class="mx-3"><a href="{{ url('/') }}"><i class="fas fa-arrow-left text-lg text-sky-600 mr-3"></i></a> <span class="font-bold">Daftar</span></div>
      <div class="mx-3"><a href="{{ route('login') }}" class="text-sky-600 font-bold">Masuk</a></div>
    </div>
    <div class="mt-5 pb-32 lg:pb-0">
      <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <div class="m-2">
          <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full h-8 pl-3 border rounded text-sm outline-none @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap" autofocus required>
          <em class="text-xs text-slate-400 pl-1">min 3, max 30 karakter </em>
          <em class="text-red-400 text-xs">@error('nama_lengkap') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <input type="text" name="nik" id="nik" class="w-full h-8 pl-3 border rounded text-sm outline-none @error('nik') is-invalid @enderror" placeholder="NIK (Nomor Induk KTP)" autofocus required>
          <em class="text-xs text-slate-400 pl-1">min 3, max 16 karakter </em>
          <em class="text-red-400 text-xs">@error('nik') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <input type="text" name="telepon" id="telepon" class="w-full h-8 pl-3 border rounded text-sm outline-none @error('telepon') is-invalid @enderror" placeholder="Telepon" autofocus required>
          <em class="text-xs text-slate-400 pl-1">min 3, max 15 karakter </em>
          <em class="text-red-400 text-xs">@error('telepon') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <input type="email" name="email" id="email" class="w-full h-8 pl-3 border rounded text-sm outline-0 @error('email') is-invalid @enderror" placeholder="Email" required>
          <em class="text-xs text-slate-400 pl-1">berupa alamat email</em>
          <em class="text-red-400 text-xs">@error('email') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <input type="password" name="password" id="password" class="w-full h-8 pl-3 border rounded text-sm outline-0 @error('password') is-invalid @enderror" placeholder="Password" required>
          <em class="text-xs text-slate-400 pl-1">min 8 karakter, mengandung minimal 1 simbol</em>
          <em class="text-red-400 text-xs">@error('password') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <input type="password" name="password_confirmation" id="password_confirmation" class="w-full h-8 pl-3 border rounded text-sm outline-0" placeholder="Konfirmasi Password" placeholder="Konfirmasi Password">
          <em class="text-xs text-slate-400 pl-1">harus sama dengan password</em>
          <em class="text-red-400 text-xs">@error('password') {{ $message }} @enderror</em>
        </div>
        <div class="m-2">
          <button type="submit" class="w-full p-2 rounded-md bg-sky-600 text-white font-bold uppercase">daftar</button>
        </div>
      </form>
    </div>
    <div class="fixed lg:static bottom-0 right-0 left-0">
      <div class="text-center text-xs text-slate-600 p-3 bg-white">Dengan mendaftar, Anda setuju dengan Syarat & Ketentuan & Kebijakan Abata</div>
      <div class="h-12 bg-sky-100 text-center flex items-center justify-center">
        <p class="lg:text-xs">Sudah punya akun? <a href="{{ route('login') }}" class="text-sky-800 font-semibold">Masuk</a></p>
      </div>
    </div>
  </div>
</div>
@endsection