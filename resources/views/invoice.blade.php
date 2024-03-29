@extends('layouts.app')

@section('title') {{ 'Inovice' }} @endsection

@section('content')
<div id="header-wrapper" class="flex justify-center items-center border-b h-12 lg:h-14 sticky top-0 bg-white z-10">
  <div class="w-full lg:w-4/5 flex items-center lg:mt-2">
    <div class="mx-3">
      <a href="{{ route('home') }}"><i class="fa fa-arrow-left text-lg"></i></a>
    </div>
    <div>
      <span class="text-lg">Invoice</span>
    </div>
  </div>
</div>
<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 lg:mt-5 lg:flex lg:justify-center">
    <div class="lg:w-2/4 border p-3 rounded bg-white">
      <div class="border-b mx-3">
        <div class="flex justify-between">
          <div class="py-3">Total Pembayaran</div>
          <div class="py-3"><button onclick="copyTotal('nominal_bayar')" class="border rounded-full px-3 text-sky-500 mr-5">salin</button> <span class="font-bold text-sm">Rp</span> <span id="nominal_bayar" class="font-bold text-xl">@currency($transaksi->total)</span></div>
        </div>
        <div class="py-3 text-right text-xs italic"><span class="text-rose-800">*</span> pastikan 3 digit terakhir sama</div>
      </div>
      <div>
        <div class="flex justify-between mx-3 border-b">
          <div class="py-3">Maksimal Bayar</div>
          <div class="py-3">
            @php
              $date = Carbon\Carbon::parse($transaksi->created_at)->locale('id');
              $date->settings(['formatFunction' => 'translatedFormat']);
            @endphp
            {{ $date->addDay()->format('d F Y - H:') }}00:00
          </div>
        </div>
      </div>
      <div>
        <div class="mx-3 border-b">
          <div class="py-3">
            <img src="{{ url(env('APP_URL_ADMIN') . '/img_rekening/' . $transaksi->dataRekening->gambar) }}" alt="logo" class="w-20">
          </div>
          <div class="py-3">
            <div class="text-sm">No Rekening</div>
            <div>
              <span id="p1" class="text-rose-600 font-semibold mr-3">{{ $transaksi->dataRekening->nomor }}</span>
              <span class="">
                <button id="salin" onclick="copy('#p1');" class="border rounded-full px-3 text-sky-500">salin</button>
                <span id="salin_teks" class="text-emerald-500 italic text-sm hidden">berhasil menyalin !</span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="mx-3 flex justify-center">
          <button id="btn_ok" class="bg-sky-600 text-white font-bold w-2/4 mt-4 py-2 rounded border ring-offset-1 ring-1 ring-sky-500">OK</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // klik salin
  function copy(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
  function copyTotal(id)
  {
    var str = document.getElementById(id);
    window.getSelection().selectAllChildren(str);
    document.execCommand("Copy")
  }
</script>
@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    // kode unik
    const nominal_bayar = $('#nominal_bayar').text();
    const kode_unik = nominal_bayar.substr(nominal_bayar.length - 3);
    const nominal = nominal_bayar.slice(0, nominal_bayar.length - 3);
    
    let nominal_merge = `<span>${nominal}</span><span class="text-rose-600">${kode_unik}</span>`;
    $('#nominal_bayar').html(nominal_merge);

    // salin teks
    $('#salin').on('click', function (e) {
      e.preventDefault();
      $('#salin_teks').removeClass('hidden');
      setTimeout(() => {
        $('#salin_teks').addClass('hidden');
      }, 2000);
    })

    // btn ok
    $('#btn_ok').on('click', function (e) {
      window.location.href = "{{ URL::route('akun.transaksi') }}";
    })
  })
</script>
@endsection