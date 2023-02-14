@extends('layouts.app')

@section('content')

@include('layouts.header')

<div>
  <div>
    <img src="{{ $produk->gambar }}" alt="">
  </div>
  <div>Rp. <span class="harga">{{ $produk->harga }}</span></div>
</div>


@include('layouts.navBawah')

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    const harga = $('.harga').text();
    console.log(afRupiah(harga));
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
  })

</script>
@endsection