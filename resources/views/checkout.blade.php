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
  <div class="w-full lg:w-4/5 2xl:w-3/5 lg:flex lg:justify-between lg:mt-5">
    <div class="lg:w-4/6 relative">
      {{-- alamat pengiriman --}}
      <div class="mb-5 lg:mr-5">
        <p class="font-semibold text-sm border-b px-3 lg:px-0 py-3">Alamat Pengiriman</p>
        <div class="px-3 lg:px-0 py-3 rounded">
          <input type="hidden" id="customer_id" value="{{ Auth::user()->id }}">
          @if (Auth::user()->telepon || Auth::user()->kecamatan || Auth::user()->kabupaten || Auth::user()->provinsi || Auth::user()->kodepos)
            <p class="font-bold capitalize">{{ Auth::user()->nama_lengkap }}</p>
            <p class="text-sm uppercase">{{ Auth::user()->telepon }}</p>
            <p class="text-sm uppercase">{{ Auth::user()->alamat ? Auth::user()->alamat : '-' }}</p>
            <p class="text-sm uppercase">Kecamatan {{ Auth::user()->kecamatan ? Auth::user()->dataKecamatan->dis_name : '-' }}, Kabupaten/Kota {{ Auth::user()->kabupaten ? Auth::user()->dataKabupaten->city_name : '-' }}, Provinsi {{ Auth::user()->provinsi ? Auth::user()->dataProvinsi->prov_name : '-' }}, Kodepos {{ Auth::user()->kodepos ? Auth::user()->kodepos : '-' }}</p>              
          @else
            <button id="ubah_alamat" class="text-sky-500 font-bold"
              data-te-toggle="modal"
              data-te-target="#modalAlamat"
              data-te-ripple-init
              data-te-ripple-color="light"
            >Ubah Alamat</button>
          @endif
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
                <img src="{{ url('http://localhost/abata_web_order_admin/public/img_produk/' . $item->produk->gambar) }}" alt="gambar produk" class="w-20 h-20">
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
                          value="{{ $item->harga }}"
                          data-id="{{ $item->id }}" />
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
          <input type="hidden" id="total_rekening_bank" value="{{ count($rekening_bank) }}">
          <input type="hidden" id="total_rekening_ewallet" value="{{ count($rekening_ewallet) }}">

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
      <div class="lg:fixed lg:w-1/4 lg:right-32 2xl:right-60">
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
              <div class="text-slate-600"><span class="text-sm">- Rp</span> <span class="nominal_diskon">@currency($diskon)</div>
            </div>
          </div>
          <div class="border-t lg:border-0 flex lg:block justify-between mx-3 lg:mx-0 lg:px-3 lg:py-3">
            <div class="w-full mt-2 lg:flex lg:justify-between">
              <div class="text-sm lg:text-lg lg:font-semibold">Total Harga</div>
              <div class="text-lg font-semibold"><span class="text-sm">Rp</span> <span id="total_harga">@currency($transaksi_total)</span></div>
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
                <button id="btn_bayar" disabled class="bg-sky-300 border text-center text-white w-full h-full lg:h-10 rounded-md font-bold">Bayar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<div
  data-te-modal-init
  class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
  id="modalAlamat"
  tabindex="-1"
  aria-labelledby="modalAlamatTitle"
  aria-modal="true"
  role="dialog">
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
    <div
      class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <h5
          class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
          id="exampleModalScrollableLabel">
          Alamat Pengiriman
        </h5>
        <button
          type="button"
          class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
          data-te-modal-dismiss
          aria-label="Close">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <input type="text" name="telepon" id="telepon" class="w-full border border-slate-300 rounded px-2 py-1 outline-0" placeholder="Ketikkan Nomor HP">
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <select
          id="select_provinsi"
          data-te-select-init
          data-te-container="#modalAlamat"
          data-te-select-filter="true">              
        </select>
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <select
          id="select_kota"
          data-te-select-init
          data-te-container="#modalAlamat"
          data-te-select-filter="true">              
        </select>
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <select
          id="select_kecamatan"
          data-te-select-init
          data-te-container="#modalAlamat"
          data-te-select-filter="true">              
        </select>
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <textarea name="alamat" id="alamat" rows="3" class="w-full border border-slate-300 rounded p-2 outline-0" placeholder="Ketikkan alamat lengkap"></textarea>
      </div>
      <div class="relative flex-auto p-2" data-te-modal-body-ref>
        <input type="text" name="kodepos" id="kodepos" class="w-full border border-slate-300 rounded px-2 py-1 outline-0" placeholder="Ketikkan kodepos">
      </div>
      <div
        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <div class="relative flex items-center justify-center">
          <div id="modal_alamat_loading" class="hidden absolute">
            <div class="flex items-center justify-center">
              <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                <div class="h-2 w-2 rounded-full bg-white"></div>
              </div>
            </div>
          </div>
          <button
            type="button"
            class="modal-alamat-btn-simpan ml-1 inline-block rounded border border-sky-600 bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out">
            Simpan
          </button>
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

    // diskon
    const diskon = $('.nominal_diskon').text().replace(/\./g, '');
    // const total_harga_produk = Number($('#total_harga_produk').text().replace(/\./g, ''));
    // let diskon = total_harga_produk * 0.05;
    // let total_harga = Number($('#total_harga').text().replace(/\./g, ''));
    // let totalHargaCalc = total_harga - diskon;
    
    // $('.nominal_diskon').html(afRupiah(diskon));
    // $('#total_harga').html(afRupiah(totalHargaCalc));

    // ubah alamat
    const akun_id = $('#customer_id').val();
    $('#ubah_alamat').on('click', function () {
      $('.modal-alamat-title').html('Ubah Alamat');
      $('.modal-alamat-btn-simpan').prop('id', 'btn_simpan_alamat');

      let url = '{{ route("akun.editAlamat", ":id") }}';
      url = url.replace(':id', akun_id);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          let data_provinsi = `<option value="0">Pilih Provinsi</option>`;

          $.each(response.provinsi, function (index, item) {
            data_provinsi += `<option value="` + item.prov_id + `">` + item.prov_name + `</option>`;
          })

          $('#select_provinsi').html(data_provinsi);
        }
      })
    })
    $(document).on('change', '#select_provinsi', function () {
      const val = $(this).val();
      $('#select_kota').html('<option value="0">Pilih Kota</option>');
      $('#select_kecamatan').html('<option value="0">Pilih Kecamatan</option>');
      
      let url = '{{ route("akun.editAlamatKota", ":id") }}';
      url = url.replace(':id', val);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          let data_kota = `<option value="0">Pilih Kota</option>`;

          $.each(response.kota, function (index, item) {
            data_kota += `<option value="` + item.city_id + `">` + item.city_name + `</option>`;
          })

          $('#select_kota').html(data_kota);
        }
      })
    })
    $(document).on('change', '#select_kota', function () {
      const val = $(this).val();
      $('#select_kecamatan').html('<option value="0">Pilih Kecamatan</option>');
      
      let url = '{{ route("akun.editAlamatKecamatan", ":id") }}';
      url = url.replace(':id', val);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          let data_kecamatan = `<option value="0">Pilih Kecamatan</option>`;

          $.each(response.kecamatan, function (index, item) {
            data_kecamatan += `<option value="` + item.dis_id + `">` + item.dis_name + `</option>`;
          })

          $('#select_kecamatan').html(data_kecamatan);
        }
      })
    })
    $(document).on('click', '#btn_simpan_alamat', function () {
      const provinsi = $('#select_provinsi').val();
      const kabupaten = $('#select_kota').val();
      const kecamatan = $('#select_kecamatan').val();
      const alamat = $('#alamat').val();
      const kodepos = $('#kodepos').val();
      const telepon = $('#telepon').val();

      let formData = {
        id: akun_id,
        title: "alamat",
        provinsi: provinsi,
        kabupaten: kabupaten,
        kecamatan: kecamatan,
        alamat: alamat,
        kodepos: kodepos,
        telepon: telepon
      }

      $.ajax({
        url: "{{ URL::route('akun.updateDataDiri') }}",
        type: "post",
        data: formData,
        beforeSend: function (response) {
          $('#modal_alamat_loading').removeClass('hidden');
          $('.modal-alamat-btn-simpan').removeClass('bg-primary');
        },
        success: function (response) {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      })
    })

    // ekspedisi
    const total_ekspedisi = $('#total_ekspedisi').val();
    for (let index_ekspedisi = 0; index_ekspedisi < total_ekspedisi; index_ekspedisi++) {
      $('#radio_ekspedisi_' + index_ekspedisi).on('change', function () {
        const val = $(this).val();
        const total_harga_produk = $('#total_harga_produk').text().replace(/\./g, '');
        const calcTotal = (parseInt(total_harga_produk) + parseInt(val)) - diskon;
        
        $('#total_ongkos_kirim').html(afRupiah(val));
        $('#total_harga').html(afRupiah(calcTotal));

        const rekening_check = $('input[name="radio_rekening"]:checked').val();
        if (rekening_check) {
          $('#btn_bayar').prop('disabled', false);
          $('#btn_bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
        } else {
          $('#btn_bayar').prop('disabled', true);
          $('#btn_bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
        }
      })
    }

    // bank
    const total_rekening_bank = $('#total_rekening_bank').val();
    for (let index_bank = 0; index_bank < total_rekening_bank; index_bank++) {
      $('#radio_rekening_bank_' + index_bank).on('change', function () {
        const ekspedisi_check = $('input[name="radio_ekspedisi"]:checked').val();
        if (ekspedisi_check) {
          $('#btn_bayar').prop('disabled', false);
          $('#btn_bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
        } else {
          $('#btn_bayar').prop('disabled', true);
          $('#btn_bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
        }
      })
    }

    // e-wallet
    const total_rekening_ewallet = $('#total_rekening_ewallet').val();
    for (let index_ewallet = 0; index_ewallet < total_rekening_ewallet; index_ewallet++) {
      $('#radio_rekening_ewallet_' + index_ewallet).on('change', function () {
        const ekspedisi_check = $('input[name="radio_ekspedisi"]:checked').val();
        if (ekspedisi_check) {
          $('#btn_bayar').prop('disabled', false);
          $('#btn_bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
        } else {
          $('#btn_bayar').prop('disabled', true);
          $('#btn_bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
        }
      })
    }
    
    // btn bayar
    $('#btn_bayar').on('click', function (e) {
      const customer_id = $('#customer_id').val();
      const keranjang_id_total = $('#total_query').val();
      const total_harga_fix = $('#total_harga').text().replace(/\./g, '');
      const eskpedisi_id = $('input[name="radio_ekspedisi"]:checked').attr('data-id');
      const rekening_val = $('input[name="radio_rekening"]:checked').val();
      const keranjang_id = [];

      for (let index = 0; index < parseInt(keranjang_id_total); index++) {
        const val_keranjang_id = $('#keranjang_id_' + index).val();
        keranjang_id.push(val_keranjang_id);
      }

      let formData = {
        customer_id: customer_id,
        keranjang_id: keranjang_id,
        ekspedisi: eskpedisi_id,
        rekening: rekening_val,
        total_harga: total_harga_fix,
        diskon: diskon
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
          var kode = response.status;
          var url = '{{ route("invoice", ":kode") }}';
          url = url.replace(':kode', kode);
          window.location.href = url;
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