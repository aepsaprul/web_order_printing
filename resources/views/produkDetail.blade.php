@extends('layouts.app')

@section('content')

@include('layouts.header')

<div id="notif" class="hidden fixed right-10 mt-10">
  <div class="bg-emerald-500 w-72 py-2 px-5 rounded text-center text-white ease-in-out duration-300">Berhasil masuk keranjang <i class="fa fa-check font-bold text-xl text-lime-300 ml-3"></i></div>
</div>

<form>  
  {{-- data --}}
  <input type="hidden" name="produk_id" id="produk_id" value="{{ $produk->id }}">

  <div class="lg:flex lg:justify-center">
    <div class="lg:w-4/5 lg:flex 2xl:w-3/5 bg-white mt-2">
      <div class="p-3 lg:w-2/4">
        <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $produk->gambar) }}" alt="gambar produk" class="my-2">
      </div>
      <div class="p-3 lg:w-2/4">
        <div class="my-3 lg:my-0 text-xl font-bold">{{ $produk->nama }}</div>
        <div>
          @if ($ulasan_total->total_rating)
            @php
              $ulasan_total_ = $ulasan_total->total_rating / count($ulasan); 
            @endphp
            <div class="text-slate-300 text-2xl">
              <i class="fas fa-star @if (1 <= $ulasan_total_) {{ "text-yellow-500" }} @endif cursor-pointer"></i>
              <i class="fas @if ($ulasan_total_ > 1 && $ulasan_total_ < 2) {{ "fa-star-half-alt text-yellow-500" }} @else {{ "fa-star" }} @endif @if (2 <= $ulasan_total_) {{ "text-yellow-500" }} @endif cursor-pointer"></i>
              <i class="fas @if ($ulasan_total_ > 2 && $ulasan_total_ < 3) {{ "fa-star-half-alt text-yellow-500" }} @else {{ "fa-star" }} @endif @if (3 <= $ulasan_total_) {{ "text-yellow-500" }} @endif cursor-pointer"></i>
              <i class="fas @if ($ulasan_total_ > 3 && $ulasan_total_ < 4) {{ "fa-star-half-alt text-yellow-500" }} @else {{ "fa-star" }} @endif @if (4 <= $ulasan_total_) {{ "text-yellow-500" }} @endif cursor-pointer"></i>
              <i class="fas @if ($ulasan_total_ > 4 && $ulasan_total_ < 5) {{ "fa-star-half-alt text-yellow-500" }} @else {{ "fa-star" }} @endif @if (5 <= $ulasan_total_) {{ "text-yellow-500" }} @endif cursor-pointer"></i>
            </div>              
          @endif
        </div>
        <div>
          <p class="text-slate-500 text-sm my-2">{{ $produk->deskripsi_singkat }}</p>
        </div>

        {{-- template --}}
        <input type="hidden" name="template_total" id="template_total" value="{{ count($produk_template) }}"> <!-- jumlah total query template -->
        @foreach ($template as $key => $item) <!-- loop tabel template -->
          <div class="my-3">
            @foreach ($produk_template as $key_produk_template => $item_produk_template) <!-- loop tabel produk_template -->
              @if ($item_produk_template->template_id == $item->id) <!-- jika template_id yg ada di tabel produk_template sama dengan template_id yg ada di tabel template -->
                <input type="hidden" name="template[]" value="{{ $item->id }}">
                <div class="font-semibold my-1">{{ $item->nama }}</div>
                <select name="template_detail[]" id="template_{{ $key_produk_template }}" class="border text-slate-700 w-full p-2 rounded border-sky-600 outline-0 cursor-pointer">
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
            <input type="hidden" name="produk_harga" id="produk_harga" value="{{ $produk_harga }}">
            <div>Harga Barang</div>
            <div>Rp <span class="nominal_harga">{{ $produk_harga }}</span></div>
          </div>
          <div class="flex justify-between py-1">
            <div>Jumlah</div>
            <div><span id="nominal_jumlah">1</span></div>
          </div>
          <div class="flex justify-between py-1">
            <div class="font-bold">Total</div>
            <div class="font-bold">Rp <span class="nominal_total">{{ $produk_harga }}</span></div>
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
  <div class="lg:flex lg:justify-center my-5 lg:pb-5">
    <div class="lg:w-4/5 2xl:w-3/5 p-5 bg-white">
      <ul
        class="mb-5 flex list-none flex-col flex-wrap border-b-0 pl-0 md:flex-row"
        role="tablist"
        data-te-nav-ref>
        <li role="presentation">
          <a
            href="#tabs-home"
            class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
            data-te-toggle="pill"
            data-te-target="#tabs-home"
            data-te-nav-active
            role="tab"
            aria-controls="tabs-home"
            aria-selected="true"
            >Rincian</a
          >
        </li>
        <li role="presentation">
          <a
            href="#tabs-profile"
            class="focus:border-transparen my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
            data-te-toggle="pill"
            data-te-target="#tabs-profile"
            role="tab"
            aria-controls="tabs-profile"
            aria-selected="false"
            >Ulasan</a
          >
        </li>
      </ul>
      <div class="mb-6">
        <div
          class="hidden transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
          id="tabs-home"
          role="tabpanel"
          aria-labelledby="tabs-home-tab"
          data-te-tab-active>
            <div>{!! $produk->deskripsi !!}</div>
        </div>
        <div
          class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
          id="tabs-profile"
          role="tabpanel"
          aria-labelledby="tabs-profile-tab">
            @foreach ($ulasan as $item_ulasan)
              <div class="flex p-2">
                <div>
                  <img src="{{ asset('assets/1665988705.jpg') }}" alt="avatar" class="w-10 rounded-full shadow">
                </div>
                <div>
                  <div class="m-3">{{ $item_ulasan->dataCustomer->nama_lengkap }}</div>
                  <div class="m-3">
                    <div class="text-slate-300 text-2xl">
                      <i class="fas fa-star cursor-pointer {{ 1 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star cursor-pointer {{ 2 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star cursor-pointer {{ 3 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star cursor-pointer {{ 4 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star cursor-pointer {{ 5 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                    </div>
                  </div>
                  <div class="m-3">{{ $item_ulasan->keterangan }}</div>
                </div>
              </div>              
              <div><hr></div>
            @endforeach
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
        const val_onload = $('#template_' + index).val();
        const id_this = $('#template_' + index).find('option:selected', '#template_' + index);

        let result = 0;
        id_this.each(function (index_, item) {
          result = $(this).data('id');
        })

        template_detail_val[index] = result; // override array data-id dari select
        template_awal[index] = val_onload; // override array dasar dengan value template

        let template_hasil = 0;
        for (let i_template_hasil = 0; i_template_hasil < template_awal.length; i_template_hasil++) { // perhitungan tambah untuk array dasar yg sudah di override
          template_hasil += parseInt(template_awal[i_template_hasil]);
        }

        const templateCalc = parseInt($('#produk_harga').val()) + template_hasil;
        const input_counter = $('#input_counter').val();
        const templateTotalCalc = templateCalc * input_counter;
        $('.nominal_harga').html(afRupiah(templateCalc));
        $('.nominal_total').html(afRupiah(templateTotalCalc));

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