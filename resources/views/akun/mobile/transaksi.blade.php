@extends('layouts.app')

@section('title') {{ 'Transaksi' }} @endsection

@section('content')

@include('layouts.header')

<div class="pb-20">
  {{-- data hidden --}}
  <input type="hidden" name="transaksi_total" id="transaksi_total" value="{{ $transaksi->count() }}">

  @if (count($transaksi) > 0)
    @foreach ($transaksi as $key => $item)
      <div class="m-3">
        <div class="border rounded-md bg-white">
          <div class="flex justify-between border-b p-2">
            <div>
              <div class="text-sm">
                @php
                  $transaksi_tanggal = Carbon\Carbon::parse($item->created_at)->locale('id');
                  $transaksi_tanggal->settings(['formatFunction' => 'translatedFormat']);
                @endphp
                {{ $transaksi_tanggal->format('d F Y') }}          
              </div>
              <div class="text-sm font-semibold">{{ $item->kode }}</div>      
            </div>
            <div>
              <div class="{{ $item->status == 6 ? 'bg-green-600 rounded' : 'bg-rose-600 rounded' }} px-3 text-sm text-white font-semibold">{{ $item->dataStatus->nama }}</div>
              <div class="flex justify-end">
                <button class="lihat-detail-{{ $key }} text-sky-500 text-sm font-thin border my-1 px-2 rounded"
                  data-te-toggle="modal"
                  data-te-target="#modalTransaksiDetail"
                  data-te-ripple-init
                  data-te-ripple-color="light"
                  data-id="{{ $item->id }}"
                >Lihat Detail</button>
              </div>
            </div>
          </div>
          <div>
            <input type="hidden" id="keranjang_total_{{ $key }}" value="{{ $item->dataKeranjang->count() }}">
            @foreach ($item->dataKeranjang as $key_keranjang => $item_keranjang)
              <!-- data hidden -->
              <input type="hidden" id="keranjang_id_{{ $key }}_{{ $key_keranjang }}" value="{{ $item_keranjang->id }}">

              <div class="flex p-2">
                <div>
                  <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item_keranjang->produk->gambar) }}" alt="gambar produk" class="w-16">
                </div>
                <div class="ml-3">
                  <div class="font-bold">{{ $item_keranjang->produk->nama }}</div>
                  <div class="text-sm text-slate-500">{{ $item_keranjang->qty }} {{ $item_keranjang->produk->satuan }} x <span class="text-xs">Rp</span> @currency($item_keranjang->harga)</div>
                </div>              
              </div>
            @endforeach
          </div>
          <div>
            <div class="flex justify-between p-2">
              <div>
                <div class="text-xs">Total Beli</div>
                <div class="text-sm font-semibold">Rp @currency($item->total)</div>
              </div>
              <div class="flex">
                @if ($item->status == 6)
                  @if ($item_keranjang->dataUlasan)
                    @if (count($item_keranjang->dataUlasan) > 0)
                      <div class="text-emerald-500 italic text-sm">Sudah di ulas</div>
                    @else
                      <a href="{{ route('mUlasan.form', [$item_keranjang->id]) }}" class="btn-ulasan bg-sky-500 py-2 px-7 text-white font-bold text-sm rounded-full">Beri Ulasan</a>
                    @endif
                  @endif
                @endif
              </div>
            </div>
          </div>
          <div class="text-rose-500 italic text-sm font-bold p-2">
            @if ($item->status == 1)
              *Setelah membayar, segera konfirmasi melalui menu Konfirmasi Bayar / <a href="{{ route('konfirmasi_bayar') }}" class="bg-sky-500 ml-2 rounded-full py-1 px-3 text-white ring-offset-1 ring-1 ring-sky-500">Klik Disini</a>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  @else
    <div class="italic text-center text-slate-500 mt-20">- Belum Ada Transaksi -</div>
  @endif
</div>

<!--modal -->
<div
  data-te-modal-init
  class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
  id="modalTransaksiDetail"
  tabindex="-1"
  aria-labelledby="modalTransaksiDetailLabel"
  aria-hidden="true">
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
    <div
      class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4">
        <h5
          class="modal-title text-xl font-medium leading-normal text-neutral-800"
          id="modalTransaksiDetailLabel">
          <!-- title -->
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
      <div class="modal-content relative overflow-y-auto p-4">
        <!-- modal content -->
      </div>
    </div>
  </div>
</div>
@include('layouts.navBawah')

<script>
  /* Storing user's device details in a variable*/
  let details = navigator.userAgent;
  
  /* Creating a regular expression
  containing some mobile devices keywords
  to search it in details string*/
  let regexp = /android|iphone|kindle|ipad/i;
  
  /* Using test() method to search regexp in details
  it returns boolean value*/
  let isMobileDevice = regexp.test(details);
  
  if (!isMobileDevice) {
    window.location.href = "{{ route('akun.transaksi') }}";
  }
