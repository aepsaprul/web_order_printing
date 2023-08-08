@extends('layouts.app')

@section('title') {{ 'Checkout' }} @endsection

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
      <div class="mb-5 p-4 lg:mr-5 bg-white rounded border">
        <p class="font-semibold text-sm border-b px-3 lg:px-0 pb-3">Alamat Pengiriman</p>
        <div class="px-3 lg:px-0 py-3">
          <input type="hidden" id="customer_id" value="{{ Auth::user()->id }}">
          @if (Auth::user()->kecamatan || Auth::user()->kabupaten || Auth::user()->provinsi || Auth::user()->kodepos)
            <p class="font-bold capitalize">{{ Auth::user()->nama_lengkap }}</p>
            <p class="text-sm uppercase">{{ Auth::user()->telepon }}</p>
            <p class="text-sm uppercase">{{ Auth::user()->alamat ? Auth::user()->alamat : '-' }}</p>
            <p class="text-sm uppercase">Kecamatan {{ Auth::user()->kecamatan ? Auth::user()->dataKecamatan->kecamatan : '-' }}, Kabupaten/Kota {{ Auth::user()->kabupaten ? Auth::user()->dataKabupaten->kabupaten : '-' }}, Provinsi {{ Auth::user()->provinsi ? Auth::user()->dataProvinsi->provinsi : '-' }}, Kodepos {{ Auth::user()->kodepos ? Auth::user()->kodepos : '-' }}</p>              
            <button id="ubah_alamat" class="text-sky-500 font-bold mt-3"
              data-te-toggle="modal"
              data-te-target="#modalAlamat"
              data-te-ripple-init
              data-te-ripple-color="light"
            >Ubah Alamat</button>
            <input type="hidden" id="cek_alamat" value="1">
          @else
            <button id="ubah_alamat" class="text-sky-500 font-bold"
              data-te-toggle="modal"
              data-te-target="#modalAlamat"
              data-te-ripple-init
              data-te-ripple-color="light"
            >Ubah Alamat</button>
            <input type="hidden" id="cek_alamat" value="0">
          @endif
        </div>
      </div>
      {{-- produk --}}
      <div class="lg:mr-5">
        <input type="hidden" name="total_query" id="total_query" value="{{ count($keranjang) }}">
        @php
          $berat = 0;
        @endphp
        @foreach ($keranjang as $key => $item)
          {{-- data hidden --}}
          <input type="hidden" name="harga_produk" id="harga_produk_{{ $key }}" value="{{ $item->produk->harga }}">
          <input type="hidden" name="keranjang_id[]" id="keranjang_id_{{ $key }}" value="{{ $item->id }}">
  
          <div class="border mx-3 lg:mx-0 my-3 rounded bg-white">
            <div class="flex">
              <div class="flex w-4/5">
                <div class="m-3 w-1/5">
                  <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item->produk->gambar) }}" alt="gambar produk" class="w-full">
                </div>
                <div class="m-3 w-4/5">
                  <div class="text-slate-800 font-semibold">{{ $item->produk->nama }}</div>
                  <div class="text-slate-800">x {{ $item->qty }} </div>
                  <div class="text-xs">
                    @php
                      $total_template = count($item->dataKeranjangTemplate) - 1;
                      $hitung_berat = $item->produk->berat * $item->qty;
                      $berat = $berat + $hitung_berat;
                    @endphp
                    @foreach ($item->dataKeranjangTemplate as $key_keranjang_template => $item_keranjang_template)
                      {{ $item_keranjang_template->dataTemplate->nama }} ({{ $item_keranjang_template->dataTemplateDetail->nama }}) 
                      {{ $key_keranjang_template != $total_template ? ',' : '' }}
                    @endforeach
                  </div>
                  <div class="text-xs">Berat {{ $item->produk->berat * $item->qty }}gram</div>
                </div>
              </div>
              <div class="flex items-end justify-end w-1/5">
                <div class="text-slate-800 text-right font-semibold p-2"><span class="text-sm">Rp</span> @currency($item->total)</div>
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
    
          <div class="ml-3 lg:ml-0 mr-3 my-2 bg-white rounded border p-3">
            <p class="font-semibold text-sm border-b pb-3">Pilih Pengiriman</p>
            <div class="mt-3">
              <label for="layanan_pengiriman_adt">
                <input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_adt" class="mr-3" value="0"> Ambil Di Tempat
              </label>
            </div>
            <div class="mt-3">
              <div class="my-2">
                <div class="text-sm mb-2">Atau menggunakan kurir</div>
                <select name="origin" id="origin" class="border rounded py-2 px-2 w-full">
                  <option value="41">Situmpur (Banyumas)</option>
                  <option value="41">HR Boenyamin (Banyumas)</option>
                  <option value="41">Dukuh Waluh (Banyumas)</option>
                  <option value="105">Cilacap</option>
                  <option value="375">Purbalingga</option>
                  <option value="92">Bumiayu (Brebes)</option>
                </select>
              </div>
              <input type="hidden" name="kabupaten" id="kabupaten" value="{{ Auth::user()->kabupaten }}">
              <input type="hidden" name="destination" id="destination" value="{{ Auth::user()->kecamatan }}">
              <input type="hidden" name="weight" id="weight" value="{{ $berat }}">
              <div class="my-2">
                <div class="relative flex items-center justify-center h-full">
                  <div id="loading_cek_ongkir" class="hidden absolute">
                    <div class="flex items-center justify-center">
                      <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                        <div class="h-2 w-2 rounded-full bg-white"></div>
                      </div>
                    </div>
                  </div>
                  <button id="btn_cek_ongkir" class="bg-sky-500 border rounded py-2 px-4 text-white texk-sm font-bold ring-offset-1 ring-1 ring-sky-500">Cek Ongkir</button>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <div class="results-pengiriman">
                <div class="jne"></div>
                <div class="tiki"></div>
                <div class="pos"></div>
                <div class="jnt"></div>
                <div class="sicepat"></div>
              </div>
            </div>
          </div>
        </div>
        
        {{-- rekening --}}
        <div class="ml-3 mr-3 lg:mr-0 my-2 lg:w-2/4 bg-white h-56 rounded border p-3">
          {{-- data hidden --}}
          <input type="hidden" id="total_rekening" value="{{ count($rekening) }}">
          <input type="hidden" id="total_rekening_bank" value="{{ count($rekening_bank) }}">
          <input type="hidden" id="total_rekening_ewallet" value="{{ count($rekening_ewallet) }}">

          <div>
            <p class="font-semibold text-sm border-b pb-3">Pilih Pembayaran</p>
          </div>
          <div>
            <!-- bank -->
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
                        <img src="{{ url(env('APP_URL_ADMIN') . '/img_rekening/' . $item->gambar) }}" alt="gambar" class="w-full h-8 border bg-white p-1">
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
            <!-- e-wallet -->
            <!-- <div>
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
                      <img src="{{ url(env('APP_URL_ADMIN') . '/img_rekening/' . $item->gambar) }}" alt="gambar" class="w-full h-8 border bg-white p-1">
                  </label>
                </div>
                @endforeach
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <!-- total -->
    <!-- mobile -->
    <div class="lg:hidden">
      <div class="fixed bottom-0 right-0 left-0 bg-white">
        <div class="wrap-total-detail hidden p-2">
          <div class="flex justify-between">
            <div class="text-slate-600">Total Harga Produk</div>
            <div class="text-slate-600"><span class="text-sm">Rp</span> <span id="total_harga_produk" class="total-harga-produk">@currency($keranjang_total->total_harga)</span></div>
          </div>
          <div class="flex justify-between">
            <div class="text-slate-600">Ongkos Kirim</div>
            <div class="text-slate-600"><span class="text-sm">+ Rp</span> <span id="total_ongkos_kirim" class="total-ongkos-kirim">0</span></div>
          </div>
          <div class="flex justify-between">
            <div class="text-slate-600">Diskon</div>
            <div class="text-slate-600"><span class="text-sm">- Rp</span> <span class="nominal_diskon">@currency($diskon)</div>
          </div>
        </div>
        <div class="border flex justify-between p-2">
          <div>
            <div class="label-total text-sm">Total Harga <i class="fas fa-sort-up"></i></div>
            <div class="text-lg font-bold"><span class="text-sm">Rp</span> <span id="total_harga" class="total-harga">@currency($transaksi_total)</span></div>
          </div>
          <div class="w-1/3">
            <div class="relative flex items-center justify-center h-full">
              <div id="loading" class="loading hidden absolute">
                <div class="flex items-center justify-center">
                  <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                    <div class="h-2 w-2 rounded-full bg-white"></div>
                  </div>
                </div>
              </div>
              <button id="btn_bayar" disabled class="btn-bayar bg-sky-300 border text-center text-white font-bold w-full h-10 rounded-md ring-offset-1 ring-1 ring-sky-500">Bayar</button>
            </div>
          </div>
        </div>
        <div id="error_cek_alamat"></div>
      </div>
    </div>

    <!-- desktop -->
    <div class="hidden lg:block lg:w-2/6">
      <div class="fixed w-1/4 right-32 2xl:right-60">
        <div class="bg-white relative shadow">
          <div class="mx-3 pt-3">
            <div class="flex justify-between">
              <div class="text-slate-600">Total Harga</div>
              <div class="text-slate-600"><span class="text-sm">Rp</span> <span id="total_harga_produk" class="total-harga-produk">@currency($keranjang_total->total_harga)</span></div>
            </div>
            <div class="flex justify-between">
              <div class="text-slate-600">Ongkos Kirim</div>
              <div class="text-slate-600"><span class="text-sm">+ Rp</span> <span id="total_ongkos_kirim" class="total-ongkos-kirim">0</span></div>
            </div>
            <div class="flex justify-between">
              <div class="text-slate-600">Diskon</div>
              <div class="text-slate-600"><span class="text-sm">- Rp</span> <span class="nominal_diskon">@currency($diskon)</div>
            </div>
          </div>
          <div class="mx-3 py-3">
            <div class="w-full mt-2 lg:flex lg:justify-between">
              <div class="text-sm lg:text-lg lg:font-semibold">Total Harga</div>
              <div class="text-lg font-semibold"><span class="text-sm">Rp</span> <span id="total_harga" class="total-harga">@currency($transaksi_total)</span></div>
            </div>
            <div class="w-full mt-3">
              <div class="relative flex items-center justify-center h-full">
                <div id="loading" class="loading hidden absolute">
                  <div class="flex items-center justify-center">
                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-sky-500 to-slate-100 animate-spin">
                      <div class="h-2 w-2 rounded-full bg-white"></div>
                    </div>
                  </div>
                </div>
                <button id="btn_bayar" disabled class="btn-bayar bg-sky-300 border text-center text-white w-full h-full lg:h-10 rounded-md font-bold">Bayar</button>
              </div>
            </div>
          </div>
          <div id="error_cek_alamat"></div>
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
      class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4">
        <h5
          class="text-xl font-medium leading-normal text-neutral-800"
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
        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4">
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
            data_provinsi += `<option value="` + item.id + `">` + item.provinsi + `</option>`;
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
            data_kota += `<option value="` + item.id + `">` + item.kabupaten + `</option>`;
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
            data_kecamatan += `<option value="` + item.id + `">` + item.kecamatan + `</option>`;
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

    // ongkir
    $(document).on('change', '#kabupaten', function () {
      const val = $(this).val();
      
      let url = "{{ route('keranjang.kecamatan', ':id') }}";
      url = url.replace(':id', val);

      $.ajax({
        url: url,
        type: "get",
        success: function (response) {
          // console.log(response)
          let val = `<option value="0">Pilih Kecamatan</option>`;

          $.each(response.kecamatan, function (index, item) {
            val += `<option value="`+ item.id +`">`+ item.kecamatan +`</option>`;
          })

          $('#destination').html(val);
        }
      })
    })

    $('#btn_cek_ongkir').on('click', function (e) {
      e.preventDefault();

      const cek_alamat = Number($('#cek_alamat').val());

      if (cek_alamat == 0) {
        alert('Alamat Pengiriman Harus Diisi.');
      } else {
        const origin = $('#origin').val();
        const destination = $('#destination').val();
        const weight = $('#weight').val();
        const courier = $('#courier').val();

        let formData = {
          origin: origin,
          destination: destination,
          weight: weight,
          courier: courier
        }

        $.ajax({
          url: "{{ URL::route('keranjang.ongkir') }}",
          type: "post",
          data: formData,
          beforeSend: function () {
            $('#loading_cek_ongkir').removeClass('hidden');
            $('#btn_cek_ongkir').removeClass('bg-sky-500');
          },
          success: function (response) {
            console.log(response)
            const jne = response.jne.rajaongkir.results[0];
            const jne_costs = jne.costs[0];
            const tiki = response.tiki.rajaongkir.results[0];
            const tiki_costs = tiki.costs[0];
            const pos = response.pos.rajaongkir.results[0];
            const pos_costs = pos.costs[0];
            const jnt = response.jnt.rajaongkir.results[0];
            const jnt_costs = jnt.costs[0];
            const sicepat = response.sicepat.rajaongkir.results[0];
            const sicepat_costs = sicepat.costs[0];
            setTimeout(() => {
              $('#loading_cek_ongkir').addClass('hidden');
              $('#btn_cek_ongkir').addClass('bg-sky-500');
            }, 500);

            // jne
            let val_jne = `
              <div class="border-b py-2">
                <div class="text-sm">${jne.name}</div>
              </div>
              <div class="my-2">
                <div class="text-sm">
                  <label for="layanan_pengiriman_" class="flex justify-between">
                    <div><input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_" data-name="${jne.name}" class="mr-3" `;
                      $.each(jne_costs.cost, function(index_cost, item_cost) {
                        val_jne += `value="${item_cost.value}"`;
                      })
                      val_jne += `>${jne_costs.service} (${jne_costs.description})</div>
                    <div><span class="text-xs">Rp</span> `;                        
                      $.each(jne_costs.cost, function(index_cost, item_cost) {
                        val_jne += `${afRupiah(item_cost.value)}`;
                      })
                      val_jne += `</div>
                  </label>
                </div>                
              `;
              val_jne += `</div>
            `;
            $('.jne').html(val_jne)

            // tiki
            let val_tiki = `
              <div class="border-b py-2">
                <div class="text-sm">${tiki.name}</div>
              </div>
              <div class="my-2">
                <div class="text-sm">
                  <label for="layanan_pengiriman_${tiki.code}" class="flex justify-between">
                    <div><input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_${tiki.code}" data-name="${tiki.name}" class="mr-3" `;
                      $.each(tiki_costs.cost, function(index_cost, item_cost) {
                        val_tiki += `value="${item_cost.value}"`;
                      })
                      val_tiki += `>${tiki_costs.service} (${tiki_costs.description})</div>
                    <div><span class="text-xs">Rp</span> `;                        
                      $.each(tiki_costs.cost, function(index_cost, item_cost) {
                        val_tiki += `${afRupiah(item_cost.value)}`;
                      })
                      val_tiki += `</div>
                  </label>
                </div>`;
              val_tiki += `</div>
            `;
            $('.tiki').html(val_tiki)

            // pos
            let val_pos = `
              <div class="border-b py-2">
                <div class="text-sm">${pos.name}</div>
              </div>
              <div class="my-2">
                <div class="text-sm">
                  <label for="layanan_pengiriman_${pos.code}" class="flex justify-between">
                    <div><input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_${pos.code}" data-name="${pos.name}" class="mr-3" `;
                      $.each(pos_costs.cost, function(index_cost, item_cost) {
                        val_pos += `value="${item_cost.value}"`;
                      })
                      val_pos += `>${pos_costs.service} (${pos_costs.description})</div>
                    <div><span class="text-xs">Rp</span> `;                        
                      $.each(pos_costs.cost, function(index_cost, item_cost) {
                        val_pos += `${afRupiah(item_cost.value)}`;
                      })
                      val_pos += `</div>
                  </label>
                </div>`;
              val_pos += `</div>
            `;
            $('.pos').html(val_pos)

            // jnt
            let val_jnt = `
              <div class="border-b py-2">
                <div class="text-sm">${jnt.name}</div>
              </div>
              <div class="my-2">
                <div class="text-sm">
                  <label for="layanan_pengiriman_${jnt.code}" class="flex justify-between">
                    <div><input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_${jnt.code}" data-name="${jnt.name}" class="mr-3" `;
                      $.each(jnt_costs.cost, function(index_cost, item_cost) {
                        val_jnt += `value="${item_cost.value}"`;
                      })
                      val_jnt += `>${jnt_costs.service} (${jnt_costs.description})</div>
                    <div><span class="text-xs">Rp</span> `;                        
                      $.each(jnt_costs.cost, function(index_cost, item_cost) {
                        val_jnt += `${afRupiah(item_cost.value)}`;
                      })
                      val_jnt += `</div>
                  </label>
                </div>`;
              val_jnt += `</div>
            `;
            $('.jnt').html(val_jnt)

            // sicepat
            let val_sicepat = `
              <div class="border-b py-2">
                <div class="text-sm">${sicepat.name}</div>
              </div>
              <div class="my-2">
                <div class="text-sm">
                  <label for="layanan_pengiriman_${sicepat.code}" class="flex justify-between">
                    <div><input type="radio" name="layanan_pengiriman" id="layanan_pengiriman_${sicepat.code}" data-name="${sicepat.name}" class="mr-3" `;
                      $.each(sicepat_costs.cost, function(index_cost, item_cost) {
                        val_sicepat += `value="${item_cost.value}"`;
                      })
                      val_sicepat += `>${sicepat_costs.service} (${sicepat_costs.description})</div>
                    <div><span class="text-xs">Rp</span> `;                        
                      $.each(sicepat_costs.cost, function(index_cost, item_cost) {
                        val_sicepat += `${afRupiah(item_cost.value)}`;
                      })
                      val_sicepat += `</div>
                  </label>
                </div>`;
              val_sicepat += `</div>
            `;
            $('.sicepat').html(val_sicepat)
          }
        })
      }
    })

    $(document).on('click', 'input[name="layanan_pengiriman"]', function () {
      const val = $(this).val();
      const total_harga_produk = $('#total_harga_produk').text().replace(/\./g, '');
      const calcTotal = (parseInt(total_harga_produk) + parseInt(val)) - diskon;
      
      $('.total-ongkos-kirim').html(afRupiah(val));
      $('.total-harga').html(afRupiah(calcTotal));

      const rekening_check = $('input[name="radio_rekening"]:checked').val();
      if (rekening_check) {
        $('.btn-bayar').prop('disabled', false);
        $('.btn-bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
      } else {
        $('.btn-bayar').prop('disabled', true);
        $('.btn-bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
      }
    })

    // bank
    const total_rekening_bank = $('#total_rekening_bank').val();
    for (let index_bank = 0; index_bank < total_rekening_bank; index_bank++) {
      $('#radio_rekening_bank_' + index_bank).on('change', function () {
        const ekspedisi_check = $('input[name="layanan_pengiriman"]:checked').val();
        if (ekspedisi_check) {
          $('.btn-bayar').prop('disabled', false);
          $('.btn-bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
        } else {
          $('.btn-bayar').prop('disabled', true);
          $('.btn-bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
        }
      })
    }

    // e-wallet
    const total_rekening_ewallet = $('#total_rekening_ewallet').val();
    for (let index_ewallet = 0; index_ewallet < total_rekening_ewallet; index_ewallet++) {
      $('#radio_rekening_ewallet_' + index_ewallet).on('change', function () {
        const ekspedisi_check = $('input[name="layanan_pengiriman"]:checked').val();
        if (ekspedisi_check) {
          $('.btn-bayar').prop('disabled', false);
          $('.btn-bayar').removeClass('bg-sky-300').addClass('bg-sky-500');
        } else {
          $('.btn-bayar').prop('disabled', true);
          $('.btn-bayar').removeClass('bg-sky-500').addClass('bg-sky-300');
        }
      })
    }

    // total detail
    const labelTotal = document.querySelector('.label-total');
    const wrapTotalDetail = document.querySelector('.wrap-total-detail');

    labelTotal.addEventListener('click', function(e) {
      e.preventDefault();
      wrapTotalDetail.classList.toggle('hidden');
    })
    
    // btn bayar
    $('.btn-bayar').on('click', function (e) {
      const customer_id = $('#customer_id').val();
      const keranjang_id_total = $('#total_query').val();
      const total_harga_fix = $('#total_harga').text().replace(/\./g, '');
      const ekspedisi = $('input[name="layanan_pengiriman"]:checked').attr('data-name');
      const ekspedisi_harga = $('input[name="layanan_pengiriman"]:checked').val();
      const rekening_val = $('input[name="radio_rekening"]:checked').val();
      const keranjang_id = [];
      const cek_alamat = Number($('#cek_alamat').val());

      if (cek_alamat == 0) {
        let val = `<div class="px-3 py-2 italic text-rose-500 text-sm">*Data alamat harus diisi</div>`;
        $('#error_cek_alamat').html(val);
      } else {
        for (let index = 0; index < parseInt(keranjang_id_total); index++) {
          const val_keranjang_id = $('#keranjang_id_' + index).val();
          keranjang_id.push(val_keranjang_id);
        }
  
        let formData = {
          customer_id: customer_id,
          keranjang_id: keranjang_id,
          ekspedisi: ekspedisi,
          ekspedisi_harga: ekspedisi_harga,
          rekening: rekening_val,
          total_harga: total_harga_fix,
          diskon: diskon
        }
  
        $.ajax({
          url: "{{ URL::route('keranjang.bayar') }}",
          type: "post",
          data: formData,
          beforeSend: function () {
            $('.loading').removeClass('hidden');
            $('.btn-bayar').removeClass('bg-sky-500');
          },
          success: function (response) {
            var kode = response.status;
            var url = '{{ route("invoice", ":kode") }}';
            url = url.replace(':kode', kode);
            window.location.href = url;
            setTimeout(() => {
              $('.loading').addClass('hidden');
              $('.btn-bayar').addClass('bg-sky-500');
            }, 3000);
          }
        })        
      }
    })
  })
</script>
@endsection