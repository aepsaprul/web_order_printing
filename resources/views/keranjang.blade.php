@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 2xl:w-3/5 lg:flex lg:justify-between mt-5">
    {{-- produk --}}
    <div class="lg:w-4/6 relative">
      @if ($keranjang->count())
        <input type="hidden" name="total_query" id="total_query" value="{{ count($keranjang) }}">
        @foreach ($keranjang as $key => $item)
          {{-- data hidden --}}
          <input type="hidden" name="harga_produk" id="harga_produk_{{ $key }}" value="{{ $item->harga }}">
          <input type="hidden" name="keranjang_id[]" id="keranjang_id_{{ $key }}" value="{{ $item->id }}">

          <div class="shadow-md m-3 lg:m-0 lg:mr-5 rounded">
            <div class="flex">
              <div class="m-3 w-1/5">
                @if ($item->produk)
                  <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item->produk->gambar) }}" alt="gambar produk" class="w-full">                    
                @endif
              </div>
              <div class="m-3 w-4/5">
                <div class="text-slate-800 font-semibold">
                  @if ($item->produk)
                    {{ $item->produk->nama }}                      
                  @endif
                </div>
                <div class="text-slate-800"><span class="text-xs">Rp</span> <span class="nominal_harga text-sm">@currency($item->harga)</span></div>
                <div class="text-xs">
                  @php
                    $total_template = count($item->dataKeranjangTemplate) - 1;
                  @endphp
                  @foreach ($item->dataKeranjangTemplate as $key_keranjang_template => $item_keranjang_template)
                    {{ $item_keranjang_template->dataTemplate->nama }} ({{ $item_keranjang_template->dataTemplateDetail->nama }}) 
                    {{ $key_keranjang_template != $total_template ? ',' : '' }}
                  @endforeach
                </div>
              </div>
            </div>
            <div class="flex justify-between">
              <div class="mx-3 my-3">
                {{-- btn hapus --}}
                <div class="space-y-2">
                  <button
                    id="btn_hapus_{{ $key }}"
                    type="button"
                    class="text-md"
                    data-id="{{ $item->id }}"
                    data-te-toggle="modal"
                    data-te-target="#exampleModalCenter"
                    data-te-ripple-init
                    data-te-ripple-color="light">
                    <i class="fa fa-trash-alt text-slate-500"></i>
                  </button>
                </div>
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
      @else
        <div>
          <div class="flex justify-center">
            <img src="{{ asset('assets/empty.png') }}" alt="empty logo" class="w-1/3">
          </div>
          <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="bg-sky-500 px-5 py-2 text-white font-bold rounded">Belanja Lagi</a>
          </div>
        </div>
      @endif
    </div>

    {{-- total --}}
    <div class="w-full lg:w-2/6">
      <div class="lg:fixed lg:w-1/4 lg:right-32 2xl:right-64">
        <div class="bg-white w-full fixed lg:relative bottom-0 lg:shadow">
          <div class="border-t lg:border-0 flex lg:block justify-between m-3 lg:m-0 lg:px-5 lg:py-3">
            <div class="w-full mt-3 lg:flex lg:justify-between">
              <div class="text-sm lg:text-lg">Total Harga</div>
              <div class="text-lg font-semibold"><span class="text-sm">Rp</span> <span id="total_harga">@currency($keranjang_total->total_harga)</span></div>
            </div>
            <div class="w-full mt-3">
              <div class="relative flex items-center justify-center h-full">
                <div id="loading_beli" class="hidden absolute">
                  <div class="flex items-center justify-center">
                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                      <div class="h-2 w-2 rounded-full bg-white"></div>
                    </div>
                  </div>
                </div>
                <button id="btn_beli" class="bg-sky-500 border text-center text-white font-bold w-full h-full lg:h-10 rounded-md">Beli</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- modal --}}
<div
  data-te-modal-init
  class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
  id="exampleModalCenter"
  data-te-backdrop="static"
  data-te-keyboard="false"
  tabindex="-1"
  aria-labelledby="exampleModalCenterTitle"
  aria-modal="true"
  role="dialog">
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
    <div class="border border-rose-300 rounded w-full">
      <div
        class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
        <div class="relative p-4">
          <input type="hidden" name="hapus_id" id="hapus_id">
          <p>Yakin akan dihapus?</p>
        </div>
        <div
          class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
          <button
            type="button"
            class="inline-block rounded bg-primary-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
            data-te-modal-dismiss
            data-te-ripple-init
            data-te-ripple-color="light">
            Batal
          </button>
          <div class="relative flex items-center justify-center">
            <div id="loading_hapus" class="hidden absolute">
              <div class="flex items-center justify-center">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-rose-500 to-slate-100 animate-spin">
                  <div class="h-2 w-2 rounded-full bg-white"></div>
                </div>
              </div>
            </div>
            <button
              type="button"
              id="btn_hapus_submit"
              class="ml-1 inline-block rounded bg-danger px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
              data-te-ripple-init
              data-te-ripple-color="light">
              Hapus
            </button>
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
    
    // counter
    const total_query = parseInt($('#total_query').val());

    for (let id = 0; id < total_query; id++) {
      const input_counter = $('#input_counter_' + id).val();
      if (input_counter < 2) {
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

        if (!val || isNaN(val) || parseInt(val) < 2) {
          $('#input_counter_' + id).val(1);

          $('#btn_minus_' + id).prop('disabled', true);
          $('#btn_minus_' + id).removeClass('bg-rose-600');
          $('#btn_minus_' + id).addClass('bg-rose-400');

          updateVal = 1;
        } else {
          updateVal = val;

          $('#btn_minus_' + id).prop('disabled', false);
          $('#btn_minus_' + id).removeClass('bg-rose-400');
          $('#btn_minus_' + id).addClass('bg-rose-600');
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

      // btn hapus
      $('#btn_hapus_' + id).on('click', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        $('#hapus_id').val(id);
      })

      $('#btn_hapus_submit').on('click', function (e) {
        e.preventDefault();
        const id = $('#hapus_id').val();

        let formData = {
          id: id
        }

        $.ajax({
          url: "{{ URL::route('keranjang.hapus') }}",
          type: "post",
          data: formData,
          beforeSend: function () {
            $('#loading_hapus').removeClass('hidden');
            $('#btn_hapus_submit').removeClass('bg-danger');
            $('#btn_hapus_submit').addClass('bg-white');
          },
          success: function (response) {
            setTimeout(() => {
              window.location.reload(1);
            }, 1000);
          }
        })
      })
    } // end for

    // btn beli
    $('#btn_beli').on('click', function (e) {
      e.preventDefault();

      $.ajax({
        url: "{{ URL::route('keranjang.beli') }}",
        type: "get",
        beforeSend: function () {
          $('#loading_beli').removeClass('hidden');
          $('#btn_beli').removeClass('bg-sky-500');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.href = "{{ URL::route('keranjang.checkout') }}";
          }, 1000);
        }
      })
    })
  })
</script>
@endsection