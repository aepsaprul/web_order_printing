@extends('layouts.app')

@section('title') {{ 'Member Form' }} @endsection

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
          <button id="btnMemberPerpanjang" class="bg-sky-500 w-full py-2 rounded text-white font-bold mb-5">Perpanjang Member</button>
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
          <button type="button" id="btnKembaliMemberBaru" class="w-10 h-10 text-white font-bold bg-rose-500 rounded-full"><i class="fa fa-arrow-left"></i></button>
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

    <form action="{{ route('akun.memberStore') }}" method="post" enctype="multipart/form-data" id="wrapDaftarMemberPerpanjang" class="hidden">
      @csrf
      <input type="hidden" name="member_title" value="perpanjang">
      <div class="my-3 ml-2 p-3 flex">
        <div class="flex justify-start items-center">
          <button type="button" id="btnKembaliMemberPerpanjang" class="w-10 h-10 text-white font-bold bg-rose-500 rounded-full"><i class="fa fa-arrow-left"></i></button>
        </div>
        <div class="w-full">
          <h1 class="text-center font-bold my-5 text-xl text-slate-500">Perpanjang Member</h1>
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
        <div class="mb-3">
          <label class="font-bold">Pilih Identitas</label>
          <div>
            <label for="identitas_member_perpanjang">
              <input type="radio" name="identitas_perpanjang" id="identitas_member_perpanjang" value="identitas_member_perpanjang"> ID Member
            </label>
            <label for="identitas_ktp_perpanjang">
              <input type="radio" name="identitas_perpanjang" id="identitas_ktp_perpanjang" value="identitas_ktp_perpanjang"> KTP
            </label>
          </div>
        </div>
        <div id="wrapIdMemberPerpanjang" class="hidden h-20">
          <div class="flex flex-col mb-3">
            <label for="nomor_id_member_perpanjang">Nomor ID Member</label>
            <input type="text" name="nomor_id_member_perpanjang" id="nomor_id_member_perpanjang" class="border p-1 outline-none rounded" placeholder="Isi nomor ID Member" required>
          </div>
        </div>
        <div id="wrapKtpPerpanjang" class="hidden h-20">
          <div class="flex flex-col mb-3">
            <label for="upload_ktp_perpanjang">Upload KTP</label>
            <input type="file" name="upload_ktp_perpanjang" id="upload_ktp_perpanjang" required>
          </div>
        </div>
        <div class="text-right">
          <button type="submit" class="bg-sky-500 py-1 px-5 rounded text-white font-bold">Daftar</button>
        </div>
      </div>
    </form>

    <form action="{{ route('akun.memberStore') }}" method="post" enctype="multipart/form-data" id="wrapDaftarMemberLama" class="hidden">
      @csrf
      <input type="hidden" name="member_title" value="lama">
      <div class="my-3 ml-2 p-3 flex">
        <div class="flex justify-start items-center">
          <button type="button" id="btnKembaliMemberLama" class="w-10 h-10 text-white font-bold bg-rose-500 rounded-full"><i class="fa fa-arrow-left"></i></button>
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
        <div class="mb-3">
          <label class="font-bold">Pilih Identitas</label>
          <div>
            <label for="identitas_member_lama">
              <input type="radio" name="identitas_lama" id="identitas_member_lama" value="identitas_member_lama"> ID Member
            </label>
            <label for="identitas_ktp_lama">
              <input type="radio" name="identitas_lama" id="identitas_ktp_lama" value="identitas_ktp_lama"> KTP
            </label>
          </div>
        </div>
        <div id="wrapIdMemberLama" class="hidden h-20">
          <div class="flex flex-col mb-3">
            <label for="nomor_id_member_lama">Nomor ID Member</label>
            <input type="text" name="nomor_id_member_lama" id="nomor_id_member_lama" class="border p-1 outline-none rounded" placeholder="Isi nomor ID Member" required>
          </div>
        </div>
        <div id="wrapKtpLama" class="hidden h-20">
          <div class="flex flex-col mb-3">
            <label for="upload_ktp_lama">Upload KTP</label>
            <input type="file" name="upload_ktp_lama" id="upload_ktp_lama" required>
          </div>
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
  const btnMemberPerpanjang = document.getElementById('btnMemberPerpanjang');
  const btnMemberLama = document.getElementById('btnMemberLama');
  const btnKembaliMemberBaru = document.getElementById('btnKembaliMemberBaru');
  const btnKembaliMemberPerpanjang = document.getElementById('btnKembaliMemberPerpanjang');
  const btnKembaliMemberLama = document.getElementById('btnKembaliMemberLama');

  const wrapDaftarMember = document.getElementById('wrapDaftarMember');
  const wrapDaftarMemberBaru = document.getElementById('wrapDaftarMemberBaru');
  const wrapDaftarMemberPerpanjang = document.getElementById('wrapDaftarMemberPerpanjang');
  const wrapDaftarMemberLama = document.getElementById('wrapDaftarMemberLama');

  const radioIdentitasMemberPerpanjang = document.getElementById('identitas_member_perpanjang');
  const radioIdentitasKtpPerpanjang = document.getElementById('identitas_ktp_perpanjang');
  const radioIdentitasMemberLama = document.getElementById('identitas_member_lama');
  const radioIdentitasKtpLama = document.getElementById('identitas_ktp_lama');

  btnMemberBaru.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.add('hidden');
    wrapDaftarMemberBaru.classList.remove('hidden');
  })

  btnKembaliMemberBaru.addEventListener('click', function(e) {
    e.preventDefault();
    window.location.reload();
  })

  btnMemberPerpanjang.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.add('hidden');
    wrapDaftarMemberPerpanjang.classList.remove('hidden');
  })

  btnKembaliMemberPerpanjang.addEventListener('click', function(e) {
    e.preventDefault();
    window.location.reload();
  })

  btnMemberLama.addEventListener('click', function(e) {
    e.preventDefault();

    wrapDaftarMember.classList.add('hidden');
    wrapDaftarMemberLama.classList.remove('hidden');
  })

  btnKembaliMemberLama.addEventListener('click', function(e) {
    e.preventDefault();
    window.location.reload();
  })

  const wrapIdMemberPerpanjang = document.getElementById('wrapIdMemberPerpanjang');
  const wrapKtpPerpanjang = document.getElementById('wrapKtpPerpanjang');
  const inputNomorIdMemberPerpanjang = document.getElementById('nomor_id_member_perpanjang');
  const inputUploadKtpPerpanjang = document.getElementById('upload_ktp_perpanjang');

  radioIdentitasMemberPerpanjang.addEventListener('click', function(e) {
    wrapIdMemberPerpanjang.classList.remove('hidden');
    inputNomorIdMemberPerpanjang.setAttribute('required', true);

    wrapKtpPerpanjang.classList.add('hidden');
    inputUploadKtpPerpanjang.removeAttribute('required');
  })
  radioIdentitasKtpPerpanjang.addEventListener('click', function(e) {
    wrapKtpPerpanjang.classList.remove('hidden');
    inputUploadKtpPerpanjang.setAttribute('required', true);

    wrapIdMemberPerpanjang.classList.add('hidden');
    inputNomorIdMemberPerpanjang.removeAttribute('required');
  })

  const wrapIdMemberLama = document.getElementById('wrapIdMemberLama');
  const wrapKtpLama = document.getElementById('wrapKtpLama');
  const inputNomorIdMemberLama = document.getElementById('nomor_id_member_lama');
  const inputUploadKtpLama = document.getElementById('upload_ktp_lama');

  radioIdentitasMemberLama.addEventListener('click', function(e) {
    wrapIdMemberLama.classList.remove('hidden');
    inputNomorIdMemberLama.setAttribute('required', true);

    wrapKtpLama.classList.add('hidden');
    inputUploadKtpLama.removeAttribute('required');
  })
  radioIdentitasKtpLama.addEventListener('click', function(e) {
    wrapKtpLama.classList.remove('hidden');
    inputUploadKtpLama.setAttribute('required', true);

    wrapIdMemberLama.classList.add('hidden');
    inputNomorIdMemberLama.removeAttribute('required');
  })
</script>
@endsection