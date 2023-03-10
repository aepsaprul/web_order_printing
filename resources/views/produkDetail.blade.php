@extends('layouts.app')

@section('content')

@include('layouts.header')
{{-- @include('layouts.headerArrow')
@include('layouts.headerLg') --}}

<div id="notif" class="hidden fixed right-10 mt-10">
  <div class="bg-emerald-500 w-72 py-2 px-5 rounded text-center text-white ease-in-out duration-300">Berhasil masuk keranjang <i class="fa fa-check font-bold text-xl text-lime-300 ml-3"></i></div>
</div>

<form>  
  {{-- data --}}
  <input type="hidden" name="produk_id" id="produk_id" value="{{ $produk->id }}">

  <div class="lg:flex lg:justify-center">
    <div class="lg:w-4/5 lg:flex 2xl:w-3/5">
      <div class="lg:w-2/4">
        <img src="{{ url('http://localhost/abata_web_order_admin/public/img_produk/' . $produk->gambar) }}" alt="gambar produk" class="my-2">
      </div>
      <div class="mx-3 my-2 lg:w-2/4">
        <div class="my-3 lg:my-0 text-xl font-bold">{{ $produk->nama }}</div>
        <div>
          <p class="text-slate-500 text-sm my-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis sequi ea iusto ipsum? Sequi, voluptates corporis nihil aperiam laborum quibusdam!</p>
        </div>

        {{-- template --}}
        <input type="hidden" name="template_total" id="template_total" value="{{ count($produk_template) }}"> <!-- jumlah total query template -->
        @foreach ($template as $key => $item) <!-- loop tabel template -->
          <div class="my-3">
            @foreach ($produk_template as $key => $item_produk_template) <!-- loop tabel produk_template -->
              @if ($item_produk_template->template_id == $item->id) <!-- jika template_id yg ada di tabel produk_template sama dengan template_id yg ada di tabel template -->
                <input type="hidden" name="template[]" value="{{ $item->id }}">
                <div class="font-semibold my-1">{{ $item->nama }}</div>
                <select name="template_detail[]" id="template_{{ $key }}" class="border text-slate-700 w-full p-2 rounded border-sky-600 outline-0 cursor-pointer">
                  <option value="0" data-id="0" class="text-slate-700">Pilih {{ $item->nama }}</option>
                  @foreach ($template_detail as $item_detail) <!-- loop tabel template_detail -->
                    @if ($item_detail->template_id == $item->id) <!-- jika template_id yg ada di tabel template_detail sama dengan id yg ada di tabel template -->
                      @foreach ($produk_template_detail as $item_produk_template_detail) <!-- loop tabel produk_template_detail -->
                        @if ($item_produk_template_detail->template_detail_id == $item_detail->id) <!-- jika template_detail_id yg ada id tabel produk_template_detail sama dengan id yg ada di tabel template_detail -->
                          <option value="{{ $item_detail->harga }}" data-id="{{ $item_detail->id }}" class="text-slate-900">{{ $item_detail->nama }}</option>                                                  
                        @endif
                      @endforeach
                    @endif
                  @endforeach
                </select>                 
              @endif
            @endforeach
          </div>
        @endforeach

        <div class="mt-4">
          <label for="keterangan" class="font-semibold">Keterangan</label>
          <textarea name="keterangan" id="keterangan" rows="4" class="w-full border border-sky-600 rounded p-3 mt-2 outline-0" placeholder="Maksimal 200 karakter"></textarea>
        </div>

        {{-- upload --}}
        {{-- <div class="mt-2">
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
              <p class="text-sm px-2 mt-4 text-slate-600">*Jika ukuran file lebih dari 10Mb, silahkan upload file di dropbox / google drive dan masukkkan link file anda <a href="#" id="btn_disini" class="text-sky-600">disini</a>.</p>
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
        </div> --}}
        <div class="mt-5">
          <div class="ml-5 text-xs italic mb-1">Minimal Pembelian: {{ $produk->min_beli }} <span class="capitalize">{{ $produk->satuan }}</span></div>
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
            <input type="hidden" name="produk_harga" id="produk_harga" value="{{ $produk->harga }}">
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
            <button class="btn-beli w-full p-2 rounded font-bold border-2 border-sky-600">Beli</button>
          </div>
          <div class="relative flex items-center justify-center">
            <div id="loading_keranjang" class="hidden absolute">
              <div class="flex items-center">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
                  <div class="h-2 w-2 rounded-full bg-white"></div>
                </div>
                <span class="text-white">Loading. . .</span>
              </div>
            </div>
            <button class="btn-keranjang w-full bg-sky-600 text-white p-2 rounded font-bold"><i class="fa fa-shopping-cart"></i> Keranjang</button>
          </div>
          {{-- <button class="btn-keranjang w-full bg-sky-600 text-white p-1 rounded font-bold"><i class="fa fa-shopping-cart"></i> Keranjang</button> --}}
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
          <p>{!! $produk->deskripsi !!}</p>
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
      <button class="btn-beli w-full m-3 p-2 rounded border-2 border-sky-600 font-bold text-sm">Beli</button>
    </div>
    <div class="w-full relative flex items-center justify-center">
      <div id="loading_keranjang_sm" class="hidden absolute">
        <div class="flex items-center">
          <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
            <div class="h-2 w-2 rounded-full bg-white"></div>
          </div>
          <span class="text-white">Loading. . .</span>
        </div>
      </div>
      <button class="btn-keranjang w-full bg-sky-600 m-3 p-2 rounded text-white font-bold text-sm"><i class="fa fa-shopping-cart"></i> Keranjang</button>
    </div>
    {{-- <button class="btn-keranjang w-full bg-sky-600 m-3 p-1 rounded text-white font-bold"><i class="fa fa-shopping-cart"></i> Keranjang</button> --}}
  </div>
