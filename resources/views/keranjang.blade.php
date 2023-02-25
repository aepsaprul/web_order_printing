@extends('layouts.app')

@section('content')

@include('layouts.header')
@include('layouts.headerLg')

<div class="flex justify-center">
  <div class="w-full lg:w-4/5 lg:flex lg:justify-between mt-5">
    {{-- produk --}}
    <div class="lg:w-4/6 relative">
      @foreach ($keranjang as $item)
        {{-- data hidden --}}
        <input type="hidden" name="harga_produk" id="harga_produk_{{ $item->id }}" value="{{ $item->produk->harga }}">

        <div class="shadow-md m-3 lg:m-0 lg:mr-5 rounded">
          <div class="flex">
            <div class="m-3">
              <img src="{{ $item->produk->gambar }}" alt="gambar produk" class="w-20 h-20">
            </div>
            <div class="m-3">
              <div class="text-slate-800 font-semibold">{{ $item->produk->nama }}</div>
              <div class="text-slate-800">Rp <span class="nominal_harga">@currency($item->produk->harga)</span></div>
            </div>
          </div>
          <div class="flex justify-between">
            <div class="mx-3 my-3">
              <i class="fa fa-trash-alt text-slate-500"></i>
            </div>
            <div class="mx-3 my-3 flex">
              <div>
                <button class="btn-minus bg-rose-400 px-4 py-1 text-white rounded-l-full text-sm" data-id="{{ $item->id }}"><i class="fa fa-minus"></i></button>
              </div>
              <div>
                <input type="text" name="input_counter" id="input_counter" value="1" minlength="1" maxlength="6" class="w-16 h-full outline-0 text-center text-sm text-slate-500 border">
              </div>
              <div>
                <button class="btn-plus bg-emerald-400 px-4 py-1 text-white rounded-r-full text-sm" data-id="{{ $item->id }}"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
        </div>          
      @endforeach
    </div>

    {{-- total --}}
    <div class="w-full lg:w-2/6">
      <div class="lg:fixed lg:w-1/4 lg:right-32">
        <div class="bg-white w-full fixed lg:relative bottom-0 lg:shadow">
          <div class="border-t lg:border-0 flex lg:block justify-between m-3 lg:m-0 lg:px-5 lg:py-3">
            <div class="w-full mt-3 lg:flex lg:justify-between">
              <div class="text-sm lg:text-lg lg:font-semibold">Total Harga</div>
              <div class="text-lg font-semibold">Rp <span id="total_harga">@currency($keranjang_total->total_harga)</span></div>
            </div>
            <div class="w-full mt-3">
              <button class="bg-sky-500 text-center text-white w-full h-full lg:h-10 rounded">Beli</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- @include('layouts.navBawah')
@include('layouts.footer') --}}

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
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
    
    $('.btn-minus').on('click', function (e) {
      e.preventDefault();
      const id = $(this).attr('data-id');
      const harga = $('#harga_produk_' + id).val();
      const total_harga = $('#total_harga').text();
      const total_harga_ = total_harga.replace(/\./g,'');
      const calcHarga = parseInt(total_harga_) - parseInt(harga);

      $('#total_harga').html(afRupiah(calcHarga));
      console.log(id, harga, total_harga_, afRupiah(harga));
    })
    $('.btn-plus').on('click', function (e) {
      e.preventDefault();
      const id = $(this).attr('data-id');
      const harga = $('#harga_produk_' + id).val();
      const total_harga = $('#total_harga').text();
      const total_harga_ = total_harga.replace(/\./g,'');
      const calcHarga = parseInt(total_harga_) + parseInt(harga);

      $('#total_harga').html(afRupiah(calcHarga));


      console.log(id, harga, total_harga_, afRupiah(calcHarga));
    })
  })
</script>
@endsection