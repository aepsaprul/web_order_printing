@extends('layouts.app')

@section('content')

@include('layouts.headerArrow')
@include('layouts.headerLg')

{{-- data --}}
<input type="hidden" name="produk_id" id="produk_id" value="{{ $produk->id }}">

<div class="lg:flex lg:justify-center">
  <div class="lg:w-4/5 lg:flex 2xl:w-3/5">
    <div class="lg:w-2/4">
      <img src="{{ $produk->gambar }}" alt="gambar produk" class="my-2">
    </div>
    <div class="mx-3 my-2 lg:w-2/4">
      <div class="my-3 lg:my-0 text-xl font-bold">{{ $produk->nama }}</div>
      <div>
        <p class="text-slate-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis sequi ea iusto ipsum? Sequi, voluptates corporis nihil aperiam laborum quibusdam!</p>
      </div>
      <div class="mt-4">
        <label for="keterangan" class="font-semibold">Keterangan</label>
        <textarea name="keterangan" id="keterangan" rows="4" class="w-full border border-sky-600 rounded p-3 mt-2 outline-0" placeholder="Maksimal 200 karakter"></textarea>
      </div>
      <div class="mt-2">
        <div class="flex justify-between lg:block">
          <button id="btn_upload" class="border border-sky-300 w-full lg:w-32 py-1 rounded bg-sky-500 text-white">Upload</button>
          <button id="btn_link" class="border border-sky-300 w-full lg:w-32 py-1 rounded">Link</button>
        </div>
        <div id="tab_upload" class="w-full h-36 mt-1 bg-slate-100">
          <div class="flex justify-center items-center">
            <div>
              <div class="text-center mt-2">
                <label for="upload">(PDF, JPG, ZIP, RAR max 50Mb)</label>
              </div>
              <div class="text-center border border-slate-400">
                <input type="file" name="upload" id="upload">
              </div>
            </div>
          </div>
          <div>
            <p class="text-sm px-2 mt-4 text-slate-600">*Jika ukuran file lebih dari 50Mb, silahkan upload file di dropbox / google drive dan masukkkan link file anda <a href="#" id="btn_disini" class="text-sky-600">disini</a>.</p>
          </div>
        </div>
        <div id="tab_link" class="w-full h-36 mt-1 bg-slate-100 hidden">
          <div class="h-full flex justify-center items-center">
            <div>
              <div>
                <input type="text" name="link" id="link" class="w-60 border p-2" placeholder="Masukkan Link">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-5">
        <div class="flex justify-between">
          <div>
            <button id="btn_minus" class="bg-rose-600 w-10 h-10 text-white rounded-l-full text-sm"><i class="fa fa-minus"></i></button>
          </div>
          <div class="w-full">
            <input type="text" name="input_counter" id="input_counter" value="1" minlength="1" maxlength="6" class="w-full h-full outline-0 text-center border">
          </div>
          <div>
            <button id="btn_plus" class="bg-emerald-600 w-10 h-10 text-white rounded-r-full text-sm"><i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <div class="flex justify-between py-1">
          <div>Harga Barang</div>
          <div>Rp <span class="nominal_harga">{{ $produk->harga }}</span></div>
        </div>
        <div class="flex justify-between py-1">
          <div>Jumlah</div>
          <div><span id="nominal_jumlah">1</span></div>
        </div>
        <div class="flex justify-between py-1">
          <div class="font-bold">Total</div>
          <div class="font-bold">Rp <span class="nominal_total">{{ $produk->harga }}</span></div>
        </div>
      </div>
      <div class="hidden w-full mt-2 lg:grid grid-cols-2 gap-4">
        <div class="relative flex items-center justify-center">
          <div id="loading_beli" class="hidden absolute">
            <div class="flex items-center">
              <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
                <div class="h-2 w-2 rounded-full bg-white"></div>
              </div>
              <span>Loading. . .</span>
            </div>
          </div>
          <button class="btn_beli w-full p-1 rounded font-bold border-2 border-sky-600">Beli</button>
        </div>
        <button id="btn_keranjang" class="w-full bg-sky-600 text-white p-1 rounded font-bold"><i class="fa fa-shopping-cart"></i> Keranjang</button>
      </div>
    </div>
  </div>
</div>
<div class="lg:flex lg:justify-center pb-20 lg:pb-5">
  <div class="lg:w-4/5 2xl:w-3/5 mx-3">
    <div class="mt-5">
      <div class="tab flex justify-between lg:block">
        <button id="btn-rincian" class="linktab w-full lg:w-44 rounded py-1" id="default">Rincian</button>
        <button id="btn-ulasan" class="linktab w-full lg:w-44 rounded py-1">Ulasan</button>
      </div>      
      <div id="rincian" class="mt-3">
        <p>{{ $produk->deskripsi }}</p>
      </div>      
      <div id="ulasan" class="hidden mt-3">
        
      </div>
    </div>
  </div>
</div>
<div class="w-full fixed bottom-0 bg-white border-t flex lg:hidden">
  <div class="w-full relative flex items-center justify-center">
    <div id="loading_beli_sm" class="hidden absolute">
      <div class="flex items-center">
        <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
          <div class="h-2 w-2 rounded-full bg-white"></div>
        </div>
        <span>Loading. . .</span>
      </div>
    </div>
    {{-- <button class="btn_beli w-full p-1 rounded font-bold border-2 border-sky-600">Beli</button> --}}
    <button class="btn_beli w-full m-3 p-1 rounded border-2 border-sky-600 font-bold">Beli</button>
  </div>
  <button id="btn_keranjang" class="w-full bg-sky-600 m-3 p-1 rounded text-white font-bold"><i class="fa fa-shopping-cart"></i> Keranjang</button>
