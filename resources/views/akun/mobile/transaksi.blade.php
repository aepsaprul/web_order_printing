@extends('layouts.app')

@section('content')

@include('layouts.header')

<div>
  {{-- data hidden --}}
  <input type="hidden" name="transaksi_total" id="transaksi_total" value="{{ $transaksi->count() }}">

  @foreach ($transaksi as $key => $item)
  <div class="m-3">
    <div class="border rounded-md">
      <div class="flex justify-between border-b p-2">
        <div>
          <div>
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
            <button class="lihat-detail-{{ $key }} text-sky-400 font-semibold border my-1 px-2 rounded"
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
        @foreach ($item->dataKeranjang as $item_keranjang)
          <div class="flex p-2">
            <div>
              <img src="{{ url('http://localhost/abata_web_order_admin/public/img_produk/' . $item_keranjang->produk->gambar) }}" alt="gambar produk" class="w-16">
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
            <button class="bg-sky-500 text-white text-sm font-semibold rounded px-3 ml-2 w-24">Ulas</button>
            <button class="border border-sky-500 text-sm font-semibold rounded px-3 ml-2 w-24">Beli Lagi</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
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
      class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
        <h5
          class="modal-title text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
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
            console.log(response)
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
              <div class="border my-2 rounded p-2">
                <div class="text-sm font-semibold border-b pb-2">Detail Produk</div>`;

                $.each(response.transaksi.data_keranjang, function (index, item) {
                  val += `
                    <div class="flex my-2">
                      <div>
                        <img src="{{ url('http://localhost/abata_web_order_admin/public/img_produk/${item.produk.gambar}') }}" alt="gambar" class="w-20">
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
                    <div class="font-semibold"><span class="text-xs">Rp</span> ${afRupiah(response.keranjang_total.total_harga)}</div>
                  </div>
                  <div class="flex items-center">
                    <button class="rounded border border-sky-600 text-sm py-1 px-3 font-bold">Beli Lagi</button>
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
                  <div class="w-2/4 text-sm">${transaksi.data_rekening.nama}</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Total Harga</div>
                  <div class="w-2/4 text-sm">${afRupiah(response.keranjang_total.total_harga)}</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Ongkir</div>
                  <div class="w-2/4 text-sm">${afRupiah(transaksi.ongkir)}</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Diskon</div>
                  <div class="w-2/4 text-sm">`;
                    if (transaksi.diskon) {
                      val += `${afRupiah(transaksi.diskon)}`;
                    } else {
                      val += `0`;
                    }
                  val += `</div>
                </div>
                <div class="p-1 flex justify-between">
                  <div class="w-2/4 text-sm capitalize">Total Beli</div>
                  <div class="w-2/4 text-sm">${afRupiah(transaksi.total)}</div>
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