</script>

@endsection

@section('script')
<script type="module">
  $(document).ready(function () {
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

    const transaksi_total = $('#transaksi_total').val();
    for (let i_transaksi = 0; i_transaksi < transaksi_total; i_transaksi++) {
      $('.lihat-detail-' + i_transaksi).on('click', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        let url = "{{ route('mTransaksi.detail', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
          url: url,
          type: "get",
          success: function (response) {
            const transaksi = response.transaksi;
            const tgl = response.transaksi.created_at; // tanggal dari DB
            const event = new Date(tgl); // ambil variabel tanggal
            const options = { year: 'numeric', month: 'long', day: 'numeric' } // tentukan jenis tanggal
            const tgl_indo = event.toLocaleDateString('id-ID', options); // output ex. 9 maret 2023

            let val = `
              <div class="flex justify-between border mb-2 rounded p-2">
                <div>${response.transaksi.kode}</div>
                <div>${tgl_indo}</div>
              </div>
              <div>
                <ol class="border-l border-neutral-300">`;
                  $.each(transaksi.data_transaksi_status, function (index_status, item_status) {
                    val += `
                      <li>
                        <div class="flex-start flex items-center pt-3">
                          <div
                            class="-ml-[5px] mr-3 h-[9px] w-[9px] rounded-full bg-neutral-300"></div>
                          <p class="text-sm text-neutral-500 capitalize">
                            ${item_status.data_status.nama}                                                                                                                          
                          </p>
                        </div>
                        <div class="mt-2 ml-4 mb-6">
                          <p class="mb-3 text-neutral-500 text-sm italic">
                            ${item_status.keterangan}
                          </p>
                        </div>
                      </li>                    
                    `;
                  })
                val += `</ol>
              </div>
              <div class="border my-2 rounded p-2">
                <div class="text-sm font-semibold border-b pb-2">Detail Produk</div>`;

                $.each(response.transaksi.data_keranjang, function (index, item) {
                  val += `
                    <div class="flex my-2">
                      <div>
                        <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/${item.produk.gambar}') }}" alt="gambar" class="w-20">
                      </div>
                      <div class="ml-3">
                        <div class="font-semibold">${item.produk.nama}</div>
                        <div class="text-sm">${item.qty} ${item.produk.satuan} x <span class="text-xs">Rp</span> ${afRupiah(item.harga)}</div>
                      </div>
                    </div>
                  `;
                })

                val += `
                <div class="flex justify-between mt-2">
                  <div>
                    <div class="text-sm">Total Harga</div>
                    <div class="text-sm font-semibold"><span class="text-xs">Rp</span> ${afRupiah(response.keranjang_total.total_harga)}</div>
                  </div>
                </div>
              </div>
              <div class="border my-2 rounded p-2">
                <div class="text-sm font-semibold border-b pb-2">Pengiriman</div>
                <div class="mt-2">
                  <div class="flex justify-between">
                    <div class="w-1/4 text-sm">Kurir</div>
                    <div class="w-3/4 text-sm">${transaksi.ekspedisi}</div>
                  </div>
                  <div class="flex justify-between">
                    <div class="w-1/4 text-sm">Alamat</div>
                    <div class="w-3/4 text-sm uppercase">${transaksi.alamat}, kec ${transaksi.data_kecamatan.dis_name}, kab ${transaksi.data_kabupaten.city_name}, ${transaksi.data_provinsi.prov_name}</div>
                  </div>
                </div>
              </div>
              <div class="border my-2 rounded p-2">
                <div class="text-sm font-semibold border-b pb-2">Pembayaran</div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">${transaksi.data_rekening.grup}</div>
                  <div class="w-2/4 text-sm font-bold">${transaksi.data_rekening.nama} (${transaksi.data_rekening.nomor} a.n ${transaksi.data_rekening.atas_nama})
                  </div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Total Harga</div>
                  <div class="w-2/4 text-sm"><span class="text-xs">Rp</span> ${afRupiah(response.keranjang_total.total_harga)}</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Ongkir</div>
                  <div class="w-2/4 text-sm"><span class="text-xs">Rp</span> ${afRupiah(transaksi.ongkir)}</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Diskon</div>
                  <div class="w-2/4 text-sm">`;
                    if (transaksi.diskon) {
                      val += `<span class="text-xs">Rp</span> ${afRupiah(transaksi.diskon)}`;
                    } else {
                      val += `0`;
                    }
                  val += `</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Total Beli</div>
                  <div class="w-2/4 text-lg font-bold"><span class="text-xs">Rp</span> ${afRupiah(transaksi.total)}</div>
                </div>
              </div>
            `;
            $('.modal-title').html('Detail Transaksi');
            $('.modal-content').html(val);
          }
        })
      })
    }
  })
</script>
@endsection