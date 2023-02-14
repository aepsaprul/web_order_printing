@extends('layouts.app')

@section('content')

@include('layouts.headerArrow')

<div>
  <div>
    <img src="{{ $produk->gambar }}" alt="">
  </div>
  <div class="mx-3 my-2">
    <div class="my-3 text-xl font-bold">{{ $produk->nama }}</div>
    <div>
      <p class="text-slate-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis sequi ea iusto ipsum? Sequi, voluptates corporis nihil aperiam laborum quibusdam!</p>
    </div>
    <div class="mt-4">
      <label for="keterangan" class="font-semibold">Keterangan</label>
      <textarea name="keterangan" id="keterangan" rows="4" class="w-full border border-sky-600 rounded p-3 mt-2 outline-0" placeholder="Maksimal 200 karakter"></textarea>
    </div>
    <div class="mt-4">
      <div class="flex justify-between py-1">
        <div>Harga Barang</div>
        <div>Rp 95.000</div>
      </div>
      <div class="flex justify-between py-1">
        <div>Jumlah</div>
        <div>100 pcs</div>
      </div>
      <div class="flex justify-between py-1">
        <div class="font-bold">Total</div>
        <div>Rp 105.000</div>
      </div>
    </div>
    <div class="mt-5">
      <div class="tab grid grid-cols-2">
        <button id="btn-rincian" class="linktab rounded-tl py-1" id="default">Rincian</button>
        <button id="btn-ulasan" class="linktab rounded-tr py-1">Ulasan</button>
      </div>
      
      <div id="rincian" class="mt-3">
        <h3>Rincian</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, molestiae.</p>
      </div>      
      <div id="ulasan" class="hidden mt-3">
        <h3>Ulasan</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci voluptatibus in labore iusto autem dolorum sed. Exercitationem ducimus natus expedita.</p> 
      </div>
    </div>
  </div>
  <div class="w-full fixed bottom-0 bg-white border-t flex">
    <button class="w-full m-3 p-1 rounded border-2 border-sky-600 font-bold">Beli</button>
    <button class="w-full bg-sky-600 m-3 p-1 rounded text-white font-bold"><i class="fa fa-plus"></i> Keranjang</button>
  </div>
</div>

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    const harga = $('.harga').text();
    $('.harga').html(afRupiah(harga))
    
    function afRupiah(bilangan) {
      var	number_string = harga.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
          
      if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      return rupiah;
    }

    // tab detail
    const tab = [];

    $('#btn-ulasan').on('click', function (e) {
      e.preventDefault();
      tab.pop();
      tab.push('ulasan');
    
      if (tab[0] == 'ulasan') {
        $('#btn-ulasan').removeClass('bg-slate-100');
        $('#btn-ulasan').addClass('bg-sky-500 text-white');
        $('#btn-rincian').removeClass('bg-slate-100 text-white');
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
  })
</script>
@endsection