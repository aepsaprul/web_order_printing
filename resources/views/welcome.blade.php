@extends('layouts.app')

@section('title') {{ 'Beranda' }} @endsection

@section('content')

@include('layouts.header')

<div class="lg:flex lg:justify-center">  
  <div class="lg:w-10/12 2xl:w-4/5">
    <div>
      <div class="swiper gambarSlider ">
        <div class="swiper-wrapper">
          @foreach ($slide as $item)
            <div class="swiper-slide">
              <img src="{{ url(env('APP_URL_ADMIN') . '/img_slide/' . $item->gambar) }}" alt="slide">
            </div>            
          @endforeach
        </div>
      </div>
    </div>
    @if ($promo)
    <div>
      <div class="text-center font-bold mt-5 py-3 text-base text-slate-500 bg-white border-b">PROMO</div>
      <div>
        <ul id="promo-list" class="grid grid-cols-2 lg:grid-cols-6 gap-2 lg:m-0">
          @foreach ($promo->dataPromoProduk as $item)
            @if ($item->dataProduk)
              <li class="promo-li bg-white">
                <a href="{{ route('produk.show', [$item->dataProduk->id]) }}">
                  <div>
                    <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item->dataProduk->gambar) }}" alt="gambar" class="w-full">
                  </div>
                  <div class="text-sm text-center">{{ $item->dataProduk->nama }}</div>
                  <div class="m-2">
                    <div class="text-sm font-semibold flex items-center">
                      <div class="bg-red-500 text-center mr-3">
                        <span class="text-md font-semibold text-white p-1 rounded"> 
                          @if ($item->dataPromo->satuan == "persen")
                            {{ $item->dataPromo->diskon }} %</span>
                          @else
                            @currency($item->dataPromo->diskon)</span>  
                          @endif
                      </div>
                      <div>
                        <div class="line-through text-xs">Rp @currency($item->dataProduk->harga)</div>
                      </div>
                    </div>
                    <div class="mt-2">
                      <div class="font-bold text-emerald-900">
                        @if ($item->dataPromo->satuan == "persen")
                          @php
                            $diskon = $item->dataProduk->harga * ($item->dataPromo->diskon / 100);
                          @endphp
                          Rp. @currency($item->dataProduk->harga - $diskon)
                        @else
                          Rp. @currency($item->dataProduk->harga - $item->dataPromo->diskon)
                        @endif
                      </div>
                    </div>
                  </div>
                </a>
              </li>
            @endif
          @endforeach 
        </ul>
        <nav class="promo-pagination-container my-3">  
          <div id="promo-pagination-numbers" class="text-center"></div>
        </nav>
      </div>
    </div>           
    @endif
    <div>
      <h1 class="text-center font-bold mt-5 py-3 text-base text-slate-500 bg-white border-b">KATEGORI PRODUK</h1>
      <div class="grid grid-cols-5 bg-white">
        @foreach ($kategori as $item)
          <a href="{{ route('kategori.show', $item->id) }}">
            <div class="h-full">
              <div class="flex justify-center pt-2">
                <div class="w-10 h-10 lg:w-32 lg:h-32 bg-white rounded-full flex items-center border-2 p-1">
                  <img src="{{ url(env('APP_URL_ADMIN') . '/img_kategori/' . $item->gambar) }}" alt="kategori" class="w-full rounded-full">
                </div>
              </div>
              <div class="text-center capitalize text-xs my-2 lg:text-xl">{{ $item->nama }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    <div>
      <h1 id="produk" class="text-center font-bold mb-1 mt-5 py-3 text-base text-slate-500 bg-white">PRODUK</h1>
      <div>
        <ul id="paginated-list" class="grid grid-cols-2 lg:grid-cols-6 gap-2 lg:m-0">
          @foreach ($produk as $item)            
            <li class="bg-white">
              <a href="{{ route('produk.show', [$item->id]) }}">
                <div>
                  <img src="{{ url(env('APP_URL_ADMIN') . '/img_produk/' . $item->gambar) }}" alt="gambar" class="w-full">
                </div>
                <div class="text-sm text-center">{{ $item->nama }}</div>
                <div class="text-sm font-semibold text-emerald-900 m-2">
                  <span>Rp</span> 
                  <span class="text-lg">
                    @if (in_array($item->id, $promo_arr))
                      @if ($promo->satuan == "persen")
                        @php
                          $diskon = $item->harga * ($promo->diskon / 100);
                        @endphp
                        @currency($item->harga - $diskon)
                      @else
                        @currency($item->harga - $promo->diskon)
                      @endif  
                    @else
                      @currency($item->harga)
                    @endif
                  </span>
                </div>
              </a>
            </li>
          @endforeach
        </ul>  
        <nav class="pagination-container my-3">  
          <div id="pagination-numbers" class="text-center"></div>
        </nav>
      </div>
    </div>
    <div>
      <h1 class="text-center font-bold mt-5 py-3 text-base text-slate-500 bg-white border-b">CARA PESAN</h1>
      <div class="lg:flex lg:justify-between bg-white">
        <div class="lg:w-2/4 lg:flex lg:justify-center lg:items-center">
          <img src="{{ url(env('APP_URL_ADMIN') . '/img_cara_pesan_gambar/' . $cara_pesan_gambar->gambar) }}" alt="gambar cara pesan" class="hidden lg:block lg:w-60 h-80">
        </div>
        <div class="lg:w-2/4 lg:flex lg:items-center lg:justify-center">
          <div class="lg:w-4/5 py-2">
            @foreach ($cara_pesan as $key => $item)
              <div class="bg-slate-600 text-white m-3 p-2 rounded-sm"><p>{{ $key + 1 }}. {{ $item->nama }}</p></div>
            @endforeach          
          </div>
        </div>
      </div>
    </div>
    <div class="md:hidden w-full h-14"></div>
  </div>
</div> 

@include('layouts.navBawah')
@include('layouts.footer')

@endsection

@section('script')
<script>
  // slider
  var swiper = new Swiper(".gambarSlider", {
    pagination: {
      el: ".swiper-pagination",
      clickable: true
    },
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false
    }
  });

  // pagination
  const promoPaginationNumbers = document.getElementById('promo-pagination-numbers');
  const promoList = document.getElementById('promo-list');
  const promoListItems = promoList.querySelectorAll('.promo-li');

  const paginationNumbers = document.getElementById("pagination-numbers");
  const paginatedList = document.getElementById("paginated-list");
  const listItems = paginatedList.querySelectorAll("li");

  /* Storing user's device details in a variable*/
  let details = navigator.userAgent;
  
  /* Creating a regular expression
  containing some mobile devices keywords
  to search it in details string*/
  let regexp = /android|iphone|kindle|ipad/i;
  
  /* Using test() method to search regexp in details
  it returns boolean value*/
  let isMobileDevice = regexp.test(details);
  
  let promoPaginationLimit;
  let paginationLimit;
  if (isMobileDevice) {
    promoPaginationLimit = 10;
    paginationLimit = 10;
  } else {
    promoPaginationLimit = 12;
    paginationLimit = 18;
  }
  
  const promoPageCount = Math.ceil(promoListItems.length / promoPaginationLimit);
  const pageCount = Math.ceil(listItems.length / paginationLimit);

  let promoCurrentPage = 1;
  let currentPage = 1;

  const promoAppendPageNumber = (index) => {
    const pageNumber = document.createElement("button");
    pageNumber.className = "promo-pagination-number px-3 m-0.5 border border-slate-600";
    pageNumber.innerHTML = index;
    pageNumber.setAttribute("promo-page-index", index);
    pageNumber.setAttribute("aria-label", "Page " + index);

    promoPaginationNumbers.appendChild(pageNumber);
  };

  const appendPageNumber = (index) => {
    const pageNumber = document.createElement("button");
    pageNumber.className = "pagination-number px-3 m-0.5 border border-slate-600";
    pageNumber.innerHTML = index;
    pageNumber.setAttribute("page-index", index);
    pageNumber.setAttribute("aria-label", "Page " + index);

    paginationNumbers.appendChild(pageNumber);
  };

  const promoGetPaginationNumbers = () => {
    for (let i = 1; i <= promoPageCount; i++) {
      promoAppendPageNumber(i);
    }
  };

  const getPaginationNumbers = () => {
    for (let i = 1; i <= pageCount; i++) {
      appendPageNumber(i);
    }
  };

  const promoHandleActivePageNumber = () => {
    document.querySelectorAll(".promo-pagination-number").forEach((button) => {
      button.classList.remove("active", "bg-yellow-400");
      const pageIndex = Number(button.getAttribute("promo-page-index"));
      if (pageIndex == promoCurrentPage) {
        button.classList.add("active", "bg-yellow-400");
      }
    });
  };

  const handleActivePageNumber = () => {
    document.querySelectorAll(".pagination-number").forEach((button) => {
      button.classList.remove("active", "bg-yellow-400");
      const pageIndex = Number(button.getAttribute("page-index"));
      if (pageIndex == currentPage) {
        button.classList.add("active", "bg-yellow-400");
      }
    });
  };

  const promoSetCurrentPage = (pageNum) => {
    promoCurrentPage = pageNum;
    promoHandleActivePageNumber();

    const prevRange = (pageNum - 1) * promoPaginationLimit;
    const currRange = pageNum * promoPaginationLimit;

    promoListItems.forEach((item, index) => {
      item.classList.add("hidden");
      if (index >= prevRange && index < currRange) {
        item.classList.remove("hidden");
      }
    });
  };

  const setCurrentPage = (pageNum) => {
    currentPage = pageNum;
    handleActivePageNumber();

    const prevRange = (pageNum - 1) * paginationLimit;
    const currRange = pageNum * paginationLimit;

    listItems.forEach((item, index) => {
      item.classList.add("hidden");
      if (index >= prevRange && index < currRange) {
        item.classList.remove("hidden");
      }
    });
  };

  window.addEventListener("load", () => {
    promoGetPaginationNumbers();
    getPaginationNumbers();
    promoSetCurrentPage(1);
    setCurrentPage(1);

    document.querySelectorAll(".promo-pagination-number").forEach((button) => {
      const promoPageIndex = Number(button.getAttribute("promo-page-index"));

      if (promoPageIndex) {
        button.addEventListener("click", () => {
          promoSetCurrentPage(promoPageIndex);
        });
      }
    });

    document.querySelectorAll(".pagination-number").forEach((button) => {
      const pageIndex = Number(button.getAttribute("page-index"));

      if (pageIndex) {
        button.addEventListener("click", () => {
          setCurrentPage(pageIndex);
        });
      }
    });
  });

  const btn_page_promo = document.getElementById('promo-pagination-numbers').onclick = function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  };

  const btn_page = document.getElementById('pagination-numbers').onclick = function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  };

</script>
@endsection