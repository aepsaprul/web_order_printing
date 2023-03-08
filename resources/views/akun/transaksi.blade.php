@extends('akun.index')

@section('content_akun')
<div>
  <h3 class="font-bold text-lg">Transaksi</h3>
</div>
<div class="flex">
  <div class="w-full">
    @foreach ($transaksi as $item)
    <div class="border rounded my-2 p-2">
      <div class="flex">
        <div class="text-sm mr-3">
          @php
            $transaksi_tanggal = Carbon\Carbon::parse($item->created_at)->locale('id');
            $transaksi_tanggal->settings(['formatFunction' => 'translatedFormat']);
          @endphp
          {{ $transaksi_tanggal->format('d F Y') }}
        </div>
        <div class="text-sm mr-3">{{ $item->kode }}</div>
        <div class="{{ $item->status == 6 ? 'bg-green-600 rounded' : 'bg-rose-600 rounded' }} px-3 text-sm text-white font-semibold">{{ $item->dataStatus->nama }}</div>
      </div>
      <div class="flex justify-between mt-3">
        <div>
          @foreach ($item->dataKeranjang as $item)
            <div class="flex my-3">
              <div>
                <img src="{{ asset('assets/1665988705.jpg') }}" alt="gambar produk" class="w-16">
              </div>
              <div class="ml-3">
                <div class="font-bold">{{ $item->produk->nama }}</div>
                <div class="text-sm text-slate-500">{{ $item->qty }} {{ $item->produk->satuan }} x <span class="text-xs">Rp</span> @currency($item->harga)</div>
              </div>              
            </div>
          @endforeach
        </div>
        <div class="border-l-2 h-12 px-12">
          <div class="text-sm">Total Belanja</div>
          <div class="font-bold">Rp @currency($item->total)</div>
        </div>
      </div>
      <div class="flex justify-end items-center">
        <div><a href="#" class="font-bold text-sm mx-2 text-sky-400">Detail Transaksi</a></div>
        <div><button class="bg-sky-500 py-2 px-7 mx-2 text-white font-bold text-sm rounded">Ulas</button></div>
        <div><button class="bg-sky-500 py-2 px-7 mx-2 text-white font-bold text-sm rounded">Beli Lagi</button></div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection