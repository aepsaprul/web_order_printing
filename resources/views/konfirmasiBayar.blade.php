@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="lg:flex lg:justify-center mt-4">
  <div class="lg:w-4/5 2xl:w-3/5">
    <div class="md:flex md:justify-center">
      <div class="m-3 md:w-2/4 bg-white p-3 rounded border">
        <div class="text-center text-lg font-bold">Konfirmasi Pembayaran</div>
        <form id="form_bayar" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="akun_id" id="akun_id" value="{{ Auth::user()->id }}">
          <div class="my-4">
            <label for="transaksi_id" class="font-semibold text-sm">Kode Pembelian</label>
            <select name="transaksi_id" id="transaksi_id" class="border w-full p-2 rounded" required>
              <option value="">Pilih Kode Pembelian</option>
              @foreach ($transaksi as $item)
                <option value="{{ $item->id }}">{{ $item->kode }}</option>
              @endforeach
            </select>
          </div>
          <div class="my-4">
            <label for="gambar" class="font-semibold text-sm">Struk Pembayaran</label>
            <input type="file" name="gambar" id="gambar" class="border w-full p-1 rounded" required>
          </div>
          <div class="mt-8 text-center">
            {{-- <button type="submit" class="bg-sky-500 w-44 rounded py-1 text-white font-bold"><i class="fa fa-paper-plane"></i> Kirim</button> --}}
            <div class="w-full relative flex items-center justify-center">
              <div id="loading" class="hidden absolute">
                <div class="flex items-center">
                  <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
                    <div class="h-2 w-2 rounded-full bg-white"></div>
                  </div>
                  <span class="text-white">Loading. . .</span>
                </div>
              </div>
              <button type="submit" class="btn-kirim bg-sky-500 w-44 rounded py-1 text-white font-bold"><i class="fa fa-paper-plane"></i> Kirim</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="w-full h-12"></div>
  </div>
</div>

@include('layouts.navBawah')
@include('layouts.footer')

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    $('#form_bayar').on('submit', function (e) {
      e.preventDefault();
      let formData = new FormData($('#form_bayar')[0]);

      $.ajax({
        url: "{{ URL::route('konfirmasi_bayar.store') }}",
        type: "post",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $('#loading').removeClass('hidden');
          $('.btn-kirim').removeClass('text-white');
          $('.btn-kirim').addClass('text-sky-500');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.href = "{{ URL::route('akun.transaksi') }}";
          }, 1000);
        }
      })
    })
  })
</script>
@endsection
