@extends('layouts.app')

@section('content')

@include('layouts.header')

<div>
  <h1 class="text-center font-bold my-5 text-xl text-slate-500">Kategori Produk</h1>
  <div class="grid grid-cols-4 gap-3">
    @foreach ($kategori as $item)
      <a href="{{ route('kategori.show', $item->id) }}">
        <div>
          <div class="flex justify-center">
            <img src="{{ url('http://localhost/abata_web_order_admin/public/img_kategori/' . $item->gambar) }}" alt="kategori" class="w-20">
          </div>
          <div class="text-center font-semibold mt-2">{{ $item->nama }}</div>
        </div>
      </a>
    @endforeach
  </div>
</div>

@include('layouts.navBawah')

@endsection