</div>

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

    const nominal_harga = $('.nominal_harga').text();
    $('.nominal_harga').html(afRupiah(nominal_harga));
    const nominal_total = $('.nominal_total').text();
    $('.nominal_total').html(afRupiah(nominal_total));
    
    function afRupiah(nominal) {
      var	number_string = nominal.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
      return rupiah;
    }

    // tab upload
    const btn = [];
    $('#btn_upload').on('click', function (e) {
      e.preventDefault();
      btn.pop();
    
      if (btn[0] != 'btn_upload') {
        $('#btn_link').addClass('bg-white');
        $('#btn_link').removeClass('bg-sky-500 text-white');
        $('#btn_upload').removeClass('bg-white');
        $('#btn_upload').addClass('bg-sky-500 text-white');

        $('#tab_upload').removeClass('hidden');
        $('#tab_link').addClass('hidden');
      }
    })
    $('#btn_link').on('click', function (e) {
      e.preventDefault();
      btn.pop();
      btn.push('btn_link');
    
      if (btn[0] == 'btn_link') {
        $('#btn_link').removeClass('bg-white');
        $('#btn_link').addClass('bg-sky-500 text-white');
        $('#btn_upload').removeClass('bg-sky-500 text-white');
        $('#btn_upload').addClass('bg-white');

        $('#tab_upload').addClass('hidden');
        $('#tab_link').removeClass('hidden');
      }
    })
    $('#btn_disini').on('click', function (e) {
      e.preventDefault();
      btn.pop();
      btn.push('btn_link');
    
      if (btn[0] == 'btn_link') {
        $('#btn_link').removeClass('bg-white');
        $('#btn_link').addClass('bg-sky-500 text-white');
        $('#btn_upload').removeClass('bg-sky-500 text-white');
        $('#btn_upload').addClass('bg-white');

        $('#tab_upload').addClass('hidden');
        $('#tab_link').removeClass('hidden');
      }
    })
    $('#btn_upload').addClass('bg-sky-500 text-white');
    $('#btn_link').addClass('bg-white');

    // tab detail
    const tab = [];

    $('#btn-ulasan').on('click', function (e) {
      e.preventDefault();
      tab.pop();
      tab.push('ulasan');
    
      if (tab[0] == 'ulasan') {
        $('#btn-ulasan').removeClass('bg-slate-100');
        $('#btn-ulasan').addClass('bg-sky-500 text-white');
        $('#btn-rincian').removeClass('bg-sky-500 text-white');
        $('#btn-rincian').addClass('bg-slate-100');

        $('#rincian').addClass('hidden');
        $('#ulasan').removeClass('hidden');
      }
    })
    $('#btn-rincian').on('click', function (e) {
      e.preventDefault();
      tab.pop();
    
      if (tab[0] != 'ulasan') {
        $('#btn-ulasan').addClass('bg-slate-100');
        $('#btn-ulasan').removeClass('bg-sky-500 text-white');
        $('#btn-rincian').removeClass('bg-slate-100');
        $('#btn-rincian').addClass('bg-sky-500 text-white');

        $('#rincian').removeClass('hidden');
        $('#ulasan').addClass('hidden');
      }
    })
    $('#btn-rincian').addClass('bg-sky-500 text-white');
    $('#btn-ulasan').addClass('bg-slate-100');

    // counter
    let input_counter = $('#input_counter').val();
    if (input_counter <= "1") {
      $('#btn_minus').prop('disabled', true);
      $('#btn_minus').removeClass('bg-rose-600');
      $('#btn_minus').addClass('bg-rose-400');
    }
    $('#btn_plus').on('click', function (e) {
      e.preventDefault();
      let input_counter = $('#input_counter').val();
      $('#input_counter').val(parseInt(input_counter) + 1);
      $('#btn_minus').prop('disabled', false);
      $('#btn_minus').removeClass('bg-rose-400');
      $('#btn_minus').addClass('bg-rose-600');
      $('#nominal_jumlah').html(parseInt(input_counter) + 1);
    })
    $('#btn_minus').on('click', function (e) {
      e.preventDefault();
      let input_counter = $('#input_counter').val();
      if (input_counter <= 2) {
        $('#btn_minus').prop('disabled', true);
        $('#btn_minus').removeClass('bg-rose-600');
        $('#btn_minus').addClass('bg-rose-400');
      }
      $('#input_counter').val(parseInt(input_counter) - 1);
      $('#nominal_jumlah').html(parseInt(input_counter) - 1);
    })
    $('#input_counter').on('change', function () {
      console.log('input counter');
    })

    // btn beli
    $('.btn_beli').on('click', function (e) {
      e.preventDefault();
      const produk_id = $('#produk_id').val();
      const keterangan = $('#keterangan').val();
      const input_counter = $('#input_counter').val();
      const total = $('.nominal_total').text().replace('.','');

      let formData = {
        customer_id: 1,
        produk_id: produk_id,
        keterangan: keterangan,
        qty: input_counter,
        total: total
      }
      
      $.ajax({
        url: "{{ URL::route('keranjang.store') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('#loading_beli').removeClass('hidden');
          $('#loading_beli_sm').removeClass('hidden');
          $('.btn_beli').addClass('text-white');
        },
        success: function (response) {
          setTimeout(() => {
            $('#loading_beli').addClass('hidden');
            $('#loading_beli_sm').addClass('hidden');
            $('.btn_beli').removeClass('text-white');
            window.location = "{{ URL::route('keranjang') }}";
          }, 3000);
        },
        error: function (response) {
          if (response.status == 401) {
            window.location.href = "{{ URL::route('login') }}";
          }
        }
      })
    })
  })
</script>
@endsection