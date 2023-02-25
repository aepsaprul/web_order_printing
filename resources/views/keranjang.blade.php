@extends('layouts.app')

@section('content')

@include('layouts.headerArrow')
@include('layouts.headerLg')

<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 lg:flex lg:justify-between mt-5">
    {{-- produk --}}
    <div class="lg:w-4/6 relative">
      <input type="hidden" name="total_query" id="total_query" value="{{ count($keranjang) }}">
      @foreach ($keranjang as $key => $item)
        {{-- data hidden --}}
        <input type="hidden" name="harga_produk" id="harga_produk_{{ $key }}" value="{{ $item->produk->harga }}">

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
                <button id="btn_minus_{{ $key }}" class="btn-minus-{{ $key }} bg-rose-600 px-4 py-1 text-white rounded-l-full text-sm" data-id="{{ $item->id }}"><i class="fa fa-minus"></i></button>
              </div>
              <div>
                <input type="text" name="input_counter" id="input_counter_{{ $key }}" value="{{ $item->qty }}" minlength="1" maxlength="6" class="w-16 h-full outline-0 text-center text-sm text-slate-500 border" data-id="{{ $item->id }}">
              </div>
              <div>
                <button id="btn_plus_{{ $key }}" class="btn-plus-{{ $key }} bg-emerald-600 px-4 py-1 text-white rounded-r-full text-sm" data-id="{{ $item->id }}"><i class="fa fa-plus"></i></button>
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

{{-- @include('layouts.navBawah') --}}
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
    
    // counter
    const total_query = $('#total_query').val();

    for (let id = 0; id < total_query; id++) {
      const input_counter = $('#input_counter_' + id).val();
      if (input_counter <= "1") {
        $('#btn_minus_' + id).prop('disabled', true);
        $('#btn_minus_' + id).removeClass('bg-rose-600');
        $('#btn_minus_' + id).addClass('bg-rose-400');
      }
  
      // btn minus
      $('.btn-minus-' + id).on('click', function (e) {
        e.preventDefault();
        const keranjang_id = $(this).attr('data-id');
        const harga = $('#harga_produk_' + id).val();

        // ubah value input
        const input_counter = $('#input_counter_' + id).val();
        const input_counter_minus = parseInt(input_counter) - 1;
        $('#input_counter_' + id).val(input_counter_minus);

        if (input_counter <= 2) {
          $('#btn_minus_' + id).prop('disabled', true);
          $('#btn_minus_' + id).removeClass('bg-rose-600');
          $('#btn_minus_' + id).addClass('bg-rose-400');
        }
        
        let formData = {
          id: keranjang_id,
          harga: harga,
          qty: input_counter_minus
        }

        $.ajax({
          url: "{{ URL::route('keranjang.kurang') }}",
          type: "post",
          data: formData,
          success: function (response) {      
            $('#total_harga').html(afRupiah(response.total_harga));
          }
        })
      })

      // btn plus
      $('.btn-plus-' + id).on('click', function (e) {
        e.preventDefault();
        const keranjang_id = $(this).attr('data-id');
        const harga = $('#harga_produk_' + id).val();

        // ubah value input
        const input_counter = $('#input_counter_' + id).val();
        const input_counter_plus = parseInt(input_counter) + 1;
        $('#input_counter_' + id).val(input_counter_plus);
        $('#btn_minus_' + id).prop('disabled', false);
        $('#btn_minus_' + id).removeClass('bg-rose-400');
        $('#btn_minus_' + id).addClass('bg-rose-600');

        let formData = {
          id: keranjang_id,
          harga: harga,
          qty: input_counter_plus
        }

        $.ajax({
          url: "{{ URL::route('keranjang.tambah') }}",
          type: "post",
          data: formData,
          success: function (response) {      
            $('#total_harga').html(afRupiah(response.total_harga));
          }
        })        
      })
      
      // input
      $('#input_counter_' + id).on('keyup', function () {
        const val = $(this).val();
        const keranjang_id = $(this).attr('data-id');
        const harga = $('#harga_produk_' + id).val();
        let updateVal;

        if (!val || isNaN(val) || parseInt(val) < 1) {
          $('#input_counter_' + id).val(1);

          $('#btn_minus_' + id).prop('disabled', true);
          $('#btn_minus_' + id).removeClass('bg-rose-600');
          $('#btn_minus_' + id).addClass('bg-rose-400');

          updateVal = 1;
        } else {
          updateVal = val;
        }

        let formData = {
          id: keranjang_id,
          harga: harga,
          qty: updateVal
        }

        $.ajax({
          url: "{{ URL::route('keranjang.inputText') }}",
          type: "post",
          data: formData,
          success: function (response) {
            setTimeout(() => {
              $('#total_harga').html(afRupiah(response.total_harga));
            }, 2000);
          }
        })
      })
    }
  })
</script>
@endsection