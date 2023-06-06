@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="md:flex md:justify-center">
  <div class="md:w-2/4">
    <div id="wrapDaftarMember"> 
      <div>
        <h1 class="text-center font-bold my-5 text-xl text-slate-500">Daftar Member</h1>
      </div>
      <div class="bg-white m-3 p-3 rounded-lg border">
        <div>
          <button id="btnMemberBaru" class="bg-sky-500 w-full py-2 rounded text-white font-bold mb-5">Member Baru</button>
        </div>
        <div>
          <button id="btnMemberLama" class="bg-sky-500 w-full py-2 rounded text-white font-bold">Member Lama</button>
        </div>
      </div>
    </div>

    <form action="{{ route('akun.memberStore') }}" method="post" id="wrapDaftarMemberBaru" class="hidden">
      @csrf
      <input type="hidden" name="member_title" value="baru">
      <div class="my-3 ml-2 p-3 flex">
        <div class="flex justify-start items-center">
          <button id="btnKembaliMemberBaru" class="w-10 h-10 text-white font-bold bg-rose-500 rounded-full"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="w-full">
          <h1 class="text-center font-bold my-5 text-xl text-slate-500">Daftar Member Baru</h1>
        </div>
      </div>
      <div class="bg-white m-3 p-3 rounded-lg border">
        <div class="flex flex-col mb-3">
          <label for="nama" class="font-bold">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" class="border p-1 outline-none rounded" value="{{ $customer->nama_lengkap }}" required>
        </div>
        <div class="flex flex-col mb-3">
          <label for="nik" class="font-bold">Nomor KTP</label>
          <input type="text" name="nik" id="nik" class="border p-1 outline-none rounded" value="{{ $customer->nik }}" required>
        </div>
        <div class="flex flex-col mb-3">
          <label for="email" class="font-bold">Email</label>
          <input type="text" name="email" id="email" class="border p-1 outline-none rounded" value="{{ $customer->email }}" required>
        </div>
        <div class="flex flex-col mb-3">
          <label for="telepon" class="font-bold">Nomor HP</label>
          <input type="text" name="telepon" id="telepon" class="border p-1 outline-none rounded" value="{{ $customer->telepon }}" required>
        </div>
        <div class="text-right">
          <button type="submit" class="bg-sky-500 py-1 px-5 rounded text-white font-bold">Daftar</button>
        </div>
      </div>
    </form>

    <form action="{{ route('akun.memberStore') }}" method="post" id="wrapDaftarMemberLama" class="hidden">
      @csrf
      <input type="hidden" name="member_title" value="lama">
      <div class="my-3 ml-2 p-3 flex">
        <div class="flex justify-start items-center">
          <button id="btnKembaliMemberLama" class="w-10 h-10 text-white font-bold bg-rose-500 rounded-full"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="w-full">
          <h1 class="text-center font-bold my-5 text-xl text-slate-500">Daftar Member Lama</h1>
        </div>
      </div>
      <div class="bg-white m-3 p-3 rounded-lg border">
        <div class="flex flex-col mb-3">
          <label for="nama" class="font-bold">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" class="border p-1 outline-none rounded" value="{{ $customer->nama_lengkap }}" required>
        </div>
        <div class="flex flex-col mb-3">
          <label for="telepon" class="font-bold">Nomor HP</label>
          <input type="text" name="telepon" id="telepon" class="border p-1 outline-none rounded" value="{{ $customer->telepon }}" required>
        </div>
        <div class="text-right">
          <button type="submit" class="bg-sky-500 py-1 px-5 rounded text-white font-bold">Daftar</button>
        </div>
      </div>
    </form>
  </div>
</div>

@include('layouts.navBawah')
@include('layouts.footer')

@endsection

@section('script')
<script>
  const btnMemberBaru = document.getElementById('btnMemberBaru');
  const btnMemberLama = document.getElementById('btnMemberLama');
  const btnKembaliMemberBaru = document.getElementById('btnKembaliMemberBaru');
  const btnKembaliMemberLama = document.getElementById('btnKembaliMemberLama');

  const wrapDaftarMember = document.getElementById('wrapDaftarMember');
  const wrapDaftarMemberBaru = document.getElementById('wrapDaftarMemberBaru');
  const wrapDaftarMemberLama = document.getElementById('wrapDaftarMemberLama');

  btnMemberBaru.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.add('hidden');
    wrapDaftarMemberBaru.classList.remove('hidden');
  })

  btnKembaliMemberBaru.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.remove('hidden');
    wrapDaftarMemberBaru.classList.add('hidden');
  })

  btnMemberLama.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.add('hidden');
    wrapDaftarMemberLama.classList.remove('hidden');
  })

  btnKembaliMemberLama.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.remove('hidden');
    wrapDaftarMemberLama.classList.add('hidden');
  })
</script>
@endsection