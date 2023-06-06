@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 lg:mt-5 lg:flex lg:justify-center">
    <div class="lg:w-2/4 border p-3 rounded bg-white">
      <div class="border-b mx-3">
        <div>
          <div class="py-3">Silahkan transfer ke nomor rekening dibawah sejumlah <span class="font-bold text-sm">Rp</span> <span id="nominal_bayar" class="font-bold text-xl">@currency('15000')</span> untuk pendaftaran, setelah itu kirim bukti transfer serta nomor telepon yang terdaftar ke admin kami melalui chat (<i class="fa fa-comment-dots"></i>). terima kasih. <span class="text-sm font-bold">(proses aktivasi 1x24 jam setelah pembayaran)</span></div>
        </div>
      </div>
      <div>
        <div class="mx-3 border-b">
          <div class="py-3">
            <img src="{{ url(env('APP_URL_ADMIN') . '/img_rekening/' . $rekening->gambar) }}" alt="logo" class="w-20">
          </div>
          <div class="py-3">
            <div class="text-sm">No Rekening</div>
            <div>
              <span id="p1" class="text-rose-600 font-semibold mr-3">{{ $rekening->nomor }}</span>
              <span class="">
                <button id="salin" onclick="copy('#p1');" class="border rounded-full px-3 text-sky-500">salin</button>
                <span id="salin_teks" class="text-emerald-500 italic text-sm hidden">berhasil menyalin !</span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="font-bold text-center text-lg my-3">Contoh Chat</div>
        <div class="flex justify-center">
          <img src="{{ asset('assets/bukti-transfer.jpeg') }}" alt="img_contoh_chat" class="w-2/4">
        </div>
      </div>
      <div>
        <div class="mx-3 flex justify-center">
          <a href="{{ route('akun') }}" class="bg-sky-600 text-white text-center font-bold w-3/4 mt-4 py-2 rounded border">OK</a>
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.navBawah')
@include('layouts.footer')

@endsection