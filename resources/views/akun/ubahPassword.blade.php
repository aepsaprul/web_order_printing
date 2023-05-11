@extends('akun.index')

@section('content_akun')

<div class="bg-white p-3 rounded border">
  <div class="font-bold text-lg">Ubah Kata Sandi</div>
</div>
<div class="p-3 mt-1 border rounded bg-white flex justify-center">
  <form action="{{ route('akun.ubahPasswordStore') }}" method="POST">
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
      <input type="password" name="old_password" id="old_password" class="border rounded px-2 py-1 outline-none" required>
    </div>
    <div class="mt-3">
      <div>Password Baru</div>
      <input type="password" name="new_password" id="new_password" class="border rounded px-2 py-1 outline-none" required>
    </div>
    <div class="mt-3">
      <div>Konfirmasi Password Baru</div>
      <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="border rounded px-2 py-1 outline-none" required>
    </div>
    <div class="mt-3">
      <button type="submit" class="bg-sky-500 p-2 rounded w-full text-white font-bold">Perbaharui Password</button>
    </div>
  </form>
</div>

@endsection