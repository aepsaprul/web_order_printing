@extends('layouts.app')

@section('content')
<div id="header-wrapper" class="flex justify-center items-center border-b h-12 lg:h-14 sticky top-0 bg-white z-10">
  <div class="w-full lg:w-4/5 flex items-center lg:mt-2">
    <div class="mx-3">
      <a href="{{ route('keranjang') }}"><i class="fa fa-arrow-left text-lg"></i></a>
    </div>
    <div>
      <span class="text-lg">Checkout</span>
    </div>
  </div>
</div>
<div class="flex justify-center pb-24">
  <div class="w-full lg:w-4/5 lg:flex lg:justify-between lg:mt-5">
    <div class="lg:w-4/6 relative">
      {{-- alamat pengiriman --}}
      <div class="mb-5 lg:mr-5">
        <p class="font-semibold text-sm border-b px-3 lg:px-0 py-3">Alamat Pengirimanfeere</p>
        <div class="px-3 lg:px-0 py-3 rounded">
          <input type="hidden" id="customer_id" value="{{ Auth::user()->id }}">
          <p class="font-bold capitalize">{{ Auth::user()->nama_lengkap }}</p>
          <p class="text-sm uppercase">{{ Auth::user()->telepon }}</p>
          <p class="text-sm uppercase">{{ Auth::user()->alamat }}</p>
          <p class="text-sm uppercase">Kec. {{ Auth::user()->dataKecamatan->dis_name }}, Kab. {{ Auth::user()->dataKabupaten->city_name }}, {{ Auth::user()->dataProvinsi->prov_name }}, {{ Auth::user()->kodepos }}</p>
        </div>
      </div>
      {{-- produk --}}
      <div class="lg:mr-5">
        <input type="hidden" name="total_query" id="total_query" value="{{ count($keranjang) }}">
        @foreach ($keranjang as $key => $item)
          {{-- data hidden --}}
          <input type="hidden" name="harga_produk" id="harga_produk_{{ $key }}" value="{{ $item->produk->harga }}">
          <input type="hidden" name="keranjang_id[]" id="keranjang_id_{{ $key }}" value="{{ $item->id }}">
  
          <div class="border-2 mx-3 lg:mx-0 my-3 rounded">
            <div class="flex">
              <div class="m-3">
                <img src="{{ $item->produk->gambar }}" alt="gambar produk" class="w-20 h-20">
              </div>
              <div class="m-3 w-full">
                <div class="text-slate-800 font-semibold">{{ $item->produk->nama }}</div>
                <div class="text-slate-800">x {{ $item->qty }} </div>
                <div class="text-slate-800 text-right font-semibold"><span class="text-sm">Rp</span> @currency($item->total)</div>
              </div>
            </div>
          </div>          
        @endforeach
      </div>

      <div class="lg:flex lg:mr-5">
        {{-- pengiriman --}}
        <div class="lg:w-2/4">
          {{-- data hidden --}}
          <input type="hidden" id="total_ekspedisi" value="{{ count($ekspedisi) }}">
    
          <div class="ml-3 lg:ml-0 mr-3 my-2">
            <p class="font-semibold text-sm border-b py-3">Pilih Pengiriman</p>
            <div class="mt-3">
              @foreach ($ekspedisi as $key => $item)
                <div class="flex w-full">
                  <div class="w-3/4 flex">
                    <div class="w-32">
                      <div class="mb-[0.125rem] block min-h-[1.5rem] pl-[1.5rem]">
                        <input
                          class="radio_ekspedisi_{{ $key }} relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-[rgba(0,0,0,0.25)] bg-white before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:block after:h-4 after:w-4 after:rounded-full after:bg-white after:content-[''] checked:border-primary checked:bg-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:bg-white checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                          type="radio"
                          name="radio_ekspedisi"
                          id="radio_ekspedisi_{{ $key }}"
                          value="{{ $item->harga }}" />
                        <label
                          class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer bg-white"
                          for="radio_ekspedisi_{{ $key }}">
                            <img src="{{ url('http://localhost/abata_web_order_admin/public/img_ekspedisi/' . $item->gambar) }}" alt="gambar" class="w-12 h-5">
                        </label>
                      </div>
                    </div>
                    <div class="w-full text-sm">{{ $item->nama }}</div>
                  </div>
                  <div class="w-1/4 text-right">
                    <span class="text-xs">Rp</span> <span class="text-sm">@currency($item->harga)</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        
        {{-- rekening --}}
        <div class="ml-3 mr-3 lg:mr-0 my-2 lg:w-2/4">
          {{-- data hidden --}}
          <input type="hidden" id="total_rekening" value="{{ count($rekening) }}">

          <div>
            <p class="font-semibold text-sm border-b py-3">Pilih Pembayaran</p>
          </div>
          <div>
            <div>
              <p class="text-sm py-2">Bank</p>
              <div class="float-left">
                @foreach ($rekening_bank as $key => $item)
                  <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem] w-26">
                    <input
                      class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-[rgba(0,0,0,0.25)] bg-white before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:block after:h-4 after:w-4 after:rounded-full after:bg-white after:content-[''] checked:border-primary checked:bg-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:bg-white checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                      type="radio"
                      name="radio_rekening"
                      id="radio_rekening_bank_{{ $key }}"
                      value="{{ $item->id }}" />
                    <label
                      class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                      for="radio_rekening_bank_{{ $key }}">
                        <img src="{{ url('http://localhost/abata_web_order_admin/public/img_rekening/' . $item->gambar) }}" alt="gambar" class="w-full h-8 border bg-white p-1">
                    </label>
                  </div>
                @endforeach
              </div>
            </div>  
            <div>
              <p class="text-sm py-2">Wallet</p>
              <div class="float-left">
              @foreach ($rekening_ewallet as $key => $item)
                <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem] w-26">
                  <input
                    class="relative float-left mt-0.5 mr-1 -ml-[1.5rem] h-5 w-5 appearance-none rounded-full border-2 border-solid border-[rgba(0,0,0,0.25)] bg-white before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:block after:h-4 after:w-4 after:rounded-full after:bg-white after:content-[''] checked:border-primary checked:bg-white checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:bg-white checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s]"
                    type="radio"
                    name="radio_rekening"
                    id="radio_rekening_ewallet_{{ $key }}"
                    value="{{ $item->id }}" />
                  <label
                    class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                    for="radio_rekening_ewallet_{{ $key }}">
                      <img src="{{ url('http://localhost/abata_web_order_admin/public/img_rekening/' . $item->gambar) }}" alt="gambar" class="w-full h-8 border bg-white p-1">
                  </label>
                </div>
                @endforeach
              </div>
            </div> 
          </div>
        </div>
      </div>
    </div>

    {{-- total --}}
    <div class="w-full lg:w-2/6">
      <div class="lg:fixed lg:w-1/4 lg:right-32">
        <div class="bg-white w-full fixed lg:relative bottom-0 lg:shadow">
          <div class="mx-3 pt-3 hidden lg:block">
            <div class="flex justify-between">
              <div class="text-slate-600">Total Harga</div>
              <div class="text-slate-600"><span class="text-sm">Rp</span> <span id="total_harga_produk">@currency($keranjang_total->total_harga)</span></div>
            </div>
            <div class="flex justify-between">
              <div class="text-slate-600">Ongkos Kirim</div>
              <div class="text-slate-600"><span class="text-sm">+ Rp</span> <span id="total_ongkos_kirim">0</span></div>
            </div>
            <div class="flex justify-between">
              <div class="text-slate-600">Diskon</div>
              <div class="text-slate-600"><span class="text-sm">- Rp</span> 0</div>
            </div>
          </div>
          <div class="border-t lg:border-0 flex lg:block justify-between mx-3 lg:mx-0 lg:px-3 lg:py-3">
            <div class="w-full mt-2 lg:flex lg:justify-between">
              <div class="text-sm lg:text-lg lg:font-semibold">Total Harga</div>
              <div class="text-lg font-semibold"><span class="text-sm">Rp</span> <span id="total_harga">@currency($keranjang_total->total_harga)</span></div>
            </div>
            <div class="w-full mt-2">
              <div class="relative flex items-center justify-center h-full">
                <div id="loading_beli" class="hidden absolute">
                  <div class="flex items-center justify-center">
                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                      <div class="h-2 w-2 rounded-full bg-white"></div>
                    </div>
                  </div>
                </div>
                <div class="w-full mt-3">
                  <div class="relative flex items-center justify-center h-full">
                    <div id="loading" class="hidden absolute">
                      <div class="flex items-center justify-center">
                        <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                          <div class="h-2 w-2 rounded-full bg-white"></div>
                        </div>
                      </div>
                    </div>
                    <button id="btn_bayar" class="bg-sky-500 border text-center text-white w-full h-full lg:h-10 rounded-md font-bold">Bayar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const total_ekspedisi = $('#total_ekspedisi').val();
    
    for (let index_ekspedisi = 0; index_ekspedisi < total_ekspedisi; index_ekspedisi++) {
      $('#radio_ekspedisi_' + index_ekspedisi).on('change', function () {
        const val = $(this).val();
        const total_harga_produk = $('#total_harga_produk').text().replace(/\./g, '');
        const calcTotal = parseInt(total_harga_produk) + parseInt(val);
        
        $('#total_ongkos_kirim').html(afRupiah(val));
        $('#total_harga').html(afRupiah(calcTotal));
      })
    }

    $('#btn_bayar').on('click', function (e) {
      const customer_id = $('#customer_id').val();
      const keranjang_id_total = $('#total_query').val();
      const eskpedisi_val = $('input[name="radio_ekspedisi"]:checked').val();
      const rekening_val = $('input[name="radio_rekening"]:checked').val();
      const keranjang_id = [];

      for (let index = 0; index < parseInt(keranjang_id_total); index++) {
        const val_keranjang_id = $('#keranjang_id_' + index).val();
        keranjang_id.push(val_keranjang_id);
      }

      let formData = {
        customer_id: customer_id,
        keranjang_id: keranjang_id,
        ekspedisi: eskpedisi_val,
        rekening: rekening_val
      }

      $.ajax({
        url: "{{ URL::route('keranjang.bayar') }}",
        type: "post",
        data: formData,
        beforeSend: function () {
          $('#loading').removeClass('hidden');
          $('#btn_bayar').removeClass('bg-sky-500');
        },
        success: function (response) {
          console.log(response);
          setTimeout(() => {
            $('#loading').addClass('hidden');
            $('#btn_bayar').addClass('bg-sky-500');
          }, 3000);
        }
      })
    })
  })
</script>
@endsection