</form>

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

    // template
    const template_total = parseInt($('#template_total').val());
    const template_awal = [];
    const template_detail_val = [];

    for (let i_template = 0; i_template < template_total; i_template++) { // output [0,0,0] untuk array dasar
      template_awal[i_template] = 0;
      template_detail_val[i_template] = 0;
    }

    for (let index = 0; index < template_total; index++) { // loop produk template      
      $('#template_' + index).on('change', function () { // onchange template
        const val_this = $('#template_' + index).val(); // value template ketika onchange
        const id_this = $(this).find('option:selected', this);

        let result = 0;
        id_this.each(function (index_, item) {
          result = $(this).data('id');
        })

        template_detail_val[index] = result; // override array data-id dari select
        template_awal[index] = val_this; // override array dasar dengan value template
        
        let template_hasil = 0;
        for (let i_template_hasil = 0; i_template_hasil < template_awal.length; i_template_hasil++) { // perhitungan tambah untuk array dasar yg sudah di override
          template_hasil += parseInt(template_awal[i_template_hasil]);
        }

        const templateCalc = parseInt($('#produk_harga').val()) + template_hasil;
        const input_counter = $('#input_counter').val();
        const templateTotalCalc = templateCalc * input_counter;
        $('.nominal_harga').html(afRupiah(templateCalc));
        $('.nominal_total').html(afRupiah(templateTotalCalc));
      })
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
    // btn plus
    $('#btn_plus').on('click', function (e) {
      e.preventDefault();
      let input_counter = $('#input_counter').val();
      const current_counter = parseInt(input_counter) + 1;
      const harga = parseInt($('.nominal_harga').text().replace(/\./g, ''));
      const harga_counter = harga * current_counter;

      $('#btn_minus').prop('disabled', false);
      $('#btn_minus').removeClass('bg-rose-400');
      $('#btn_minus').addClass('bg-rose-600');

      $('#input_counter').val(current_counter);
      $('#nominal_jumlah').html(current_counter);
      $('.nominal_total').html(afRupiah(harga_counter));
    })
    // btn minus
    $('#btn_minus').on('click', function (e) {
      e.preventDefault();
      let input_counter = $('#input_counter').val();
      const current_counter = parseInt(input_counter) - 1;
      const harga = parseInt($('.nominal_harga').text().replace(/\./g, ''));
      const harga_counter = harga * current_counter;

      if (input_counter <= 2) {
        $('#btn_minus').prop('disabled', true);
        $('#btn_minus').removeClass('bg-rose-600');
        $('#btn_minus').addClass('bg-rose-400');
      }

      $('#input_counter').val(current_counter);
      $('#nominal_jumlah').html(current_counter);
      $('.nominal_total').html(afRupiah(harga_counter));
    })
    // input
    $('#input_counter').on('keyup', function () {
        const val = $(this).val();
        let updateVal;

        if (!val || isNaN(val) || parseInt(val) < 2) {
          $('#input_counter').val(1);

          $('#btn_minus').prop('disabled', true);
          $('#btn_minus').removeClass('bg-rose-600');
          $('#btn_minus').addClass('bg-rose-400');

          updateVal = 1;
        } else {
          updateVal = val;

          $('#btn_minus').prop('disabled', false);
          $('#btn_minus').removeClass('bg-rose-400');
          $('#btn_minus').addClass('bg-rose-600');
        }

        const harga = parseInt($('.nominal_harga').text().replace(/\./g, ''));
        const harga_counter = harga * updateVal;
        
        $('#nominal_jumlah').html(updateVal);
        $('.nominal_total').html(afRupiah(harga_counter));
      })

    // btn beli
    $('.btn-beli').on('click', function (e) {
      e.preventDefault();
      const produk_id = $('#produk_id').val();
      const keterangan = $('#keterangan').val();
      const input_counter = $('#input_counter').val();
      const harga = $('.nominal_harga').text().replace(/\./g, '');
      const total = $('.nominal_total').text().replace(/\./g,'');

      const template_val = new Array();
      $('input[name="template[]"]').each(function () {
        template_val.push($(this).val());
      })

      let formData = {
        produk_id: produk_id,
        harga: harga,
        template: template_val,
        template_detail: template_detail_val,
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
          $('.btn-beli').addClass('text-white');
        },
        success: function (response) {
          setTimeout(() => {
            $('#loading_beli').addClass('hidden');
            $('#loading_beli_sm').addClass('hidden');
            $('.btn-beli').removeClass('text-white');
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

    // btn keranjang
    $('.btn-keranjang').on('click', function (e) {
      e.preventDefault();
      $('#notif').removeClass('hidden');
      setTimeout(() => {
        $('#notif').addClass('hidden');        
      }, 2000);

      const produk_id = $('#produk_id').val();
      const keterangan = $('#keterangan').val();
      const input_counter = $('#input_counter').val();
      const harga = $('.nominal_harga').text().replace(/\./g, '');
      const total = $('.nominal_total').text().replace(/\./g,'');

      const template_val = new Array();
      $('input[name="template[]"]').each(function () {
        template_val.push($(this).val());
      })

      let formData = {
        produk_id: produk_id,
        harga: harga,
        template: template_val,
        template_detail: template_detail_val,
        keterangan: keterangan,
        qty: input_counter,
        total: total
      }
      
      $.ajax({
        url: "{{ URL::route('keranjang.store') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('#loading_keranjang').removeClass('hidden');
          $('#loading_keranjang_sm').removeClass('hidden');
          $('.btn-keranjang').removeClass('text-white');
          $('.btn-keranjang').addClass('text-sky-600');
        },
        success: function (response) {
          const jml_keranjang = response.jml_keranjang.length;          
          if (jml_keranjang > 0) {
            $('.notif-keranjang').removeClass('hidden');
            $('.notif-keranjang-jml').html(jml_keranjang);            
          }

          setTimeout(() => {
            $('#loading_keranjang').addClass('hidden');
            $('#loading_keranjang_sm').addClass('hidden');
            $('.btn-keranjang').addClass('text-white');
            $('.btn-keranjang').removeClass('text-sky-600');
            $('#notif').removeClass('hidden');
          }, 1000);
          setTimeout(() => {
            $('#notif').addClass('hidden');        
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