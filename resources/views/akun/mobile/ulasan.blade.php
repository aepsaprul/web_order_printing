@extends('layouts.app')

@section('content')

@include('layouts.header')

<div class="bg-white p-3 rounded border">
  <h3 class="font-bold text-lg text-center">Ulasan</h3>
</div>
<div id="ulasan_page" class="flex mt-2 mb-8">
  <div class="w-full">
    <ul
      class="flex list-none flex-row flex-wrap border-b-0 pl-0 bg-white"
      role="tablist"
      data-te-nav-ref>
      <li role="presentation">
        <a
          href="#tabs-home"
          class="block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-bold uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
          data-te-toggle="pill"
          data-te-target="#tabs-home"
          data-te-nav-active
          role="tab"
          aria-controls="tabs-home"
          aria-selected="true"
          >Daftar Ulasan</a
        >
      </li>
      <li role="presentation">
        <a
          href="#tabs-profile"
          class="focus:border-transparen block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-bold uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
          data-te-toggle="pill"
          data-te-target="#tabs-profile"
          role="tab"
          aria-controls="tabs-profile"
          aria-selected="false"
          >Ulasan Saya</a
        >
      </li>
    </ul>
    <div class="mb-6 bg-white border rounded">
      <div
        class="hidden transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="tabs-home"
        role="tabpanel"
        aria-labelledby="tabs-home-tab"
        data-te-tab-active>
        <div class="grid grid-cols-2">
          @foreach ($transaksi as $item)
            @foreach ($item->dataKeranjang as $item_keranjang)
              @if ($item->status == 6)
                @if ($item_keranjang->dataUlasan)
                  @if (count($item_keranjang->dataUlasan) <= 0)
                    <div class="flex m-2 p-2 border rounded-md">
                      <div class="w-1/3">
                        <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item_keranjang->produk->gambar) }}" alt="gambar produk" class="w-full">
                      </div>
                      <div class="w-2/3">
                        <div class="w-full h-1/2">
                          <div class="ml-3 text-sm">{{ $item_keranjang->produk->nama }}</div>
                        </div>
                        <div class="w-full h-1/2 flex items-center justify-center">
                          <a href="{{ route('mUlasan.form', [$item_keranjang->id]) }}" class="btn-ulasan bg-sky-500 text-white font-bold text-xs py-1 px-3 mt-3 rounded-full">Beri Ulasan</a>
                        </div>
                      </div>
                    </div>
                  @endif
                @endif
              @endif
            @endforeach
          @endforeach
        </div>
      </div>
      <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="tabs-profile"
        role="tabpanel"
        aria-labelledby="tabs-profile-tab">
        <div class="grid grid-cols-2">
          @foreach ($ulasan as $item_ulasan)
            <div class="flex m-2 p-2 border rounded-md">
              <div class="w-1/3">
                <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item_ulasan->dataProduk->gambar) }}" alt="gambar produk" class="w-full">
              </div>
              <div class="w-2/3">
                <div class="w-full h-1/2">
                  <div class="ml-3 text-sm">{{ $item_ulasan->dataProduk->nama }}</div>
                  <div class="ml-3">
                    <div class="text-slate-300 text-2xl">
                      <i class="fas fa-star text-xs cursor-pointer {{ 1 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star text-xs cursor-pointer {{ 2 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star text-xs cursor-pointer {{ 3 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star text-xs cursor-pointer {{ 4 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                      <i class="fas fa-star text-xs cursor-pointer {{ 5 <= $item_ulasan->rating ? 'text-yellow-500' : '' }}"></i>
                    </div>
                  </div>
                  <div class="ml-3 text-sm">{{ $item_ulasan->keterangan }}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal ulasan -->
<div
  data-te-modal-init
  class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
  id="modalUlasan"
  tabindex="-1"
  aria-labelledby="modalUlasanLabel"
  aria-hidden="true">
  <div
    data-te-modal-dialog-ref
    class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
    <div
      class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">
      <div
        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4">
        
        <!-- notif -->
        <div id="notif" class="hidden fixed right-10 mt-10 z-40">
          <div class="bg-emerald-500 w-86 py-2 px-5 rounded text-center text-white ease-in-out duration-300"><span class="font-bold">Berhasil</span>, Terimakasih atas ulasannya <i class="fa fa-check font-bold text-xl text-lime-300 ml-3"></i></div>
        </div>

        <h5
          class="modal-title text-xl font-medium leading-normal text-neutral-800"
          id="modalUlasanLabel">
          <!-- title -->
          Ulasan
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
      <div class="modal-content-ulasan modal-content relative overflow-y-auto p-4">
        <!-- modal content -->
        <input type="hidden" id="keranjang_id">
        <input type="hidden" id="produk_id">
        <div>
          <div class="stars text-slate-300 text-2xl">
            <i class="fas fa-star cursor-pointer" data-id="1"></i>
            <i class="fas fa-star cursor-pointer" data-id="2"></i>
            <i class="fas fa-star cursor-pointer" data-id="3"></i>
            <i class="fas fa-star cursor-pointer" data-id="4"></i>
            <i class="fas fa-star cursor-pointer" data-id="5"></i>
          </div>
          <em class="error-star text-rose-500 text-sm"></em>
          <input type="hidden" id="star_val" value="0">
        </div>
        <div class="mt-4">
          <textarea name="catatan" id="catatan" rows="3" placeholder="Catatan" class="border w-full p-2 rounded outline-none"></textarea>
        </div>
        <div class="mt-3 flex justify-end">
          <div class="w-32 rounded relative flex items-center justify-center">
            <div id="loading_kirim" class="hidden absolute">
              <div class="flex items-center">
                <div class="flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-slate-100 animate-spin mr-3">
                  <div class="h-2 w-2 rounded-full bg-white"></div>
                </div>
                <span class="text-xs">Loading. . .</span>
              </div>
            </div>
            <button id="ulasan_btn_kirim" class="w-44 bg-sky-500 border rounded text-white text-sm font-bold py-2"><i class="fa fa-paper-plane"></i> Kirim</button>
          </div>
        </div>
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
    window.location.href = "{{ route('akun.ulasan') }}";
  }
</script>

@endsection