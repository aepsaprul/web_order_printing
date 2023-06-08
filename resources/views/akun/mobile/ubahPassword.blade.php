@extends('layouts.app')

@section('title') {{ 'Ubah Password' }} @endsection

@section('content')

@include('layouts.header')

<div class="p-3 rounded">
  <div class="font-bold text-lg text-center">Ubah Kata Sandi</div>
</div>
<div class="m-3 p-3 border rounded-lg bg-white flex justify-center">
  <form action="{{ route('mUbahPasswordStore') }}" method="POST" class="w-full">
    @csrf

    @if (session('status'))
      <div class="text-emerald-500 italic">
        {{ session('status') }}
      </div>
    @elseif (session('error'))
      <div class="text-rose-500 italic">
        {{ session('error') }}
      </div>
    @endif

    <div>
      <div>Password Lama</div>
      <input type="password" name="old_password" id="old_password" class="border rounded px-2 py-1 outline-none w-full" required>
    </div>
    <div class="mt-3">
      <div>Password Baru</div>
      <input type="password" name="new_password" id="new_password" class="border rounded px-2 py-1 outline-none w-full" required>
    </div>
    <div class="mt-3">
      <div>Konfirmasi Password Baru</div>
      <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="border rounded px-2 py-1 outline-none w-full" required>
    </div>
    <div class="mt-3">
      <button type="submit" class="bg-sky-500 p-2 rounded w-full text-white font-bold">Perbaharui Password</button>
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
    window.location.href = "{{ route('akun.ubahPassword') }}";
  }
</script>

@endsection