@extends('layouts.app')

@section('content')
<div class="flex justify-center border-b h-14">
  <div class="w-full lg:w-4/5 lg:flex lg:items-center mt-2">
    <div class="mr-5">
      <a href="{{ route('keranjang') }}"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div>
      <span>Checkout</span>
    </div>
  </div>
</div>
<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 lg:flex lg:justify-between mt-5">
    {{-- produk --}}
    <div class="lg:w-4/6 relative">
      <input type="hidden" name="total_query" id="total_query" value="{{ count($keranjang) }}">
      @foreach ($keranjang as $key => $item)
        {{-- data hidden --}}
        <input type="hidden" name="harga_produk" id="harga_produk_{{ $key }}" value="{{ $item->produk->harga }}">
        <input type="hidden" name="keranjang_id[]" id="keranjang_id_{{ $key }}" value="{{ $item->id }}">

        <div class="shadow-md m-3 lg:m-0 lg:mr-5 rounded">
          <div class="flex">
            <div class="m-3">
              <img src="{{ $item->produk->gambar }}" alt="gambar produk" class="w-20 h-20">
            </div>
            <div class="m-3 w-full">
              <div class="text-slate-800 font-semibold">{{ $item->produk->nama }}</div>
              <div class="text-slate-800">x {{ $item->qty }} </div>
              <div class="text-slate-800 text-right font-semibold">Rp @currency($item->total)</div>
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
              <div class="relative flex items-center justify-center">
                <div id="loading_beli" class="hidden absolute">
                  <div class="flex items-center justify-center">
                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                      <div class="h-2 w-2 rounded-full bg-white"></div>
                    </div>
                  </div>
                </div>
                <button id="btn_beli" class="bg-sky-500 border text-center text-white w-full h-full lg:h-10 rounded">Pilih Pembayaran</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection